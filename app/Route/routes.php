<?php

use App\Core\Request;
use App\Core\Response;
use App\Core\Router;

$router = new Router($config);

//Routes
$router->get('/', 'Test');

$router->dispatch(Request::capture(), new Response());