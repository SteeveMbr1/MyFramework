<?php

use MyFramework\Controller\Controller;
use MyFramework\Http\Request;
use MyFramework\Http\Response;
use MyFramework\Router\Router;
use MyFramework\Template\View;

use function MyFramework\Template\View;

define('__BASE_PATH__', __DIR__);
define('__VIEWS_PATH__', __BASE_PATH__ . DIRECTORY_SEPARATOR . 'views');


Router::add('GET', '/', function () {
    return View('home');
});

Router::add('GET', '/contact', [Controller::class, 'index']);
Router::add('POST', '/contact/{id}', [Controller::class, 'store'], null, 'contact.store');

Router::add('GET', '/articles/{id}-{slug}', [Controller::class, 'show'], null, 'article.show');

Router::dumpRoutes();

$route = Router::generate('article.show', ['id' => 14, 'slug' => 'bonjour-les-amis']);

var_dump($route);
