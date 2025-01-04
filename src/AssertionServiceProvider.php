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

        $this->registerProviderAssertions();
    }

    protected function registerProviderAssertions()
    {
        expect()->extend('configMerged', function () {
            ProviderAssertions::assertConfigMerged($this->value);
        });

        expect()->extend('configSet', function ($exceptedConfigs) {
            ProviderAssertions::assertConfigSet($this->value, $exceptedConfigs);
        });

        expect()->extend('filePublished', function ($destination) {
            ProviderAssertions::assertFilePublished($this->value, $destination);
        });

        expect()->extend('routesLoaded', function () {
            ProviderAssertions::assertRoutesLoaded($this->value);
        });

        expect()->extend('migrationsLoaded', function () {
            ProviderAssertions::assertMigrationsLoaded($this->value);
        });

        expect()->extend('providerRegistered', function ($providerClass) {
            ProviderAssertions::assertProviderRegistered($this->value, $providerClass);
        });

        expect()->extend('interfaceBoundTo', function ($interface, $implementationClass) {
            ProviderAssertions::assertInterfaceBoundTo($this->value, $interface, $implementationClass);
        });
    }
}
