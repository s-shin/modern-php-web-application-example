<?php
namespace MyApp;

use Symfony\Component\HttpFoundation\Request;

class App implements \Symfony\Component\HttpKernel\HttpKernelInterface
{
    public function handle(Request $req, $type = self::MASTER_REQUEST, $catch = true)
    {
        $path = $req->getPathInfo();
        $router = new Router();
        $handler = $router->route($path);
        if (!is_callable($handler)) {
            throw new RuntimeException("The handler for '$path' is not callable.");
        }
        return call_user_func($handler, $req);
    }

    public static function run()
    {
        $stack = new \Stack\Builder();
        // *** insert some middlewares to $stack here ***
        $app = $stack->resolve(new self());
        $req = Request::createFromGlobals();
        $res = $app->handle($req)->send();
        $app->terminate($req, $res);
    }
}
