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

// USERS
$app->route("GET", "admin/users", "UserController@admin");
$app->route("POST", "admin/users/update/[i:id]", "UserController@updateUser");
$app->route("POST", "admin/users/update", "UserController@updateUser");

// PAGES
$app->route("GET", "page/[a:slug]", "PageController@displayPage");
$app->route("GET", "admin/pages", "PageController@pageAdmin");
$app->route("GET", "admin/posts", "PageController@postAdmin");
$app->route("GET", "admin/page/[i:id]", "PageController@edit");
$app->route("POST|GET", "admin/page/save/[i:id]", "PageController@savePage");
$app->route("GET", "admin/page/new", "PageController@newPage");

/** Authorized Routes */
$app->registerAuthorizedRoute("admin");