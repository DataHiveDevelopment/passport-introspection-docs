# Troubleshooting

## Testing The Introspection Endpoint

You can manually test the introspection endpoint on your authorization server using tools such as [Postman](https://www.postman.com/).

## Using Postman

{% api-method method="post" host="http://authorization.test" path="/south/introspect" %}
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

```
// Fill this in from a Postman example
```
{% endapi-method-response-example %}

{% api-method-response-example httpCode=401 %}
{% api-method-response-example-description %}
Several conditions may return a 401 response.  
  
If the OAuth token passed in the Authorization header is invalid, an unauthorized response will be returned with nothing else.
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



