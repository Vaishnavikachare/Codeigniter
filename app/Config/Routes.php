<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default home route
$routes->get('/', 'Home::index');

// Authentication routes
$routes->match(['GET', 'POST'], 'register', 'Auth::register');
$routes->match(['GET', 'POST'], 'login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// Dashboard routes
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']); // Could be changed to route to specific dashboards
$routes->get('employee-dashboard', 'Dashboard::employeeDashboard', ['filter' => 'auth']);
$routes->get('dealer-dashboard', 'Dashboard::dealerDashboard', ['filter' => 'auth']);

// Profile update route
$routes->match(['GET', 'POST'], 'update-profile', 'Dashboard::updateProfile', ['filter' => 'auth']);

// Dealer management routes
$routes->get('dealers', 'Dashboard::dealers', ['filter' => 'auth']);
$routes->match(['GET', 'POST'], 'edit-dealer/(:num)', 'Dashboard::editDealer/$1', ['filter' => 'auth']);

// Check email route for AJAX
$routes->post('check-email', 'Auth::checkEmail');

// Error handling (optional, can be customized)
$routes->set404Override(function(){
    echo view('errors/404');
});

