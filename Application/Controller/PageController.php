<?php

namespace Application\Controller;

use Application\Core\BaseController;
use Application\Model\Page;
use Application\Model\Slideshow;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\HttpFoundation\JsonResponse;

class PageController extends BaseController
{
    public function pageAdmin()
    {
        $pages = $this->model()->findBy(["type" => TYPE_PAGE]);
        $this->view("admin/pages", ["pages" => $pages])->loadJs(["page"]);
    }

    public function postAdmin()
    {
        $pages = $this->model()->findBy(["type" => TYPE_POST]);
        $this->view("admin/posts", ["pages" => $pages])->loadJs(["page"]);
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

    public function deletePage($id)
    {
        $page = $this->model()->find($id);
        $this->delete($page);
    }

    public function newPage()
    {
        $page = new Page();
        $this->write($page->setupNew(TYPE_PAGE));
        return $this->redirect("admin/page/" . $page->getPageId());
    }

    public function newPost()
    {
        $page = new Page();
        $this->write($page->setupNew(TYPE_POST));
        return $this->redirect("admin/page/" . $page->getPageId());
    }

    public function addSlideShow($id)
    {
        $page = $this->model()->findOneBy(["page_id" => $id]);

        /* @var Page $page */
        if($page) {
            $slideshow = new Slideshow();
            $this->write($slideshow);

            $page->setSlideshowId($slideshow->getSlideshowId());
            $this->write($page);
        }

        return $this->redirect("admin/page/" . $page->getPageId());
    }

    public function saveSlideShow()
    {
        $json_obj = [];

        foreach($this->post()->get("url") as $key => $url)
        {
            $json_obj[$key]['img_url'] = $url;
            $json_obj[$key]['caption'] = $this->post()->get("caption")[$key];
            $json_obj[$key]['to_link'] = $this->post()->get("link")[$key];
        }

        /* @var Slideshow $slideshow */
        $slideshow = $this->model("Slideshow")->findOneBy(["slideshow_id" => $this->post()->get("slideshow_id")]);
        $slideshow->setJson(json_encode($json_obj));
        $this->write($slideshow);

        return $this->redirect("admin/page/" . $this->post()->get("page_id"));
    }

    public function savePage($id)
    {
        $post_obj = json_decode($_POST['form']);

        /* @var Page $page */
        $page = coalesce($this->model()->find($id), new Page());
        $page->setContent(filter_var($post_obj->html, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $page->setTitle($post_obj->title);
        $page->setSlug($post_obj->slug);
        $page->setShowModal($post_obj->modal->show_modal);
        $page->setModalContent($post_obj->modal->modal_content);
        $page->setModalHeader($post_obj->modal->modal_header);
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
            $this->view("page", $page);
        } else {
            $this->view("404");
        }
    }


}