<?php
/**
 * Define paths
 */
define("ROOT", "/~yzstudentrentals/");
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
define("MODEL_PAGE", MODEL_NS."Page");

/**
 * Configure Database connection
 */
define("SQL_DRIVER", "pdo_mysql");
define("MYSQL_USER", "yzstuden_admin");
define("MYSQL_PASS", "polkij7890");
define("MYSQL_DB", "yzstuden_housing");

/**
 * Configure content types
 */
const TYPE_PAGE = 1;
const TYPE_POST = 2;
const HOMEPAGE = 2;
const POST_LIMIT = 10;

