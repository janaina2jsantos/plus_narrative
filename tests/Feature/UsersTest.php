<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UsersTest extends TestCase
{
    public function test_unauthenticated_user_cannot_access_users_pages()
    {
        $user = User::factory()->create();
        
        $response = $this->get(route('dashboard'));
        $response->assertRedirect('/login');

        $response = $this->get(route('users.create'));
        $response->assertRedirect('/login');

        $response = $this->get(route('users.edit', ['id' => $user->id]));
        $response->assertRedirect('/login');

        // content manager
        $contentUser = User::factory()->create();
        $contentUser->assignRole('content manager');
        $this->actingAs($contentUser);

        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);

        $response = $this->get(route('users.edit', ['id' => $contentUser->id]));
        $response->assertStatus(200);

        // admin
        $adminUser = User::factory()->create();
        $adminUser->assignRole('admin');
        $this->actingAs($adminUser);

        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);

        $response = $this->get(route('users.create'));
        $response->assertStatus(200);

        $response = $this->get(route('users.edit', ['id' => $adminUser->id]));
        $response->assertStatus(200);
    }
}
