<?php

namespace Application\Controller;
use Application\Core\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $page = $this->model("Page")->findOneBy(["page_id" => HOMEPAGE]);
        $this->view("index", ["page"=>$page]);
    }
}