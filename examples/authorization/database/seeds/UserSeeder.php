<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = App\User::create([
            'name' => 'John',
            'email' => 'john117@unsc.test',
            'email_verified_at' => now(),
            'password' => \Hash::make('Cortana!'),
            'remember_token' => Str::random(10),
        ]);

        factory(App\User::class, 2)->create();
    }
}
