<?php

use Illuminate\Support\Facades\Route;

class CustomRequest
{
}

class TestController
{
    public function notUsed()
    {
    }

    public function used(CustomRequest $request)
    {
    }
}

it('should assert route accessibility with CustomRequest', function () {
    Route::get('/test-route', fn(CustomRequest $request) => []);

    expect('test-route')->routeCanSeeFormRequest(CustomRequest::class);

});

it('should throw error if route does not use the correct request class', function () {
    Route::get('/test-invalid-route', fn() => []);

    expect('test-invalid-route')->not->routeCanSeeFormRequest(CustomRequest::class);

});

it('should assert route accessibility with controller', function () {
    Route::get('/test-controller-route', [TestController::class, 'used']);

    expect('test-controller-route')->routeCanSeeFormRequest(CustomRequest::class);
});

it('should throw error if route does not use the correct request class with controller', function () {
    Route::get('/test-controller-invalid-route', [TestController::class, 'notUsed']);

    expect('test-controller-invalid-route')->not->routeCanSeeFormRequest(CustomRequest::class);
});
