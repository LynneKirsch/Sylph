<?php

namespace Application\Core;

class MustacheInterface
{
    public static function create()
    {
        $m = new \Mustache_Engine(array(
            'loader' => new \Mustache_Loader_FilesystemLoader(TEMPLATE_PATH),
            'partials_loader' => new \Mustache_Loader_FilesystemLoader(PARTIALS_PATH)
        ));

        return $m;
    }

    public static function render($template, $context = [])
    {
        $tpl = self::create()->loadTemplate($template);
        return $tpl->render($context);
    }
}