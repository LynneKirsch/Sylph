<?php

namespace Application\Controller;

use Application\Core\BaseController;
use Application\Model\Page;
use Symfony\Component\HttpFoundation\JsonResponse;

class PageController extends BaseController
{
    public function admin()
    {
        $pages = $this->model()->findAll();
        $this->view("admin/pages", ["pages" => $pages]);
    }

    public function edit($id)
    {
        $page = $this->model()->findOneBy(["page_id" => $id]);

        /* @var \Application\Model\Page $page */
        if ($page) {
            $page->setContent(html_entity_decode($page->getContent()));
            $this->view("admin/edit_page", $page);
        } else {
            $this->view("404");
        }
    }

    public function newPage()
    {
        $page = new Page();
        $page->setContent("");
        $page->setSlug("");
        $page->setTitle("");
        $this->write($page);
        return $this->redirect("admin/page/" . $page->getPageId());
    }

    public function savePage($id)
    {
        $post_obj = json_decode($_POST['form']);

        $page = $this->model()->find($id) ? $this->model()->find($id) : new Page();
        $page->setContent(filter_var($post_obj->html, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $page->setTitle($post_obj->title);
        $page->setSlug($post_obj->slug);
        $page->setDelta(json_encode($post_obj->delta->ops));
        $this->write($page);
        return new JsonResponse(["time" => date("g:i A")]);
    }

    public function displayPage($slug)
    {
        $page = $this->model()->findOneBy(["slug" => $slug]);

        /* @var \Application\Model\Page $page */
        if ($page) {
            $this->setPageTitle($page->getTitle());
            $page->setContent(html_entity_decode($page->getContent(), ENT_QUOTES));
            $this->view("page", $page);
        } else {
            $this->view("404");
        }
    }
}