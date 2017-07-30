<?php

namespace Application\Controller;

use Application\Core\BaseController;

class ConfigController extends BaseController
{
    public function admin()
    {
        $config = $this->model()->findAll();
        $this->view("admin/config", ["config" => $config]);
        return $this->renderPage();
    }

    public function update($id)
    {
        $config = $this->model()->findOneBy(["config_id" => $id]);
        $config->setConfigVal($this->post()->get("config_val"));
        $this->write($config);
        return $this->redirect("admin/config");
    }
}