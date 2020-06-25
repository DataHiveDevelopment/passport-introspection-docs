# Configuration

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

