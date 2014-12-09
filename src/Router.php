<?php
namespace MyApp;

use Symfony\Component\HttpFoundation\Response;

class Router
{
    public function route($path)
    {
        return function($req) use ($path) {
            return new Response("<h1>Hello, World!!!</h1><p>Path: {$path}</p>");
        };
    }
}
