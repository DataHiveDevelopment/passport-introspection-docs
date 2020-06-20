---
description: The Introspection Server package can be deployed in as few as 3 steps.
---

# Configuration

## Overview

To configure introspection, you will need to:

1. [ ] Register the introspection routes
2. [ ] Add the `getIntrospectionId()` method on your `User` model
3. [ ] Define ”trusted” OAuth Clients that can perform introspection

## Register the Routes

In your `App\Providers\AuthServiceProvider.php`, call the `Introspection::routes()` method after the `Passport::routes()` call:

```php
<?php

use DataHiveDevelopment\Introspection\Introspection;
// ...
public function boot()
{
    $this->registerPolicies();

    Passport::routes();

    Introspection::routes();
}
```

## Identify Users

As stated earlier, you should have a unique identifier that you can use to identiy users across services. Whether that is email \(not recommended\) or a UUID \(recommended\), you need to inform the Introspection server so it can return the right user in the introspection response for the Introspection Client.

In your `User` model, add the following method:

```php
/**
 * Return the attribute that represents the users global ID to the resource servers.
 *
 * @return string
 */
public function getIntrospectionId()
{
    return $this->attributes['uuid'];
}
```

The method should return the value of the appropriate attribute. In the above example, we are using a `UUID` column.

## OAuth Clients for Introspection

As a security feature, the OAuth Introspection spec encourages protecting who can perform introspection as it can reveal sensitive details about your users or your systems.

The Introspection Server package has this enforcement via either a database value or via a model method. The model method will override the database if both are defined.

### Database Column \(Recommended\) <a id="database-column"></a>

The Introspection Server package includes a database migration that adds a `can_introspect` boolean column to the `oauth_clients` table from Passport.

At this time, you will need to manually update the value in the database after creating the client for your resource server\(s\).

### Client Model

If you can’t or don’t want to use the database, you can use a custom Passport Client model.

Create a new model and extend `Laravel\Passport\Client`. [This section](https://laravel.com/docs/passport#overriding-default-models) of the Passport documentation outlines that process.

Next, add a `canIntrospect()` method to the model and define your critera. The method must only return a boolean true or false.

```php
/**
 * Determine if this client is allowed to request token introspection.
 *
 * @return boolean
 */
public function canIntrospect()
{
    // return ($this->name === ‘My Resource Server’);
}
```

