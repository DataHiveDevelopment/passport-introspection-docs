<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect the user to the authorization server to login.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function redirect(Request $request)
    {
        $request->session()->put('state', $state = \Str::random(40));

        $query = http_build_query([
            'client_id' => config('services.oauth.client_id'),
            'redirect_uri' => config('services.oauth.redirect'),
            'response_type' => 'code',
            'scope' => 'user.read',
            'state' => $state,
        ]);
        
        return redirect(config('services.oauth.authorize_url').'?'.$query);
    }

    /**
     * Handles the response from the authorization servers /oauth/authorize response and logs the user in.
     * A local entry in the Users table will be made if the user does not already exist.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request)
    {
        // We have authorization, now we need a token and can fetch the user
        $state = $request->session()->pull('state');

        throw_unless(
            strlen($state) > 0 && $state === $request->state,
            InvalidArgumentException::class
        );

        $response = (new \GuzzleHttp\Client)->post(config('services.oauth.token_url'), [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => config('services.oauth.client_id'),
                'client_secret' => config('services.oauth.client_secret'),
                'redirect_uri' => config('services.oauth.redirect'),
                'code' => $request->code,
            ],
        ]);
        $tokens = json_decode((string) $response->getBody(), true);

        // Call the /api/user route on our authorization server to fetch the user details
        $response = (new \GuzzleHttp\Client)->get(config('services.oauth.base_url').'/api/user', [
            'headers' => [
                'Authorization' => 'Bearer ' . $tokens['access_token'],
                'Accept'        => 'application/json',
            ]
        ]);
        $socialUser = json_decode((string) $response->getBody(), true);

        // Try and find a local user matching their ID
        // This ID should equal the value of the attribute that you are returning in 'getIntrospectionId()' method on the User model

        $localUser = User::whereUuid($socialUser['uuid'])->first();
        if ($localUser) {
            // Local user exists, update some attributes to stay in sync
            // These are all optional but we may use these attributes often in the UI so it saves us an API call.
            $localUser->update([
                'name' => $socialUser['name'],
                'access_token' => $tokens['access_token'],
                'refresh_token' => $tokens['refresh_token'],
                'expires_at' => \Carbon\Carbon::now()->addSeconds($tokens['expires_in'])
            ]);
        } else {
            $localUser = new User([
                'uuid' => $socialUser['uuid'],
                'name' => $socialUser['name'],
                'access_token' => $tokens['access_token'],
                'refresh_token' => $tokens['refresh_token'],
                'expires_at' => \Carbon\Carbon::now()->addSeconds($tokens['expires_in']),
            ]);
            $localUser->save();
        }

        Auth::login($localUser);
        $request->session()->regenerate();

        return $request->wantsJson()
                    ? new Response('', 204)
                    : redirect()->intended($this->redirectPath());
    }
}
