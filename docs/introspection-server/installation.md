---
description: >-
  You need to install the Introspection Server package on your authorization
  server.
---

# Installation

## Package Installation

On your Authorization Server, run the following:

```bash
composer require datahivedevelopment/passport-introspection-server
```

{% hint style="info" %}
 Passport is required for this package so it will be installed if it isn't already.
{% endhint %}

This package supports auto-discovery so you do not need to register the service provider manually.

But, if you need to, in `config\app.php`:

```php
/*
 * Package Service Providers...
 */
DataHiveDevelopment\PassportIntrospectionServer\IntrospectionServiceProvider::class,
```

## Migrations

The Introspection Server package has one migration to modify the Laravel Passport `oauth_clients` table and add a `can_introspect` column. You can read how to disable and publish them [here](configuration.md#migrations).

## Passport Installation

If you haven’t already done so, make sure you follow [Passport’s Installation docs](https://laravel.com/docs/7.x/passport#installation).

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
    // ...
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
```

It is recommended that you use some sort of authorization on the introspection route. We recommend that you use the `Client Credentials` grant so you will want to make sure you register the `CheckCredentials` middleware in your `app/Http/Kernel.php` file:

```php
use Laravel\Passport\Http\Middleware\CheckClientCredentials;

protected $routeMiddleware = [
    'client' => CheckClientCredentials::class,
];
```

