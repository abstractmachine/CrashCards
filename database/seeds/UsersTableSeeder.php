<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'robin',
            'email' => 'morettirobin@brosign.fr',
            'password' => bcrypt('121212'),
        ]);
    }
}
