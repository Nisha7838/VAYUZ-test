<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */

// Route for the login page (GET request)
$routes->get('/', 'LoginController::index');
$routes->post('/login', 'LoginController::login');
$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/admin/dashboard', 'DashboardController::adminDashboard');
$routes->get('/customer/dashboard', 'DashboardController::customerDashboard');


$routes->group('admin', function($routes) {
    $routes->get('users', 'UserController::index');
    $routes->get('users/create', 'UserController::create');
    $routes->post('users/store', 'UserController::store');
    $routes->get('users/edit/(:num)', 'UserController::edit/$1');
    $routes->post('users/update/(:num)', 'UserController::update/$1');
});

$routes->get('logout', 'LogoutController::index');

//for api router
$routes->post('/api/login', 'ApiController::login');
$routes->post('/api/register', 'ApiController::register');
$routes->get('/api/users/(:num)', 'ApiController::getUsers/$1'); 
$routes->post('/api/user/update/(:num)', 'ApiController::updateUser/$1');

