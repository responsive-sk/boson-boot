<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Router
{
    private Dispatcher $dispatcher;

    public function __construct()
    {
        $this->dispatcher = simpleDispatcher(function (RouteCollector $r) {
            // Home page
            $r->addRoute('GET', '/', 'HomeController@index');
            
            // Blog routes
            $r->addRoute('GET', '/blog', 'BlogController@index');
            $r->addRoute('GET', '/blog/{slug}', 'BlogController@show');
            
            // Documentation routes
            $r->addRoute('GET', '/docs', 'DocsController@index');
            $r->addRoute('GET', '/docs/{version}', 'DocsController@version');
            $r->addRoute('GET', '/docs/{version}/{slug}', 'DocsController@show');
            
            // Search
            $r->addRoute('GET', '/search', 'SearchController@index');
            $r->addRoute('POST', '/search', 'SearchController@search');
            
            // API routes for HTMX
            $r->addRoute('GET', '/api/search', 'SearchController@apiSearch');
            $r->addRoute('GET', '/api/blog/load-more', 'BlogController@loadMore');
            
            // Static pages
            $r->addRoute('GET', '/download', 'PageController@download');
            $r->addRoute('GET', '/about', 'PageController@about');
            $r->addRoute('GET', '/contact', 'PageController@contact');
            $r->addRoute('GET', '/privacy', 'PageController@privacy');
            $r->addRoute('GET', '/terms', 'PageController@terms');
        });
    }

    public function dispatch(string $httpMethod, string $uri): array
    {
        return $this->dispatcher->dispatch($httpMethod, $uri);
    }
}
