---
description: >-
  Now that you have the necessary packages installed on your authorization and
  at least one resource server, now you can setup OAuth clients needed to
  perform introspection.
---

# Resource Servers

## OAuth Clients

You will need to register two OAuth clients in Passport on your authorization server.

### Authorization Grant

This will be used to login users to your resource servers. This technically isn’t part of introspection, but since you need to login users to your resource servers, it’s probably a good idea to use this grant for your web applications. I won’t go too much into this but you can check the [example](https://github.com/DataHiveDevelopment/passport-introspection-docs/tree/master/examples) servers for this in the [GitHub repository](https://github.com/DataHiveDevelopment/passport-introspection-docs) to get a better idea of how that might work.

### Client Credentials Grant

This is used by Introspection Client package to authenticate with the `/oauth/introspect` endpoint on your authorization server. 

Using artisan, you can generate these credentials:

```php
php artisan passport:client --client 
```

Check out the [Passport documentation](https://laravel.com/docs/passport#client-credentials-grant-tokens) for more details on generating the tokens. After creating the client, don’t forget to update the `can_introspect` column in the database to `true`.

## Resource Server Configuration

Head over to your resource server and update the `.env` configuration:

```text
INTROSPECTION_AUTHORIZATION_URL=http://auth.test/oauth/authorize
INTROSPECTION_TOKEN_URL=http://auth.test/oauth/token
INTROSPECTION_CLIENT_ID={Client Credentials ID}
INTROSPECTION_CLIENT_SECRET={Client Credentials secret}
```

{% hint style="info" %}
Remove the squiggle brackets, { and }, in the above example when updating it in your `.env` file.
{% endhint %}

## Introspection

Any requests to routes in your `routes/api.php` file using the `auth:api` middleware will have the bearer tokens checked against the authorization server via introspection.

{% hint style="info" %}
To reduce network traffic, time to response and the workload on your authorization server, the Introspection Client packageg will cache the introspection response for, a configurable, 1 hour.
{% endhint %}

If properly configured, you can use Laravel’s helpers like `Auth()->user()` to access the user associated with the access token.
