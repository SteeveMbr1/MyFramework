<?php

use MyFramework\Controller\Controller;
use MyFramework\Http\Cookie;
use MyFramework\Http\Request;
use MyFramework\Http\Response;
use MyFramework\Router\Route;
use MyFramework\Template\View;

require_once 'vendor/autoload.php';


$view = new View('home', ['name' => 'toto']);
$response = new Response($view);
$request = new Request();

// echo $response->send();

Route::add('GET', '/', function () {
    return new View('home');
});

Route::add('GET', '/contact', [Controller::class, 'index']);
Route::add('POST', '/contact', [Controller::class, 'store']);

Route::dumpRoutes();
