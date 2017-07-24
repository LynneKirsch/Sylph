<?php

namespace Application\Controller;
use Application\Core\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $this->view("index", ["name"=>"lynne"]);
    }
}