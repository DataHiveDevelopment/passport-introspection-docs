---
description: >-
  If you run into some issues or are receiving an error that you are not
  expecting, use this page to try and track down the issue.
---

# Troubleshooting

## Testing The Introspection Endpoint

You can manually test the introspection endpoint on your authorization server using tools such as [Postman](https://www.postman.com/).

## Using Postman

Postman is a fantastic API software development tool. It enables you to test calls to APIs and see the responses. It supports most of the common OAuth flows and allows you to manipulate and define every aspect of an HTTP request.

Postman is free but does offer some paid plans for larger teams. Check them out over at [https://www.postman.com/](https://www.postman.com/).

Enter the introspection endpoint as a POST request type: `http://authorization.test/oauth/introspect`

Under the "Params" tab, add a key-value pair with the key of `token` and a value being the bearer token belonging to a user requested via standard authorization code grant flow in Passport.

![Introspection Key Value Example](.gitbook/assets/screen-shot-2020-06-28-at-1.52.33-pm.png)

Under the "Authorization" tab, you will need to obtain a client credentials grant token. Select "OAuth 2.0" from the type dropdown, "Add authorization data to" should be set to "Request Headers" by default.

Click "Get New Access Token" and set the following options \(updating the URLs to match your environment as necessary\):

* Grant Type: Client Credentials
* Access Token URL: http://authorization.test/oauth/token
* Client ID: {The OAuth Client ID for your resource server's client credentials grant}
* Client Secret: {The OAuth Client Secret for your resource server's client credentials grant}
* Scope: \*
  * If you are using scope middleware on the Introspection endpoint on your authorization server, use those here instead of an asterisk.

Clicking "Request Token" should return a new token. Click "Use Token" to continue.

![Client Credentials Token Request Example](.gitbook/assets/screen-shot-2020-06-28-at-1.53.05-pm.png)

{% hint style="info" %}
If you receive an error or nothing happens, you can view the Passport console under View &gt; Show Postman Console.
{% endhint %}

Click "Send" next to the URL to make the introspection request. 

{% api-method method="post" host="http://authorization.test" path="/oauth/introspect" %}
{% api-method-summary %}
Introspection Endpoint
{% endapi-method-summary %}

{% api-method-description %}
Accepts an OAuth token and returns information on it’s validity and the associated user.
{% endapi-method-description %}

{% api-method-spec %}
{% api-method-request %}
{% api-method-form-data-parameters %}
{% api-method-parameter name="token" type="string" required=true %}
The OAuth token that you want to introspect.
{% endapi-method-parameter %}
{% endapi-method-form-data-parameters %}
{% endapi-method-request %}

{% api-method-response %}
{% api-method-response-example httpCode=200 %}
{% api-method-response-example-description %}
A successful introspection request will return a JSON string representing data from the token and the associated user’s unique identifier \(this is the value of the attribute returned by getIntrospectionId\(\) on the Introspection Server\).  
  
A 200 response will be returned in all other instances except for authorization exceptions.
{% endapi-method-response-example-description %}

```javascript
{
    "active": true,
    "scope": "user.read messages.read",
    "client_id": 3,
    "token_type": "access_token",
    "exp": 1624847526,
    "iat": 1593311526,
    "nbf": 1593311526,
    "sub": 1,
    "aud": 3,
    "jti": "e56a77435ab29d0834eee2ef0185fc708e34d77ba7603e6d60f3e40de4f04dda2f9e9781ac389bd9",
    "id": "87f96b2f-bb5d-446a-8fce-b37a9508561b"
}
```
{% endapi-method-response-example %}

{% api-method-response-example httpCode=401 %}
{% api-method-response-example-description %}
If the OAuth token passed in the Authorization header is invalid, expired or otherwise unusable, an unauthorized response will be returned with nothing else.
{% endapi-method-response-example-description %}

```
Unauthorized
```
{% endapi-method-response-example %}

{% api-method-response-example httpCode=403 %}
{% api-method-response-example-description %}
If the client requesting introspection is not allowed to do so, a 403: Forbidden response code will be returned along with an unauthorized error.
{% endapi-method-response-example-description %}

```
Unauthorized
```
{% endapi-method-response-example %}
{% endapi-method-response %}
{% endapi-method-spec %}
{% endapi-method %}



