<?php
namespace Tests\Feature;

use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Passport\Token;

class UsersTest extends \TestCase
{
    use DatabaseMigrations;

    public function testGettingSpecificUser()
    {
        // without authentication should give 401
        $this->call('GET', '/v1/users/12345');
        $this->seeStatusCode(401);
        $user = factory(User::class)->create();
        // authenticate
        $user->withAccessToken(new Token(['scopes' => ['*']]));
        $this->actingAs($user);
        // should work
        $this->call('GET', '/v1/users/'.$user->id);
        $this->seeStatusCode(200);
        // test json response
        $this->seeJson(['email' => $user->email]);
        // accessing invalid user should give 404
        $this->call('GET', '/v1/users/13232323');
        $this->assertResponseStatus(404);
    }
}