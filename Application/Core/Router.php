<?php

namespace Application\Core;

class Router
{
    private $alto;

    public function __construct()
    {
        $this->setAlto(new \AltoRouter());
        $this->alto()->setBasePath(BASEPATH);
    }

    public function processRoute(): ?array
    {
        $match = $this->alto()->match();
        if ($match && is_callable($match['target'])) {
            call_user_func_array($match['target'], $match['params']);
        } else {
            $match_array = explode("@", $match['target']);
            if (count($match_array) > 1) {
                if (file_exists(CONTROLLER_PATH . $match_array[0] . ".php")) {
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
     * @return mixed
     */
    public function alto(): \AltoRouter
    {
        return $this->alto;
    }

    /**
     * @param mixed $alto
     */
    public function setAlto(\AltoRouter $alto)
    {
        $this->alto = $alto;
    }
}