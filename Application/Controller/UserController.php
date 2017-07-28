<?php

namespace Application\Controller;

use Application\Core\BaseController;
use Application\Model\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserController extends BaseController
{
    public function admin()
    {
        $users = $this->model()->findAll();
        $this->view("admin/users", ["users" => $users]);
        return $this->renderPage();
    }

    public function updateUser($id = 0)
    {
        /* @var User $user */
        $user = coalesce($this->model()->find($id), new User());
        $user->setUsername($this->post()->get("username"));
        $user->setPassword(password_hash($this->post()->get("password"), PASSWORD_BCRYPT));
        $this->write($user);
        return new RedirectResponse(ROOT."admin/users");
    }
}