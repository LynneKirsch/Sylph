<?php

namespace Application\Controller;

use Application\Core\BaseController;
use Application\Model\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserController extends BaseController
{
    public function admin()
    {
        if ($this->authenticate()) {
            $users = $this->model(MODEL_USER)->findAll();
            $this->view("admin/users", ["users" => $users]);
        } else {
            $this->view("permission_denied");
        }

        return $this->renderPage();
    }

    public function updateUser($id = 0)
    {
        /* @var User $user */
        $user = $this->model(MODEL_USER)->find($id) ?? new User();
        $user->setUsername($this->post()->get("username"));
        $user->setPassword(password_hash($this->post()->get("password"), PASSWORD_BCRYPT));
        $this->write($user);
        return new RedirectResponse(BASEPATH . "admin/users");
    }
}