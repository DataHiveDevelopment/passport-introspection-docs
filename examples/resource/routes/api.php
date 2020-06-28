<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->prefix('/examples')->name('api.examples.')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user');

    Route::middleware('scope:messages.read')->get('/messages', function (Request $request) {
        return response()->json([
            'count' => 1,
            'messages' => [
                [
                    'id' => 0,
                    'from' => 'Keyes, Jacob (UNSC Captain) <keyes.jacob@unsc.gov>',
                    'subject' => 'Deployment Orders',
                    'body' => "Get Cortana off this ship. Keep her safe from the enemy. If they capture her, they'll learn everything. Force deployment, weapons research... Earth."
                ]
            ]
        ]);
    })->name('messages');

    Route::get('/notifications', function () {
        return response()->json([
            [
                'id' => 0,
                'priority' => 'high',
                'body' => 'You have new messages from Captain Keyes.'
            ]
        ]);
    })->name('notifications');
});
