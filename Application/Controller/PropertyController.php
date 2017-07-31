<?php

namespace Application\Controller;

use Application\Core\BaseController;
use Application\Model\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PropertyController extends BaseController
{
    public function admin()
    {
        $users = $this->model()->findAll();
        $this->view("admin/users", ["users" => $users]);
        return $this->renderPage();
    }

    public function index()
    {

    }
}