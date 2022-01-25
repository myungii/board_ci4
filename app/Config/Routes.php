<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);


/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

/*
$routes->get('/'                        , 'Home::index');
$routes->get("ajax"                     , "boardAjax/home");
$routes->add("ajax/content/(:num)"      , "boardAjax/home/content/$1");
$routes->add("ajax/edit/(:num)"         , "boardAjax/edit/index/$1");
$routes->get("plugin/content/(:num)"    , "plugin/home/content/$1");
$routes->get("testcode"                 , "code/test");
$routes->get("ajax_write"               , "boardAjax/write");
$routes->get("plugin"                   , "plugin/home");
$routes->get("test"                     , "home/test");
*/

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */

//그룹핑
$routes->group('board', function($routes){
    $routes->add('/'                    , 'Board\Main\MainController::index');
    $routes->add('write'                , 'Board\Main\MainController::write', ['as' => 'write']);
    $routes->add('content/(:num)'       , 'Board\Main\MainController::content/$1');
});

$routes->group('ajax', function($routes){
    $routes->add('/'                    , 'Board\Main\AjaxController::index');
    $routes->add('write'                , 'Board\Main\AjaxController::write', ['as' => 'write']);
    $routes->add('content/(:num)'       , 'Board\Main\AjaxController::content/$1');
});

$routes->group('plugin', function($routes){
    $routes->add('/'                    , 'Board\Main\PluginController::index');
    $routes->add('write'                , 'Board\Main\PluginController::write', ['as' => 'write']);
    $routes->add('content/(:num)'       , 'Board\Main\PluginController::content/$1');
});

$routes->group('quiz', function($routes){
    $routes->add('/'                    , 'Quiz\Main\QuizController::index');
});

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
