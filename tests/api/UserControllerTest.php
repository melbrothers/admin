<?php
/**
 * Created by PhpStorm.
 * User: Lixing
 * Date: 2018-12-20
 * Time: 21:25
 */
namespace Tests\Api;

class UserControllerTest extends \TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->call('GET', '/');

        $this->assertEquals(200, $response->status());
    }
}