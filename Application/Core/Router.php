<?php

namespace Application\Core;

class Router
{
    private $alto;

    public function __construct()
    {
        $this->setAlto(new \AltoRouter());
        $this->alto()->setBasePath(ROOT);
    }

    public function processRoute()
    {

        return $this->performRouteMatch($this->alto()->match());
    }

    public function performRouteMatch($match)
    {
        if ($match && is_callable($match['target'])) {
            call_user_func_array($match['target'], $match['params']);
        } else {
            $match_array = explode("@", $match['target']);
            if (count($match_array) > 1) {
                if (file_exists(CONTROLLER . $match_array[0] . ".php")) {
                    $class = CONTROLLER_NS . $match_array[0];
                    $method = $match_array[1];
                    if (method_exists($class, $method)) {
                        return ["class" => $class, "method" => $method, "match" => $match];
                    }
                }
            }
        }
        return null;
    }

    /**
     * @return \AltoRouter
     */
    public function alto()
    {
        return $this->alto;
    }

    /**
     * @param mixed $alto
     */
    public function setAlto($alto)
    {
        $this->alto = $alto;
    }
}