<?php
/**
 * Define paths
 */
define("ROOT", "/Sylph/");
define("APP", "Application" . DIRECTORY_SEPARATOR);
define("MODEL", APP . "Model" . DIRECTORY_SEPARATOR);
define("TEMPLATE_PATH", APP . "View");
define("PARTIALS_PATH", APP . "View/partials");
define("CORE", APP . "Core" . DIRECTORY_SEPARATOR);
define("CONTROLLER", APP . "Controller" . DIRECTORY_SEPARATOR);

/**
 * Define namespaces
 */
define("MODEL_NS", "Application\\Model\\");
define("CONTROLLER_NS", "Application\\Controller\\");

/**
 * Define models
 */
const MODEL_PAGE = MODEL_NS."Page";
/**
 * Configure Database connection
 */
define("SQL_DRIVER", "pdo_mysql");
define("MYSQL_USER", "root");
define("MYSQL_PASS", "");
define("MYSQL_DB", "exodus");

/**
 * Configure content types
 */
const TYPE_PAGE = 1;
const TYPE_POST = 2;
const HOMEPAGE = 2;
const POST_LIMIT = 10;

