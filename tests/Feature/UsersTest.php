<?php
namespace Tests\Feature;

use App\User;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Passport\Token;

class UsersTest extends \TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function get_a_non_existing_user()
    {
        // accessing invalid user should give 404
        $this->get( '/v1/users/13232323');
        $this->assertResponseStatus(404);
    }

    /** @test */
    public function get_a_user_profile()
    {
        $user = factory(User::class)->create();
        // authenticate
        $user->withAccessToken(new Token(['scopes' => ['*']]));
        $this->actingAs($user);
        // should work
        $this->get( '/v1/users/' . $user->id);
        $this->seeStatusCode(200);
        // test json response
        $this->seeJsonContains(['email' => $user->email]);
    }

    /** @test */
    public function get_current_user()
    {
        // should work
        $this->get('/v1/users/me');
        $this->seeStatusCode(401);

        $user = factory(User::class)->create();
        // authenticate
        $user->withAccessToken(new Token(['scopes' => ['*']]));
        $this->actingAs($user);
        // should work
        $this->get('/v1/users/me');
        // test json response
        $this->seeJsonContains(['email' => $user->email]);
    }
}