<?php

namespace Application\Core;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;


class BaseController
{
    private $html = null;
    private $app;
    private $model = null;
    private $page_title = null;
    private $js = [];

    public function __construct($app)
    {
        $this->setApp($app);
    }

    /**
     * @param $js
     * @return $this
     */
    public function loadJs($js)
    {
        $this->js = $js;
        return $this;
    }

    public function write($obj)
    {
        $this->app()->em()->persist($obj);
        $this->app()->em()->flush();
    }

    public function delete($obj)
    {
        if($obj) {
            $this->app()->em()->remove($obj);
            $this->app()->em()->flush();
        }
    }

    public function model($model = null)
    {
        if (!$model) {
            if (!$this->getModel()) {
                die('$this->model() called with no model to reference.');
            }

            $model = $this->getModel();
        }


        return $this->app()->em()->getRepository(MODEL_NS . $model);
    }

    public function post()
    {
        return $this->app()->getRequest()->request;
    }

    public function query()
    {
        return $this->app()->getRequest()->query;
    }

    /**
     * @param $name
     * @return UploadedFile
     */
    public function file($name)
    {
        return $this->app()->getRequest()->files->get($name);
    }

    public function session()
    {
        return $this->app()->getSession();
    }

    public function redirect($path)
    {
        return new RedirectResponse(ROOT . $path);
    }

    public function view($template, $context = [])
    {
        $this->appendHTML($this->render($template, $context));
        return $this;
    }

    public function render($template, $context = [])
    {
        $data = [
            "data" => $context,
            "global" => $this->getGlobalVars()
        ];

        $tpl = $this->app()->getM()->loadTemplate($template);
        return $tpl->render($data);
    }

    public function getHeader()
    {
        $context = [
            "global" => $this->getGlobalVars(),
            "data" => [
                "pages" => $this->model("Page")->findBy(["type" => TYPE_PAGE])
            ]
        ];

        $tpl = $this->app()->getM()->loadTemplate("_template/header");
        return $tpl->render($context);
    }

    public function getFooter()
    {
        $context = [
            "global" => $this->getGlobalVars(),
            "js" => $this->js
        ];

        $tpl = $this->app()->getM()->loadTemplate("_template/footer");
        return $tpl->render($context);
    }

    public function getGlobalVars()
    {
        $context['basepath'] = ROOT;
        $context['logged_in'] = $this->session()->get("logged_in");
        $context['page_title'] = $this->getPageTitle();
        return $context;
    }

    public function renderPage()
    {
        return new Response($this->getHeader() . $this->getHTML() . $this->getFooter());
    }

    public function response($content)
    {
        return new Response($content);
    }

    public function config($config_key)
    {
        $config = $this->model("Config")->findOneBy([
            "config_code" => $config_key
        ]);

        if($config) {
            return $config->getConfigVal();
        }

        return null;
    }
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function sql()
    {
        return $this->app()->em()->createQueryBuilder();
    }

    /**
     * @return App
     */
    public function app()
    {
        return $this->app;
    }

    public function setApp($app)
    {
        $this->app = $app;
    }

    public function getHTML()
    {
        return $this->html;
    }

    public function appendHTML($html)
    {
        return $this->html .= $html;
    }

    /**
     * @return null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param null $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return null
     */
    public function getPageTitle()
    {
        return $this->page_title;
    }

    /**
     * @param null $page_title
     */
    public function setPageTitle($page_title)
    {
        $this->page_title = $page_title;
    }
}