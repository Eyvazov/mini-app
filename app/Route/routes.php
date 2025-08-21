<?php

use App\Core\Request;
use App\Core\Response;
use App\Core\Router;

$router = new Router($config);

//Routes
$router->get('/', [\App\Controllers\RegistrationController::class, 'index']);
$router->post('/register', [\App\Controllers\RegistrationController::class, 'store']);

$router->dispatch(Request::capture(), new Response());