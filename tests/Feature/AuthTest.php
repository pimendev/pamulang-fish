<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_and_register_pages_are_accessible(): void
    {
        $this->seed();

        $this->get('/login')->assertStatus(200);
        $this->get('/register')->assertStatus(200);
    }

    public function test_guest_is_redirected_when_accessing_admin(): void
    {
        $this->seed();

        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_customer_cannot_access_admin_dashboard(): void
    {
        $this->seed();

        $customer = User::where('role', 'customer')->first();

        $response = $this->actingAs($customer)->get('/admin');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $this->seed();

        $admin = User::where('role', 'super_admin')->first();

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
    }
}
