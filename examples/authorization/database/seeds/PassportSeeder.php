<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Client;

class PassportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('passport:install');

        $client = Client::create([
            'user_id' => App\User::first()->id,
            'name' => 'Resource A',
            'secret' => \Str::random(40),
            'redirect' => env('EXAMPLE_RESOURCE_SERVER_CALLBACK', 'http://resource.test/login/callback'),
            'personal_access_client' => false,
            'password_client' => false,
            'revoked' => false,
        ]);

        $client = Client::create([
            'name' => 'Resource A Client Credentials',
            'secret' => \Str::random(40),
            'redirect' => '',
            'personal_access_client' => false,
            'password_client' => false,
            'revoked' => false,
            'can_introspect' => true,
        ]);
    }
}
