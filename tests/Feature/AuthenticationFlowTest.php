<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationFlowTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Skenario 1: Halaman login dapat diakses publik (Guest).
     */
    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Skenario 2: Login berhasil mengarahkan pengguna ke route /auth.
     */
    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
            'roles' => 'ADMIN',
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/auth');
    }

    /**
     * Skenario 3: Redirection hub /auth mengarahkan ADMIN ke /admin/dashboard.
     */
    public function test_authenticated_admin_is_redirected_to_admin_dashboard()
    {
        $admin = User::factory()->create(['roles' => 'ADMIN']);

        $response = $this->actingAs($admin)->get('/auth');

        $response->assertRedirect(route('admin'));
    }

    /**
     * Skenario 4: Redirection hub /auth mengarahkan STUDENT ke /student/dashboard.
     */
    public function test_authenticated_student_is_redirected_to_student_dashboard()
    {
        $student = User::factory()->create(['roles' => 'STUDENT']);

        $response = $this->actingAs($student)->get('/auth');

        $response->assertRedirect(route('student'));
    }

    /**
     * Skenario 5: Pengguna tidak dapat login dengan password yang salah.
     */
    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'username' => $user->username,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
