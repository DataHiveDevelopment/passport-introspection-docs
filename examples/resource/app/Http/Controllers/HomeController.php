<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $authApiUser = Http::withToken(Auth::user()->access_token)->acceptJson()->get(config('services.oauth.base_url').'/api/user');
        $appApiUser = Http::withToken(Auth::user()->access_token)->acceptJson()->get(route('api.examples.user'));
        $scopeApi = Http::withToken(Auth::user()->access_token)->acceptJson()->get(route('api.examples.scope'));

        $parser = new \Lcobucci\JWT\Parser();
        $token = $parser->parse(Auth::user()->access_token);

        return view('home')->with([
            'authApiUser' => $authApiUser->body(),
            'appApiUser' => $appApiUser->body(),
            'scopeApi' => $scopeApi->body(),
            'token' => $token,
        ]);
    }
}
