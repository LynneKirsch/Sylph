<?php

namespace Application\Controller;

use Application\Core\BaseController;
use Application\Model\Page;
use Symfony\Component\HttpFoundation\JsonResponse;

class PageController extends BaseController
{
    public function admin()
    {
        if ($this->authenticate()) {
            $pages = $this->model()->findAll();
            $this->view("admin/pages", ["pages" => $pages]);
        } else {
            $this->view("404");
        }
    }

    public function edit($id)
    {
        $page = $this->model()->findOneBy(["page_id" => $id]);
        $page ? $this->view("admin/edit_page", $page) : $this->view("404");
    }

    public function newPage()
    {
        $page = new Page();
        $page->setContent("");
        $page->setSlug("");
        $page->setTitle("");
        $this->write($page);
        return $this->redirect("admin/page/".$page->getPageId());
    }

    public function savePage($id)
    {
        $page = $this->model()->find($id) ?? new Page();
        
        echo '<pre>';
        print_r($this->post()->get("content"));
        echo '</pre>';

        $page->load($this->post()->all());
        $this->write($page);

        return new JsonResponse(["time" => date("g:i A")]);
    }

    public function displayPage($slug)
    {
        $page = $this->model()->findOneBy(["slug" => $slug]);
        $this->setPageTitle($page ? $page->getTitle() : "Blank Page");
        $page ? $this->view("page", $page) : $this->view("404");
    }
}