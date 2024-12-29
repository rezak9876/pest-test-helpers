<?php

namespace RezaK\PestTestHelpers;

class ProviderAssertions
{
    public static function assertProviderRegistered($app, string $providerClass)
    {
        expect($app->getProvider($providerClass))->toBeTruthy();
    }

    public static function assertInterfaceBoundTo($app, string $interface, string $implementationClass)
    {
        $resolved = $app->make($interface);
        expect($resolved)->toBeInstanceOf($implementationClass);
    }

    public static function assertRoutesLoaded($app, string $expectedRoutePath)
    {
        $routes = collect($app['router']->getRoutes())->pluck('uri');
        expect(file_exists($expectedRoutePath))->toBeTrue();
        expect($routes->isNotEmpty())->toBeTrue();
    }

    public static function assertMigrationsLoaded($app, string $expectedMigrationPath)
    {
        expect(file_exists($expectedMigrationPath))->toBeTrue();
        $migrations = glob($expectedMigrationPath . '/*.php');
        expect($migrations)->not()->toBeEmpty();
    }
}
