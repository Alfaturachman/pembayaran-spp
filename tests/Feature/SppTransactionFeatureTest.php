<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Payments;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SppTransactionFeatureTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Skenario 1: Admin dapat menyimpan data transaksi SPP baru.
     */
    public function test_admin_can_store_new_spp_payment()
    {
        $admin = User::factory()->create(['roles' => 'ADMIN']);

        $paymentData = [
            'nisn' => '123456789',
            'name' => 'Budi Santoso',
            'month' => 'Januari',
            'year' => '2024',
            'total_payment' => 150000,
        ];

        $response = $this->actingAs($admin)->post('/admin/data-spp', $paymentData);

        $response->assertRedirect(route('data-spp.index'));
        $this->assertDatabaseHas('payments', [
            'nisn' => '123456789',
            'name' => 'Budi Santoso',
            'month' => 'Januari',
        ]);
    }

    /**
     * Skenario 2: Siswa hanya dapat melihat log pembayaran miliknya sendiri.
     */
    public function test_student_can_only_view_own_spp_payments()
    {
        $student = User::factory()->create([
            'roles' => 'STUDENT',
            'nisn' => '999888777',
            'name' => 'Siswa A',
        ]);

        // Transaction for this student
        Payments::create([
            'id_user' => $student->id,
            'nisn' => $student->nisn,
            'name' => $student->name,
            'month' => 'Februari',
            'year' => '2024',
            'total_payment' => 150000,
        ]);

        $response = $this->actingAs($student)->get('/student/data-log-spp');

        $response->assertStatus(200);
        $response->assertSee('Februari');
    }

    /**
     * Skenario 3: Siswa dilarang mengakses halaman admin data-spp (403/Forbidden Redirect).
     */
    public function test_student_cannot_access_admin_spp_route()
    {
        $student = User::factory()->create(['roles' => 'STUDENT']);

        $response = $this->actingAs($student)->get('/admin/data-spp');

        $response->assertRedirect('/');
    }
}
