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

### Introspection Response TTL

To reduce network traffic, time to response and the workload on your authorization server, the Introspection Client package will cache the introspection response for, a configurable, 15 minutes. You can change or disable this behavior by changing the `introspection_cache_ttl` in the `introspection.php` config file.

```php
// Time in seconds, 15 minutes by default - Set to 0 to disable caching
'introspection_cache_ttl' => 900,
```

{% hint style="danger" %}
**Security Warning:** Caching the introspection response could pose a security risk as your resource servers will continue to respond to api calls using a revoked access token until the TTL expires.
{% endhint %}

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

