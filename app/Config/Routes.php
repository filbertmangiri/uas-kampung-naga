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
$routes->setDefaultController('Pages');
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
$routes->get('', 'Pages');
$routes->get('home', 'Pages::index');
$routes->get('about', 'Pages::about');

$routes->get('register', 'Account\Register', ['filter' => 'logged-out']);
$routes->post('register', 'Account\Register::submit', ['filter' => 'logged-out']);
$routes->post('register/croppedimage', 'Account\Register::croppedImage', ['filter' => 'logged-out']);

$routes->get('login', 'Account\Login', ['filter' => 'logged-out']);
$routes->post('login', 'Account\Login::submit', ['filter' => 'logged-out']);

$routes->get('logout', 'Account\Logout', ['filter' => 'logged-in']);

$routes->get('account/settings', 'Account\Account::settings', ['filter' => 'logged-in:login']);
$routes->post('account/settings', 'Account\Account::update', ['filter' => 'logged-in:login']);

$routes->get('dashboard', 'Dashboard', ['filter' => 'logged-in:login']);

$routes->get('u/(:any)', 'User::index/$1');
$routes->get('u', 'User', ['filter' => 'logged-in:login']);

$routes->get('facility', 'Facility');
$routes->get('f/(:any)', 'Facility::index/$1');

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
