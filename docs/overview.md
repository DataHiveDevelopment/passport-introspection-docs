# Overview

If you aren't familiar with OAuth introspection, I recommend having a read [through this](https://www.oauth.com/oauth2-servers/token-introspection-endpoint/) to get familiar with it. Here is the[ RFC-7662](https://tools.ietf.org/html/rfc7662) if your into that kinda thing as well.

Everyone caught up? Great! Let's get started then!

### What Do I Need to Get Started?

One Laravel application to act as your authorization server, and at least one Laravel resource server. You need a way to track users across your authorization and resource servers so I would highly recommend that you have some form of central authentication configured around your authorization and resource servers.

Since we are already talking Passport, why not use OAuth to login users on your resource servers? The exact scope of how to do this is outside this projects scope but the [example applications](https://github.com/DataHiveDevelopment/passport-introspection-docs/tree/master/examples) are configured like this if you want to get an idea.

{% hint style="info" %}
The example applications are just that: Examples. The code written is purely to make a working example and can greatly be improved upon.

For example, the `AuthController` on the resource servers could be rewritten and simplified by using a custom [Socialite Provider](https://socialiteproviders.netlify.app/contribute.html).
{% endhint %}



