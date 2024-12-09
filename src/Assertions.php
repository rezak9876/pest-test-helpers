<?php

namespace RezaK\PestTestHelpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use ReflectionFunction;
use ReflectionMethod;

class Assertions
{
    public static function assertrouteCanSeeFormRequest($routeName, $request)
    {
        $route = Route::getRoutes()->getByName($routeName);
        expect($route)
            ->not->toBeNull("Route not found: {$routeName}");

        $action = $route->getAction();
        $parameters = collect(
            isset($action['uses']) && is_string($action['uses']) && strpos($action['uses'], '@') !== false
                ? (new ReflectionMethod(...explode('@', $action['uses'])))->getParameters()
                : (new ReflectionFunction($action['uses']))->getParameters()
        );

        $usesRequest = $parameters->contains(fn($parameter) => $parameter->getType() && $parameter->getType()->getName() === $request
        );

        expect($usesRequest)
            ->toBeTrue("Route '{$routeName}' is not using {$request} for validation.");

    }

    public static function assertFormRequestValidationFailsWithErrors(string $requestClass, array $data, array $expectedErrors): void
    {
        $request = new $requestClass();
        $validator = Validator::make($data, $request->rules(), $request->messages());
        $errors = $validator->errors()->toArray();
        expect($errors)->toEqual($expectedErrors);
    }

    public static function assertValidDataForRequest(string $requestClass, array $data): void
    {
        $request = new $requestClass();
        $validator = Validator::make($data, $request->rules());
        expect($validator->passes())->toBeTrue();
    }
}
