<?php

use MyFramework\Router\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * 
     * @var Router
     */
    protected Router $routes;

    public function setUp(): void
    {
        $this->routes = new Router();
        $this->routes::add('GET', '/home', 'HomeController:index', null, 'home')

            ::add('GET', '/article', 'PostController:index', null, 'article.index')

            ::add('GET', '/article/create', 'PostController:create', null, 'article.create')
            ::add('POST', '/article', 'PostController:store', null, 'article.store')

            ::add('GET', '/article/{id}', 'PostController:show', null, 'article.show')
            ::add('GET', '/article/{id}-{slug}', 'PostController:show', null, 'article.show.slug')

            ::add('GET', '/article/{id}/edit', 'PostController:edit', null, 'article.edit')

            ::add('PUT', '/article/{id}', 'PostController:update', null, 'article.update')

            ::add('DELETE', '/article/{id}', 'PostController:destroy', null, 'article.destroy');
    }

    public function test_router()
    {
        $this->routes::dumpRoutes();
        $this->assertEquals('', '');
    }

    public function test_generate_home()
    {
        $this->assertEquals('/home', $this->routes::generate('home'));
    }

    public function test_generate_article_without_args()
    {
        $this->assertEquals('/article', $this->routes::generate('article.index'));
        $this->assertEquals('/article', $this->routes::generate('article.store'));
    }

    public function test_generate_article_with_args()
    {
        $this->assertEquals('/article/13', $this->routes::generate('article.destroy', ['id' => 13]));
        $this->assertEquals('/article/14', $this->routes::generate('article.update', ['id' => 14]));
        $this->assertEquals('/article/15', $this->routes::generate('article.show', ['id' => 15]));
    }

    public function test_generate_article_with_multiple_args()
    {
        $this->assertEquals(
            '/article/21-bonjour-les-amis',
            $this->routes::generate('article.show.slug', [
                'id' => 21,
                'slug' => 'bonjour-les-amis'
            ])
        );
        $this->assertEquals(
            '/article/22-salut-les-copains',
            $this->routes::generate('article.show.slug', [
                'id' => 22,
                'slug' => 'salut-les-copains'
            ])
        );
    }

    public function test_generate_not_found()
    {
        $this->assertEquals(null, $this->routes::generate('article.inde'));
    }

    public function test_match()
    {
        $route = $this->routes::match('/article/22-salut-les-copains');
        $this->assertEquals('article.show.slug', $route['name']);
    }
}
