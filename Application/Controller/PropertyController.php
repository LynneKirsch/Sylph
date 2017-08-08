<?php

namespace Application\Controller;

use Application\Core\BaseController;
use Application\Model\Property;
use Application\Model\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PropertyController extends BaseController
{
    public function admin()
    {
        $properties = $this->model()->findAll();
        $this->view("admin/properties", ["properties" => $properties]);
        return $this->renderPage();
    }

    public function newProperty()
    {
        $property = new Property();
        $property->setupNew();
        $this->write($property);
        return $this->redirect("admin/property/".$property->getPropertyId());
    }

    public function saveProperty()
    {
        $property = $this->model()->findOneBy(["property_id" => $this->post()->get("property_id")]);

        /* @var Property $property */
        if($property) {
            $property->setAddress1($this->post()->get("address1"));
            $property->setAddress2($this->post()->get("address2"));
            $property->setBathrooms($this->post()->get("bathrooms"));
            $property->setBedrooms($this->post()->get("bedrooms"));
            $property->setHalfBaths($this->post()->get("half_baths"));
            $property->setAvailable(
                $this->post()->get("day") .
                $this->post()->get("month") .
                $this->post()->get("year")
            );

            $gallery = [];
            /* @var UploadedFile $image */
            foreach($this->file("gallery") as $image) {
                if($image) {
                    $id = uniqid(date("YmdHis"));
                    $gallery[$id]['id'] = $id;
                    $gallery[$id]['src'] = "data:".$image->getMimeType().";base64,"
                        .base64_encode(file_get_contents($image->getPathname()));
                }
            }

            $cur_gal = $this->post()->get("gallery_img");
            if($cur_gal) {
                foreach($cur_gal as $gal_img) {
                    $id = uniqid(date("YmdHis"));
                    $gallery[$id]['id'] = $id;
                    $gallery[$id]['src'] = $gal_img;
                }
            }

            $property->setGallery(json_encode(array_values($gallery)));

            $featured = $this->file("feature_image");
            if($featured) {
                $property->setFeatureImage("data:".$featured->getMimeType().";base64,"
                    .base64_encode(file_get_contents($featured->getPathname())));
            } else {
                $property->setFeatureImage($this->post()->get("feature_image"));
            }

            $this->write($property);
            return $this->redirect("admin/property/".$property->getPropertyId());
        } else {
            $this->view("404");
        }
    }

    public function editProperty($id)
    {
        $property = $this->model()->findOneBy(["property_id" => $id]);
        $data = [
            "property" => $property,
            "months" => range(1, 12),
            "days" => range(1, 31),
            "years" => range(2017, 2020)
        ];

        /* @var \Application\Model\Property $property */
        if ($property) {
            $this->view("admin/edit_property", $data)->loadJs(["property"]);
        } else {
            $this->view("404");
        }
    }

    public function searchProperties()
    {
        $query = [];
        $beds = $this->post()->get("beds");
        $baths = $this->post()->get("baths");
        $half = $this->post()->get("half");

        if($beds && $beds != 'all') {
            $query['beds'] = $beds;
        }

        if($baths && $baths != 'all') {
            $query['baths'] = $baths;
        }

        if($half && $half != 'all') {
            $query['half'] = $half;
        }

        $data['data']['properties'] = $this->model()->findBy($query);
        $view = $this->app()->getM()->render("partials/property-lst", $data);

        return new JsonResponse(["properties" => $view]);
    }

    public function index()
    {
        $properties = $this->model()->findAll();
        $this->view("properties", ["properties" => $properties]);
    }
}