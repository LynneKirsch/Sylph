<?php

namespace Application\Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;


class App
{
    private $router;
    private $em;
    private $session;
    private $request;
    private $m;

    public function __construct()
    {
        $this->setRouter(new Router());
        $this->setSession(new \Symfony\Component\HttpFoundation\Session\Session());
        $this->getSession()->start();
        $this->setRequest(Request::createFromGlobals());
        $this->setEm(EntityManager::create(DB_SETUP, Setup::createAnnotationMetadataConfiguration([MODEL_PATH])));

        $this->setM(
            new \Mustache_Engine(array(
                'loader' => new \Mustache_Loader_FilesystemLoader(TEMPLATE_PATH),
                'partials_loader' => new \Mustache_Loader_FilesystemLoader(PARTIALS_PATH)
            ))
        );
    }

    public function run()
    {
        $route = $this->getRouter()->processRoute();
        $response = new Response();

        if ($route) {
            /* @var \Application\Core\BaseController $called */
            $called = new $route['class']($this);

            /* Find associated model if there is one */
            $called_basename = str_replace("Controller", "", get_class($called));

            if(file_exists(MODEL_PAGE.$called_basename.".php")) {
                $called->setModel($called_basename);
            }

            $result = call_user_func_array([$called, $route['method']], $route['match']['params']);

            if (is_a($result, '\Symfony\Component\HttpFoundation\Response')) {
                // If the result is already a Symfony response, just
                // use the result
                $response = $result;
            } else {
                if(is_null($result)) {
                    if(!is_null($called->getHTML())) {
                        // If the method returned void
                        // but there is HTML set on the called
                        // object, create a page view
                        $response = $called->renderPage();
                    }
                } else {
                    // If the result is not a response object,
                    // yet the method still returned content
                    // set that content as the response
                    $response->setContent($result);
                }
            }
        } else {
            $base = new BaseController($this);
            $base->view("404");
            $response = $base->renderPage();
        }

        $response->prepare(Request::createFromGlobals());
        $response->send();
    }

    public function route($method, $match, $callback)
    {
        $this->getRouter()->alto()->map($method, $match, $callback);
    }

    /** Mustache */
    public function getM(): \Mustache_Engine
    {
        return $this->m;
    }

    public function setM(\Mustache_Engine $m)
    {
        $this->m = $m;
    }

    /** Entity Manager */
    public function em(): EntityManager
    {
        return $this->em;
    }

    public function setEm(EntityManager $em)
    {
        $this->em = $em;
    }

    /** Requests */
    public function getRequest(): Request
    {
        return $this->request;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /** Session */
    public function getSession(): Session
    {
        return $this->session;
    }

    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    /** Router */
    public function getRouter(): Router
    {
        return $this->router;
    }

    public function setRouter(Router $router)
    {
        $this->router = $router;
    }
}