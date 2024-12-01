<?php

namespace RezaK\PestTestHelpers;

use Illuminate\Support\Facades\Route;
use ReflectionFunction;
use ReflectionMethod;

class Assertions
{
    public static function assertRouteCanSeeRequest($path, $request)
    {
        $route = collect(Route::getRoutes())->first(fn($route) => $route->uri() === $path);

        expect($route)
            ->not->toBeNull("Route not found: {$path}");

        $action = $route->getAction();
        $parameters = collect(
            isset($action['uses']) && is_string($action['uses']) && strpos($action['uses'], '@') !== false
                ? (new ReflectionMethod(...explode('@', $action['uses'])))->getParameters()
                : (new ReflectionFunction($action['uses']))->getParameters()
        );

        $usesRequest = $parameters->contains(fn($parameter) => $parameter->getType() && $parameter->getType()->getName() === $request
        );

        expect($usesRequest)
            ->toBeTrue("Route '{$path}' is not using {$request} for validation.");

    }
}
