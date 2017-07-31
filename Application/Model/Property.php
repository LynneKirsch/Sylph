<?php
namespace Application\Model;

use Application\Core\BaseModel;

/**
 * Application/Model/User.php
 *
 * @Entity @Table(name="`properties`")
 */
class Property extends BaseModel
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    private $property_id;
    /** @Column(type="string") * */
    private $address1;
    /** @Column(type="string") * */
    private $address2;
    /** @Column(type="integer") * */
    private $bedrooms;
    /** @Column(type="integer") * */
    private $bathrooms;
    /** @Column(type="integer") * */
    private $half_baths;
    /** @Column(type="integer") * */
    private $rent;
    /** @Column(type="integer") * */
    private $available;
    /** @Column(type="integer") * */
    private $active;
    /** @Column(type="text") * */
    private $gallery;
    /** @Column(type="text") * */
    private $feature_image;

    public function setupNew()
    {
        $this->address1 = "";
        $this->address2 = "";
        $this->bedrooms = 0;
        $this->bathrooms = 0;
        $this->half_baths = 0;
        $this->rent = 0;
        $this->available = 0;
        $this->active = 0;
    }

    public function getGalleryArray()
    {
        return json_decode($this->gallery);
    }

    /**
     * @return mixed
     */
    public function getPropertyId()
    {
        return $this->property_id;
    }

    /**
     * @param mixed $property_id
     */
    public function setPropertyId($property_id)
    {
        $this->property_id = $property_id;
    }

    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param mixed $address1
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param mixed $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * @return mixed
     */
    public function getBedrooms()
    {
        return $this->bedrooms;
    }

    /**
     * @param mixed $bedrooms
     */
    public function setBedrooms($bedrooms)
    {
        $this->bedrooms = $bedrooms;
    }

    /**
     * @return mixed
     */
    public function getBathrooms()
    {
        return $this->bathrooms;
    }

    /**
     * @param mixed $bathrooms
     */
    public function setBathrooms($bathrooms)
    {
        $this->bathrooms = $bathrooms;
    }

    /**
     * @return mixed
     */
    public function getHalfBaths()
    {
        return $this->half_baths;
    }

    /**
     * @param mixed $half_baths
     */
    public function setHalfBaths($half_baths)
    {
        $this->half_baths = $half_baths;
    }

    /**
     * @return mixed
     */
    public function getRent()
    {
        return $this->rent;
    }

    /**
     * @param mixed $rent
     */
    public function setRent($rent)
    {
        $this->rent = $rent;
    }

    /**
     * @return mixed
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @param mixed $available
     */
    public function setAvailable($available)
    {
        $this->available = $available;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param mixed $gallery
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;
    }

    /**
     * @return mixed
     */
    public function getFeatureImage()
    {
        return $this->feature_image;
    }

    /**
     * @param mixed $feature_image
     */
    public function setFeatureImage($feature_image)
    {
        $this->feature_image = $feature_image;
    }
}