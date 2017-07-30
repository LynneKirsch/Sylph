<?php

namespace Application\Core;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    private $authorized_routes = [];

    public function __construct()
    {
        $this->setRouter(new Router());
        $this->setSession(new \Symfony\Component\HttpFoundation\Session\Session());
        $this->getSession()->start();
        $this->setRequest(Request::createFromGlobals());
        $this->setEm(EntityInterface::create());
        $this->setM(MustacheInterface::create());
    }

    public function run()
    {
        /** send response */
        $this->generateResponse($this->getRouter()->processRoute());
    }

    public function generateResponse($route)
    {
        // Authorize request first
        // We'll do something better later
        if(in_array($route["match"]["root"], $this->getAuthorizedRoutes())) {
            if(!$this->authenticate()) {
                $response =  new RedirectResponse(ROOT."login");
                $response->prepare(Request::createFromGlobals());
                return $response->send();
            }
        }
        $response = new Response();

        if ($route) {
            /* @var \Application\Core\BaseController $called */
            $called = new $route['class']($this);

            /* Find associated model if there is one */
            $reflect = new \ReflectionClass($called);
            $called_basename = str_replace("Controller", "", $reflect->getShortName());

            if (file_exists(MODEL . $called_basename . ".php")) {
                $called->setModel($called_basename);
            }

            $result = call_user_func_array([$called, $route['method']], $route['match']['params']);

            if (is_a($result, '\Symfony\Component\HttpFoundation\Response')) {
                // If the result is already a Symfony response, just
                // use the result
                $response = $result;
            } else {
                if (is_null($result)) {
                    if (!is_null($called->getHTML())) {
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

            // If the route was unmatched,
            // return a 404 page
            $base = new BaseController($this);
            $base->view("404");
            $response = $base->renderPage();

        }

        $response->prepare(Request::createFromGlobals());
        return $response->send();
    }

    public function route($method, $match, $callback)
    {
        $this->getRouter()->alto()->map($method, $match, $callback);
    }

    public function authenticate()
    {
        if(!$this->getSession()->get("logged_in")) {
            return false;
        }

        return true;
    }

    public function getAuthorizedRoutes()
    {
        return $this->authorized_routes;
    }

    public function registerAuthorizedRoute($route)
    {
        array_push($this->authorized_routes, $route);
    }

    /**
     * @return \Mustache_Engine
     */
    public function getM()
    {
        return $this->m;
    }

    public function setM($m)
    {
        $this->m = $m;
    }

    /**
     * @return EntityManager
     */
    public function em()
    {
        return $this->em;
    }

    public function setEm($em)
    {
        $this->em = $em;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    public function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    public function setRouter($router)
    {
        $this->router = $router;
    }
}