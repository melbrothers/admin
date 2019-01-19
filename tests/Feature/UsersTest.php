<?php
namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Testing\DatabaseTransactions;

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
    public function a_user_profile_can_be_viewed()
    {
        $user = $this->signIn();
        // should work
        $this->get( '/v1/users/' . $user->slug);
        $this->seeStatusCode(200);
        // test json response
        $this->seeJsonContains(['email' => $user->email]);
    }

    /** @test */
    public function authenticated_user_can_view_current_user()
    {
        // should work
        $this->get('/v1/users/me');
        $this->seeStatusCode(401);
        $user = $this->signIn();
        // should work
        $this->get('/v1/users/me');
        // test json response
        $this->seeJsonContains(['email' => $user->email]);
    }

    /** @test */
    public function authenticated_user_can_upload_a_avatar()
    {
        $this->signIn();
        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg');
        $this->call('POST', '/v1/users/avatar', [], [], [
            'avatar' => $file
        ]);
        $this->seeStatusCode(200);
    }
}