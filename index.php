<?php
/**
 * Autoload Dependencies
 */
require_once('vendor/autoload.php');

/**
 * Load Config
 */
require_once("config.php");
require_once(CORE."Functions.php");

/**
 * Instantiate Application
 */
$app = new \Application\Core\App();

/**
 * Load Routes
 */
require_once("Application/HTTP/routes.php");

/**
 * Run application
 */
$app->run();