<?php
/**
 * Autoload Dependencies
 */
require_once('vendor/autoload.php');

/**
 * Load Config
 */
require_once("application/core/GlobalConfig.php");

/**
 * Instantiate Application
 */
$app = new \Application\Core\App();

/**
 * Include Routes
 */
include("Application/HTTP/routes.php");

/**
 * Run application
 */
$app->run();