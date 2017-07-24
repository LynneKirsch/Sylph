<?php

namespace Application\Controller;

use Application\Core\BaseController;
use Application\Model\Page;

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

    public function savePage($id)
    {
        $page = $this->model()->find($id) ?? new Page();
        $page->load($this->post()->all());
        $this->write($page);
    }

    public function getPageFromSlug(string $slug)
    {
        $page = $this->model()->findOneBy(["slug" => $slug]);
        $this->displayPage($page);
    }

    public function getPageFromID(int $id)
    {
        $page = $this->model()->findOneBy(["page_id" => $id]);
        $this->displayPage($page);
    }

    public function displayPage($page)
    {
        $page ? $this->view("page", $page) : $this->view("404");
    }
}