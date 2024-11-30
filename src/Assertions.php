<?php

namespace RezaK\PestTestHelpers;

use Illuminate\Support\Facades\Route;
use ReflectionMethod;
use ReflectionFunction;

class Assertions
{
    public static function assertRouteCanSeeRequest($path, $request)
    {
        $route = collect(Route::getRoutes())->first(fn($route) => $route->uri() === $path);

        if (!$route) {
            throw new \Exception("Route not found: {$path}");
        }

        $action = $route->getAction();
        $parameters = isset($action['uses']) && is_string($action['uses']) && strpos($action['uses'], '@') !== false
            ? (new ReflectionMethod(explode('@', $action['uses'])[0], explode('@', $action['uses'])[1]))->getParameters()
            : (new ReflectionFunction($action['uses']))->getParameters();

        foreach ($parameters as $parameter) {
            if ($parameter->getType() && $parameter->getType()->getName() === $request) {
                return;
            }
        }

        throw new \Exception("Route '{$path}' is not using {$request} for validation.");
    }
}
