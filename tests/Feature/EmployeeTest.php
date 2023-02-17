<?php

namespace Tests\Feature;

use App\Models\Companies;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class EmployeeTest extends TestCase
{

    public function test_get_employee()
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
        ])->getJson('/api/employee');

        $response->assertStatus(200);
    }
    public function test_create_new_items(){
        $user =User::factory()->create([
            'name' => fake()->name(),
            'email' => 'user1@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'is_admin' => true
        ]);
        $item = Companies::factory()->create();
        $credentials = [
            'email' => 'user1@example.com',
            'password' => 'password',
        ];
        $response = $this->postJson('/api/login', $credentials);


        $response->assertStatus(200);

        $token = $response->json('token');
        $itemData = [
            'first_name'=>'LD',
            'last_name'=>'DL',
            'companies_id'=>$item->id
        ];
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->post('/api/employee',$itemData);


        $response->assertStatus(201);

        $response->setStatusCode(201);
    }
}
