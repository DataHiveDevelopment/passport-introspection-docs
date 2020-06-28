# Configuration

## Environment Configuration

Add the following variables to your `.env` file:

```text
INTROSPECTION_INTROSPECT_URL=
INTROSPECTION_TOKEN_URL=
INTROSPECTION_CLIENT_ID=
INTROSPECTION_CLIENT_SECRET=
```

See [Usage &gt; Resource Servers](usage.md) to understand the details to fill in here.

## Other Optional Configuration Options

### Introspection Scopes

If you are using a scope on your introspection endpoint, you can define the scopes to be requested by providing a space-separated list in your `.env` file.

```text
INTROSPECTION_TOKEN_SCOPES="user.read introspect"
```

## Authentication Guard

In your `config/auth.php` configuration file, you should set the `driver` option of the `api` authentication guard to `introspect`.

```text
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'introspect',
        'provider' => 'users',
    ],
],
```

## User Trait

Similar to Passport, we have a `HasIntrospectedToken` trait you can register on your `User` model. This trait is really only useful when working with your API routes as it does not contain the same methods to fetch all access tokens or create one for the user.

It does still give you access to the current token being used in the request and allow you to check if the token has a scope on it.

```php
<?php

namespace App;

use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DataHiveDevelopment\PassportIntrospectionClient\HasIntrospectedToken;

class User extends Authenticatable
{
    use HasIntrospectedToken, Notifiable;
        
    // ...
}
```

The following methods are available:

`token()`: Returns an instance of a Passport Token. You should note that not all methods on a normal Passport Token will function. For example, any of the relationships will return an error as the data simply doesn't exist on our resource servers. But it does give you access to the client\_id, scopes and expires\_at attributes.

{% hint style="info" %}
You can access these attributes like so:

* Auth::user\(\)-&gt;token\(\)-&gt;client\_id
* Auth::user\(\)-&gt;token\(\)-&gt;scopes
* Auth::user\(\)-&gt;token\(\)-&gt;expires\_at
{% endhint %}

`tokenCan()`: Checks if a given scope \(passed as a string\) is valid for the token in use. Returns true if the token has all scopes via `*`.

## Identify Users

Just like on your authorization server, the client package needs to be able to find users using the unique ID provided by the authorization server. Add the following method your `User` model:

```php
/**
 * Find the user by the given introspection user_id.
 *
 * @param  string  $id
 * @return \App\User
 */
public function findForIntrospection($id)
{
    return $this->where('uuid', $id)->first();
}
```

Again, we are using a `UUID` column to store our users ID. This method should return the user model that matches the given ID.

## Javascript

We support using Introspection from your Javascript frontend using the same middleware that Passport provides. In fact, we use Passport's middleware!

To enable this functionality, register the `CreateFreshApiTokens` middleware in your `web` middleware group in your `app/Http/Kernel.php` file:

```php
'web' => [
    // Other middleware...
    \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
],
```

You can read up on this functionality in the [official Passport documentation](https://laravel.com/docs/passport#consuming-your-api-with-javascript).

You can customize the cookie name using the `Passport::cookie` method in your `AuthServiceProvider`.

