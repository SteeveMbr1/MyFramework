<?php

use MyFramework\Controller\Controller;
use MyFramework\Http\Cookie;
use MyFramework\Http\Request;
use MyFramework\Http\Response;
use MyFramework\Router\Router;
use MyFramework\Template\View;

require_once 'vendor/autoload.php';


$view = new View('home', ['name' => 'toto']);
$response = new Response($view);
$request = new Request();

// echo $response->send();

Router::add('GET', '/', function () {
    return new View('home');
});

Router::add('GET', '/contact', [Controller::class, 'index']);
Router::add('POST', '/contact/{id}', [Controller::class, 'store'], null, 'contact.store');

Router::add('GET', '/articles/{id}-{slug}', [Controller::class, 'show'], null, 'article.show');

Router::dumpRoutes();

$route = Router::generate('article.show', ['id' => 14, 'slug' => 'bonjour-les-amis']);

var_dump($route);
