<?php

use Illuminate\Support\Facades\Route;
use Lcobucci\JWT\Parser;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', 'AuthController@redirect')->name('login');
Route::get('/login/callback', 'AuthController@callback')->name('login.callback');
Route::post('/logout', 'AuthController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/example')->name('example.')->group(function () {
    Route::get('/getClientCredentialsToken', 'ExampleController@getClientCredentialsToken')->name('tokens.client_credentials');
    Route::get('/checkToken', 'ExampleController@checkToken')->name('introspect');

    Route::get('/refresh', function () {
        $http = new \GuzzleHttp\Client;
    
        $response = $http->post(config('services.oauth.token_url'), [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => \Auth::user()->refresh_token,
                'client_id' => config('services.oauth.client_id'),
                'client_secret' => config('services.oauth.client_secret'),
                'scope' => 'user.read',
            ],
        ]);
        $tokens = json_decode((string) $response->getBody(), true);

        Auth::user()->update([
            'access_token' => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token'],
            'expires_at' => \Carbon\Carbon::now()->addSeconds($tokens['expires_in']),
        ]);
    
        return redirect()->route('home');
    })->name('refresh');
});
