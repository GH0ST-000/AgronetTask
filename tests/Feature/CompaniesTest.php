<?php

namespace Tests\Feature;

use App\Models\Companies;
use App\Models\User;
use Database\Factories\CompaniesFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class CompaniesTest extends TestCase
{
    use RefreshDatabase,WithFaker;


    public function test_get_all_items()
    {
        $user =User::factory()->create([
            'name' => fake()->name(),
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'is_admin' => true
        ]);
        $credentials = [
            'email' => 'user@example.com',
            'password' => 'password',
        ];
        $response = $this->postJson('/api/login', $credentials);

        $response->assertStatus(200);

        $token = $response->json('token');

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->getJson('/api/companies');

        $response->assertStatus(200);

    }

    public function test_create_new_items(){
        $user =User::factory()->create([
            'name' => fake()->name(),
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'is_admin' => true
        ]);
        $credentials = [
            'email' => 'user@example.com',
            'password' => 'password',
        ];
        $response = $this->postJson('/api/login', $credentials);

        $response->assertStatus(200);

        $token = $response->json('token');
        $itemData = [
            'name' => 'Test Item',
            'email' => 'test@gmail.com'
        ];
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->post('/api/companies',$itemData);


        $response->assertStatus(201);

        $response->assertJsonFragment($itemData);
    }

    public function test_update_request(){

        User::factory()->create([
            'name' => fake()->name(),
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'is_admin' => true
        ]);
        $item = Companies::factory()->create();
        $credentials = [
            'email' => 'user@example.com',
            'password' => 'password',
        ];
        $response = $this->postJson('/api/login', $credentials);
        $token = $response->json('token');
        $itemData = [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'website'=>fake()->url(),
        ];
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->put('/api/companies/'.$item->id,$itemData);

        $response->statusText("ok");

    }

    public function test_delete_route(){
        User::factory()->create([
            'name' => fake()->name(),
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'is_admin' => true
        ]);
        $item = Companies::factory()->create();
        $credentials = [
            'email' => 'user@example.com',
            'password' => 'password',
        ];
        $response = $this->postJson('/api/login', $credentials);
        $token = $response->json('token');


        $item = Companies::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->delete('/api/companies/'.$item->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('companies', [
            'id' => $item->id
        ]);

    }

}
