# Pest Test Helper

A custom Laravel package that extends Pest with additional assertions to make testing routes and requests easier. This package includes assertions like `assertrouteCanSeeFormRequest` to simplify testing route accessibility in your Laravel application.

## Installation

You can install this package via Composer.

### 1. Add Package to Your Laravel Project

Run the following command to add the package to your Laravel project:

```bash
composer require rezak/pest-test-helpers --dev
```

## Usage

This package adds custom assertions for easier testing of routes and requests. Here's an example of how to use the `assertrouteCanSeeFormRequest` assertion in your tests:

```php
it('can see the request for the test route', function () {
    class CustomRequest {}

    Route::get('/test-route', fn(CustomRequest $request) => []);

    // Assert that the route '/test-route' can see the request
    $this->assertrouteCanSeeFormRequest('test-route', CustomRequest::class);
});
```

In this example, the test checks if the custom request class (`CustomRequest`) is correctly injected when hitting the route `/test-route`. The assertion ensures that the request can be seen by the route.

### Available Assertions

- `assertrouteCanSeeFormRequest`: Verifies that a specific request class can be seen by a given route.
