---
description: You will install the Introspection Client on each of your resource servers.
---

# Installation

## Package Installation

On your Resource Server\(s\), run the following:

```bash
composer require datahivedevelopment/passport-introspection-client
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
DataHiveDevelopment\PassportIntrospectionClient\IntrospectionServiceProvider::class,
```

## 

