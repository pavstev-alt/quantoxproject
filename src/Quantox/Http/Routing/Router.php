<?php

namespace Quantox\Http\Routing;

use League\Route\Router as LeagueRouter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\SapiEmitter as Emitter;

class Router
{
    protected $routerService;

    public function __construct()
    {
        $this->routerService = new LeagueRouter();
    }

    public function register(
        string $requestMethod,
        string $path,
        string $controllerClassName,
        string $controllerMethodName
    ): Router {
        $this->routerService->map($requestMethod, $path, [$controllerClassName, $controllerMethodName]);

        return $this;
    }

    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        return $this->routerService->dispatch($request);
    }

    public function emitResponse(ServerRequestInterface $request)
    {
        $response = $this->dispatch($request);

        (new Emitter())->emit($response);
    }
}
