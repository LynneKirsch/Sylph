<?php
// DATABASE
const DB_USER_NAME = "root";
const DB_PASSWORD = "";
const DB_NAME = "exodus";

// INCLUDE TRAILING SLASH
const BASEPATH = "/Sylph/";

// CONTROLLER CONFIG
const CONTROLLER_PATH = "Application/Controller/";
const CONTROLLER_NS = "Application\\Controller\\";

// MODEL CONFIG
const MODEL_PATH = "Application/Model/";
const MODEL_NS = "Application\\Model\\";

// ENTITIES
const MODEL_USER = "User";
const MODEL_PAGE = "Page";

// TEMPLATES
const TEMPLATE_PATH = 'Application/View';
const PARTIALS_PATH = 'Application/View/partials';

const DB_SETUP = [
    'driver' => 'pdo_mysql',
    'user' => DB_USER_NAME,
    'password' => DB_PASSWORD,
    'dbname' => DB_NAME
];
