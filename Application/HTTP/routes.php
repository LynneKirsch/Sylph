<?php
/** DEFAULT ROUTE */
// Always blank, base path includes trailing slash
$app->route("GET", "", "HomeController@index");

/** LOGIN ROUTES */
$app->route("GET", "login", "LoginController@index");
$app->route("POST", "login/process_login", "LoginController@processLogin");
$app->route("GET", "logout", "LoginController@processLogout");

/** MIGRATIONS */
$app->route("GET", "migrate", "MigrationController@performMigration");

/** ADMIN */
$app->route("GET", "admin", "AdminController@index");

// USERS
$app->route("GET", "admin/users", "UserController@admin");
$app->route("POST", "admin/users/update/[i:id]", "UserController@updateUser");
$app->route("POST", "admin/users/update", "UserController@updateUser");

// PAGES
$app->route("GET", "page/[a]", "PageController@getPageFromSlug");
$app->route("GET", "page/[i]", "PageController@getPageFromID");