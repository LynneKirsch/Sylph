<?php

namespace Application\Core;

class EntityInterface
{
    public static function create()
    {
        $em = \Doctrine\ORM\EntityManager::create(
            [
                'driver' => SQL_DRIVER,
                'user' => MYSQL_USER,
                'password' => MYSQL_PASS,
                'dbname' => MYSQL_DB
            ],
            \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration([MODEL])
        );

        return $em;
    }

    /**
     * @param $code
     * @return \Application\Model\Config|null
     */
    public static function getConfig($code)
    {
        $em = self::create();
        $config_result = $em->getRepository(MODEL_NS."Config")->findOneBy([
            "config_code" => $code
        ]);

        /* @var \Application\Model\Config $config_result */
        if($config_result) {
            return $config_result->getConfigVal();
        } else {
            return null;
        }
    }

    public static function getSlide($id)
    {
        $em = self::create();
        $slideshow = $em->getRepository(MODEL_NS."Slideshow")->findOneBy([
            "slideshow_id" => $id
        ]);

        /* @var \Application\Model\Slideshow $slideshow */
        if($slideshow) {
            return $slideshow;
        } else {
            return null;
        }
    }
}