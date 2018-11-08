<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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

        DB::table('workshops')->insert([
            'name' => 'china',
            'index' => '1',
            'locked' => false,
            'author_id' => 1,
        ]);

        DB::table('teams')->insert([
        ]);

        DB::table('decks')->insert([
        ]);

        DB::table('hands')->insert([
        ]);

        DB::table('links')->insert([
            'url' => 'http://robinmoretti.eu',
            'title' => 'robin',
            'workshop_id' => '1',
        ]);

        DB::table('categories')->insert([
            'name' => 'http://robinmoretti.eu',
            'color' => 'rgb(100,100,100)',
            'background_color' => 'rgb(28,28,28)',
            'index' => 1,
        ]);	


    }
}
