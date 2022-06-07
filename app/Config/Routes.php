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
$routes->setDefaultController('SigninController');
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
// route since we don't have to scan directories.s
$routes->get('/login', 'SigninController::index');
$routes->get('/logout', 'SigninController::logout');
$routes->add('/login/submit', 'SigninController::loginAuth');
$routes->get('/register', 'SignupController::index');

$routes->group('admin', ['filter' => 'authGuard'], function ($routes) {
    /** EMPLOYEE **/
    $routes->get('dashboard', 'HomeController::index');
    $routes->get('employee', 'EmployeeController::index');
    $routes->add('employee/form', 'EmployeeController::create');
    $routes->add('employee/save', 'EmployeeController::save');
    $routes->add('employee/edit/(:num)', 'EmployeeController::edit/$1');
    $routes->add('employee/update/(:num)', 'EmployeeController::update/$1');
    $routes->add('employee/detail/(:num)', 'EmployeeController::detail/$1');
    $routes->delete('employee/delete/(:num)', 'EmployeeController::delete/$1');

    /** JOBS **/
    $routes->get('job', 'JobController::index');
    $routes->get('job/form', 'JobController::form');
    $routes->add('job/save', 'JobController::save');
    $routes->add('job/edit/(:num)', 'JobController::edit/$1');
    $routes->add('job/update/(:num)', 'JobController::update/$1');
    $routes->add('job/detail/(:num)', 'JobController::detail/$1');
    $routes->delete('job/delete/(:num)', 'JobController::delete/$1');

    /** ATTEDANCE **/
    $routes->get('attedance', 'AttendanceController::index');

    /** CATEGORIES **/
    $routes->get('category', 'CategoryController::index');
    $routes->add('category/form', 'CategoryController::create');
    $routes->add('category/save', 'CategoryController::save');
    $routes->add('category/edit/(:num)', 'CategoryController::edit/$1');
    $routes->add('category/update/(:num)', 'CategoryController::update/$1');
    $routes->add('category/detail/(:num)', 'CategoryController::detail/$1');
    $routes->delete('category/delete/(:num)', 'CategoryController::delete/$1');
});

// $routes->group('employee', static function ($routes) {
//     $routes->get('dashboard', 'H')
// })

$routes->group('user', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('/', 'UserController::index', ['filter' => 'authGuard']);
    $routes->get('profile', 'UserController::profile', ['filter' => 'authGuard']);

    /** ABSENT **/
    $routes->get('absent', 'UserController::absent', ['filter' => 'authGuard']);
    $routes->get('scan', 'AttendanceController::scanner', ['filter' => 'authGuard']);
    $routes->add('scan/submit', 'AttendanceController::scannerSave', ['filter' => 'authGuard']);

    /** PERMISSIONS **/
    $routes->get('permission', 'AttendanceController::permission', ['filter' => 'authGuard']);
    $routes->add('permission/submit', 'AttendanceController::permissionSave', ['filter' => 'authGuard']);

    /** REPORT TASK **/
    $routes->get('report', 'UserController::report', ['filter' => 'authGuard']);
    $routes->add('report/submit/(:num)', 'UserController::completeReport/$1', ['filter' => 'authGuard']);
    $routes->get('task', 'UserController::task', ['filter' => 'authGuard']);
    $routes->get('task/detail/(:num)', 'UserController::TaskDetail/$1', ['filter' => 'authGuard']);
});

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
