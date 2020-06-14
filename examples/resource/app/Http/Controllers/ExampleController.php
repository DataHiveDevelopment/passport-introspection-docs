<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ExampleController extends Controller
{
    /**
     * Get a Client Credentials token.
     *
     * @return \Illuminate\Http\Response
     */
    public function getClientCredentialsToken()
    {
        // Get Client Credentials token
        $response = Http::post(config('services.oauth.token_url'), [
            'grant_type' => 'client_credentials',
            'client_id' => config('services.introspection.client_id'),
            'client_secret' => config('services.introspection.client_secret'),
            'scope' => '*',
        ]);
        
        return response(json_decode((string) $response->getBody(), true)['access_token']);
    }

    /**
     * Test introspection with logged in users access token.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkToken(Request $request)
    {
        $token = $this->getClientCredentialsToken()->content();

        $response = Http::withToken($token)->post(config('services.oauth.base_url').'/oauth/introspect', [
            'token' => $request->token,
        ]);

        return response($response->body());
    }
    
    /**
     * Call to local API using access token from Authorization server.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function introspected(Request $request)
    {
        // Make API call to local /api/example/introspected
        $response = Http::withToken(Auth::user()->access_token)->get(route('api.example.introspected'));

        return response($response->body());
    }
}
