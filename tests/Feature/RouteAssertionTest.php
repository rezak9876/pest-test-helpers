<?php
use Illuminate\Support\Facades\Route;
use RezaK\PestTestHelpers\Assertions;

class CustomRequest {}

class TestController {
    public function notUsed() {}

    public function used(CustomRequest $request) {}
}

it('should assert route accessibility with CustomRequest', function () {
    Route::get('/test-route', fn(CustomRequest $request) => []);

    $result = Assertions::assertRouteCanSeeRequest('test-route', CustomRequest::class);

    expect($result)->toBeNull();
});

it('should throw error if route does not use the correct request class', function () {
    Route::get('/test-invalid-route', fn() => []);

    Assertions::assertRouteCanSeeRequest('test-invalid-route', CustomRequest::class);
})->throws(\Exception::class, "Route 'test-invalid-route' is not using CustomRequest for validation.");

it('should assert route accessibility with controller', function () {
    Route::get('/test-controller-route', [TestController::class, 'used'])->name('test.controller.route');

    $result = Assertions::assertRouteCanSeeRequest('test-controller-route', CustomRequest::class);

    expect($result)->toBeNull();
});

it('should throw error if route does not use the correct request class with controller', function () {
    Route::get('/test-controller-route', [TestController::class, 'notUsed'])->name('test.controller.route');

    Assertions::assertRouteCanSeeRequest('test-controller-route', CustomRequest::class);
})->throws(\Exception::class, "Route 'test-controller-route' is not using CustomRequest for validation.");
