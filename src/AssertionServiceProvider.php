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
        expect()->extend('routeCanSeeFormRequest', function ($request) {
            Assertions::assertrouteCanSeeFormRequest($this->value, $request);
        });

        expect()->extend('toFailValidationWithDataAndException', function (array $data, array $expectedErrors) {
            Assertions::assertFormRequestValidationFailsWithErrors($this->value, $data, $expectedErrors);
        });

        expect()->extend('toValidateData', function (array $data) {
            Assertions::assertValidDataForRequest($this->value, $data);
        });
    }
}
