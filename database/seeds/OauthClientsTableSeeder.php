<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthClientsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'id' => 1,
            'name' => 'Lumen Personal Access Client',
            'secret' => 'KUbJSd4dZY9fkoDXvsVjY2qL0dIQIE2dI5erCHZa',
            'redirect' => 'http://localhost',
            'personal_access_client' => 1,
            'password_client' => 0,
            'revoked' => 0,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

        DB::table('oauth_personal_access_clients')->insert([
            'id' => 1,
            'client_id' => 1,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

        DB::table('oauth_clients')->insert([
            'id' => 2,
            'name' => 'Lumen Password Grant Client',
            'secret' => 'gwqmG8r8rz8LuVSgDmpey7kZY0wVUqiZRKm0F4tq',
            'redirect' => 'http://localhost',
            'personal_access_client' => 0,
            'password_client' => 1,
            'revoked' => 0,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);
    }
}