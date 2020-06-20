---
description: >-
  You need to install the Introspection Server package on your authorization
  server.
---

# Installation

## Getting Started

On your Authorization Server, run the following:

```bash
$ composer require datahivedevelopment/passport-introspection-server
```

{% hint style="info" %}
 Passport is required for this package so it will be installed if it isn't already.
{% endhint %}

This package supports auto-discovery so no need to register the service providers.

## Passport Configuration

Once installed, if you haven’t already done so, make sure you follow [Passport’s Installation docs](https://laravel.com/docs/7.x/passport#installation).

```php
php artisan migrate
php artisan passport:install
```

Add the `Laravel\Passport\HasApiTokens` trait to your `App\User` class and register the Passport routes in your `AuthServiceProvider`:

```php
<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    // Other code
    
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
```

If you are following a default Introspection Server installation, you will want to make sure you register the `CheckCredentials` middleware in your `app/Http/Kernel.php` file:

```php
use Laravel\Passport\Http\Middleware\CheckClientCredentials;

protected $routeMiddleware = [
    'client' => CheckClientCredentials::class,
];php
```

