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



/*****************************************************************
 * Pages
 ****************************************************************/
// Override custom pages...
$app->route("GET", "page/properties", "PropertyController@index");

// Display normal pages
$app->route("GET", "page/[a:slug]", "PageController@displayPage");

/*****************************************************************
 * ADMIN ROUTES
 ****************************************************************/
// PAGES
$app->route("GET", "admin/pages", "PageController@pageAdmin");
$app->route("GET", "admin/page/[i:id]", "PageController@edit");
$app->route("POST", "admin/page/save/[i:id]", "PageController@savePage");
$app->route("POST", "admin/page/delete/[i:id]", "PageController@deletePage");
$app->route("GET", "admin/page/new", "PageController@newPage");
// POSTS
$app->route("GET", "admin/post/new", "PageController@newPost");
$app->route("GET", "admin/posts", "PageController@postAdmin");
// PROPERTIES
$app->route("GET", "admin/properties", "PropertyController@admin");
$app->route("GET", "admin/property/new", "PropertyController@newProperty");
$app->route("POST", "admin/property/save", "PropertyController@saveProperty");
$app->route("GET", "admin/property/[i:id]", "PropertyController@editProperty");
// SLIDESHOWS
$app->route("GET", "admin/add_slideshow/[i:id]", "PageController@addSlideshow");
$app->route("POST", "admin/save_slideshow", "PageController@saveSlideshow");
// CONFIG
$app->route("GET", "admin/config", "ConfigController@admin");
$app->route("POST", "admin/config/update/[i:id]", "ConfigController@update");
// USERS
$app->route("GET", "admin/users", "UserController@admin");
$app->route("POST", "admin/users/update/[i:id]", "UserController@updateUser");
$app->route("POST", "admin/users/update", "UserController@updateUser");

/** Authorized Routes */
$app->registerAuthorizedRoute("admin");