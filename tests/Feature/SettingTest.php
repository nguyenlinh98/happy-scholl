<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Setting;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tymon\JWTAuth\Facades\JWTAuth;



class SettingTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * Test for Display a listing of the resource.
     * GET /api/system_statuses
     *
     * @return void
     */
    public function testGetSettings()
    {
        // Create user for getting token authorization
        $user = factory(User::class)->create();
        $headers = ['Authorization' => 'Bearer ' . JWTAuth::fromUser($user)];

        // Create Settings
        $item= factory(Setting::class)->create();
        $item= factory(Setting::class)->create();

        $data = [];

        $response = $this->json('GET', '/api/system_statuses', $data, $headers);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
               '*' => [
                   'id' //TODO, 'name', 'display_order'
               ]
            ]
        ]);
    }

    /**
     * Test for Display the specified resource.
     * GET /api/system_statuses/{id}
     *
     * @return void
     */
    public function testGetSetting()
    {
         // Create user for getting token authorization
        $user = factory(User::class)->create();
        $headers = ['Authorization' => 'Bearer ' . JWTAuth::fromUser($user)];

        $item= factory(Setting::class)->create();
        
        $data = [];

        $response = $this->json('GET', '/api/system_statuses/'.$item->id, $data, $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                   'id'//TODO, 'name', 'display_order'
            ]
        ]);
    }

    /**
     * Test for Store a newly created resource in storage.
     * POST /api/system_statuses
     *
     * @return void
     */
    public function testStoreSetting()
    {
        // Create user for getting token authorization
        $user = factory(User::class)->create();
        $headers = ['Authorization' => 'Bearer ' . JWTAuth::fromUser($user)];

        $data = [
            //TODO
        ];

        $response = $this->json('POST', '/api/system_statuses/', $data, $headers);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                   'id'//TODO , 'name', 'display_order'
            ]
        ]);
        $response->assertJsonFragment($data);
    }


    /**
     * Test for Update the specified resource in storage.
     * PATCH /api/system_statuses/{id}
     *
     * @return void
     */
    public function testUpdateSetting()
    {
        // Create user for getting token authorization
        $user = factory(User::class)->create();
        $headers = ['Authorization' => 'Bearer ' . JWTAuth::fromUser($user)];

        $item= factory(Setting::class)->create();

        $data = [
            //TODO
        ];

        $this->patch('api/system_statuses/'.$item->id, $data, $headers)
        ->assertStatus(200)
        ->assertJsonFragment($data);
    }

    
    /**
     * Test for Remove the specified resource from storage.
     * DELETE /api/system_statuses/{id}
     *
     * @return void
     */
    public function testDeleteSetting()
    {
        // Create user for getting token authorization
        $user = factory(User::class)->create();
        $headers = ['Authorization' => 'Bearer ' . JWTAuth::fromUser($user)];

        $item= factory(Setting::class)->create();
        $response = $this->json('DELETE', '/api/system_statuses/'.$item->id,[], $headers);
        $response->assertStatus(204);
    }

}