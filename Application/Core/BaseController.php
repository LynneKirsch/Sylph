<?php

namespace Application\Core;

use Doctrine\ORM\EntityRepository;
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

    public function __construct(App $app)
    {
        $this->setApp($app);
    }

    public function authenticate()
    {
        if($this->session()->get("logged_in")) {
            return true;
        }

        return false;
    }

    public function write(BaseModel $obj)
    {
        $this->app()->em()->persist($obj);
        $this->app()->em()->flush();
    }

    public function delete(BaseModel $obj)
    {
        $this->app()->em()->remove($obj);
        $this->app()->em()->flush();
    }

    public function model($model = null): EntityRepository
    {
        if(!$model) {
            if(!$this->getModel()) {
                die('$this->model() called with no model to reference.');
            }

            $model = $this->getModel();
        }

        return $this->app()->em()->getRepository(MODEL_NS . $model);
    }

    public function post(): ParameterBag
    {
        return $this->app()->getRequest()->request;
    }

    public function query(): ParameterBag
    {
        return $this->app()->getRequest()->query;
    }

    public function session(): Session
    {
        return $this->app()->getSession();
    }

    public function redirect($path)
    {
        return new RedirectResponse(BASEPATH.$path);
    }

    public function view($template, $context = [])
    {
        $data = [
            "data" => $context,
            "global" => $this->getGlobalVars()
        ];

        $tpl = $this->app()->getM()->loadTemplate($template);
        $this->appendHTML($tpl->render($data));
    }

    public function getHeader()
    {
        $pages = $this->model(MODEL_PAGE)->findAll();
        $context = $this->getGlobalVars();
        $context["pages"] = $pages;
        $tpl = $this->app()->getM()->loadTemplate("_template/header");
        return $tpl->render($context);
    }

    public function getFooter()
    {
        $context = $this->getGlobalVars();
        $tpl = $this->app()->getM()->loadTemplate("_template/footer");
        return $tpl->render($context);
    }

    public function getGlobalVars()
    {
        $context['basepath'] = BASEPATH;
        $context['auth'] = $this->session()->get("auth");
        $context['page_title'] = $this->getPageTitle();
        return $context;
    }

    public function renderPage()
    {
        return new Response($this->getHeader().$this->getHTML().$this->getFooter());
    }

    public function response($content)
    {
        return new Response($content);
    }

    public function app(): App
    {
        return $this->app;
    }

    public function setApp(App $app)
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