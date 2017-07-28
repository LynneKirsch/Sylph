<?php

namespace Application\Controller;

use Application\Core\BaseController;
use Application\Model\Page;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\HttpFoundation\JsonResponse;

class PageController extends BaseController
{
    public function pageAdmin()
    {
        $pages = $this->model()->findBy(["type" => TYPE_PAGE]);
        $this->view("admin/pages", ["pages" => $pages]);
    }

    public function postAdmin()
    {
        $pages = $this->model()->findBy(["type" => TYPE_POST]);
        $this->view("admin/pages", ["pages" => $pages]);
    }

    public function edit($id)
    {
        $page = $this->model()->findOneBy(["page_id" => $id]);

        /* @var \Application\Model\Page $page */
        if ($page) {
            $page->setContent(html_entity_decode($page->getContent()));
            $this->view("admin/edit_page", $page)->loadJs(["editor", "page"]);
        } else {
            $this->view("404");
        }
    }

    public function getPostList($page = 1)
    {
        $sql = $this->sql()
            ->select('COUNT(page_id)')
            ->from(MODEL_PAGE, 'posts')
            ->where("type = ".TYPE_POST);

        $post_count = $sql->getQuery()->getResult();
        $num_pages = ceil($post_count / POST_LIMIT);
        $posts = $this->model()->findBy(["type" => TYPE_POST], ["date" => "DESC"], POST_LIMIT, (($page - 1) * POST_LIMIT));
    }

    public function newPage()
    {
        $page = new Page();
        $this->write($page->setupNew());
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