<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Lixing',
            'last_name' => 'Zhang',
            'email' => 'zlxjackie@hotmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        ]);
        DB::table('users')->insert([
            'first_name' => 'Test',
            'last_name' => 'user',
            'email' => 'test@test.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        ]);
    }
}
