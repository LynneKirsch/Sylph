<?php

namespace Application\Controller;

use Application\Core\BaseController;
use Doctrine\ORM\Tools\SchemaTool;

class MigrationController extends BaseController
{

    private function generateSQL()
    {
        $models = [];

        $dir = new \DirectoryIterator(MODEL);
        foreach ($dir as $file_info) {
            if (!$file_info->isDot()) {
                $models[] = $this->app()->em()->getClassMetadata(MODEL_NS . $file_info->getBasename('.php'));
            }
        }

        $em = $this->app()->em();
        $tool = new SchemaTool($this->app()->em());
        $to_schema = $tool->getSchemaFromMetadata($models);
        $connection = $em->getConnection();
        $sm = $connection->getSchemaManager();
        $from_schema = $sm->createSchema();
        $platform = $em->getConnection()->getDatabasePlatform();
        $sql = $from_schema->getMigrateToSql($to_schema, $platform);
        return $sql;
    }

    public function performMigration()
    {
        

        $sql = $this->generateSQL();
        if($sql) {
            $stmt = $this->app()->em()->getConnection()->prepare(implode(";\n", $sql));
            $result = $stmt->execute();

            if($result) {
                echo "Migration complete.";
            }
        } else {
            echo "Nothing to migrate.";
        }

        die();
    }
}