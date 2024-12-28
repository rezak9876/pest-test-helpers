<?php

namespace RezaK\PestTestHelpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ProviderAssertions
{
    public static function assertConfigMerged(string $key, callable $callback = null): void
    {
        $value = Config::get($key);
        expect($value)->not->toBeNull();
        if ($callback) {
            $callback($value);
        }
    }

    public static function assertConfigSet(string $key, array $expected): void
    {
        $value = Config::get($key);
        expect($value)->toMatchArray($expected);
    }

    public static function assertFilePublished(string $source, string $destination): void
    {
        $publishedFiles = ServiceProvider::$publishes;

        $found = false;
        foreach ($publishedFiles as $group => $files) {
            if (in_array($destination, $files)) {
                $found = true;
                break;
            }
        }

        expect($found)->toBeTrue()
            ->and($source)->toBeFile();
    }

    public static function assertRoutesLoaded(string $routePath): void
    {
        $expectedRoutePath = realpath(__DIR__ . '/../routes/api.php');

        $loadedRoutePaths = collect(Route::getRoutes()->getIterator())
            ->map(fn($route) => $route->action['uses'] ?? null)
            ->filter()
            ->toArray();

        $normalizedLoadedPaths = array_map('realpath', $loadedRoutePaths);

        expect($normalizedLoadedPaths)->toContain($expectedRoutePath);
    }

    public static function assertMigrationsLoaded(string $migrationPath): void
    {
        $loadedPaths = app('migrator')->paths();

        $normalizedExpectedPath = realpath($migrationPath);
        $normalizedLoadedPaths = array_map('realpath', $loadedPaths);

        expect($normalizedLoadedPaths)->toContain($normalizedExpectedPath);
    }
}
