<?php

use App\Core\Request;
use App\Core\Response;
use App\Core\Router;

$router = new Router($config);


// Routes
$router->get('/', [App\Controllers\RegistrationController::class, 'index']);
$router->post('/register', [App\Controllers\RegistrationController::class, 'store']);


$router->post('/login', [App\Controllers\AuthController::class, 'login']);
$router->post('/logout', [App\Controllers\AuthController::class, 'logout']);


$router->get('/list', [App\Controllers\RegistrationController::class, 'listPage']);
$router->get('/api/registrations', [App\Controllers\ApiController::class, 'datatable']);


$router->get('/export/xlsx', [App\Controllers\ExportController::class, 'xlsx']);
$router->get('/export/pdf', [App\Controllers\ExportController::class, 'pdf']);


$router->dispatch(Request::capture(), new Response());