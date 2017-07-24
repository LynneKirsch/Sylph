<?php

namespace Application\Controller;

use Application\Core\BaseController;
use Application\Model\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends BaseController
{
    public function index()
    {
        $data = [
            "login_error" => $this->session()->get("login_error"),
            "logged_in" => $this->session()->get("logged_in"),
            "username" => $this->session()->get("username")
        ];

        $this->view('login', $data);
    }

    public function processLogin()
    {
        /* @var User $user */
        $user = $this->model(MODEL_USER)->findOneBy(
            [
                "username" => $this->post()->get("username")
            ]
        );

        if (!is_null($user)) {
            if (password_verify($this->post()->get("password"), $user->getPassword())) {
                $this->session()->set("logged_in", true);
                $this->session()->set("username", $user->getUsername());
                $this->session()->set("auth", bin2hex(random_bytes(64)));
                $this->session()->remove("login_error");
                return new RedirectResponse(BASEPATH);
            } else {
                $this->session()->set("login_error", "Invalid password.");
            }
        } else {
            $this->session()->set("login_error", "No such user");
        }

        $this->session()->set("logged_in", false);
        $this->session()->remove("username");
        $this->session()->remove("auth");
        return new RedirectResponse(BASEPATH . "login");
    }

    public function processLogout()
    {
        $this->session()->set("logged_in", false);
        $this->session()->remove("username");
        $this->session()->remove("auth");
        return new RedirectResponse(BASEPATH . "login");
    }
}