<?php

namespace RezaK\PestTestHelpers;

use Illuminate\Support\ServiceProvider;

class AssertionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerAssertions();
    }

    protected function registerAssertions()
    {
        expect()->extend('routeCanSeeRequest', function ($request)
        {
            Assertions::assertRouteCanSeeRequest($this->value, $request);
        });
    }
}
