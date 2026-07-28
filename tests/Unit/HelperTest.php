<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class HelperTest extends TestCase
{
    /**
     * Skenario Positif (Happy Path):
     * Menguji fungsi set_active() mengembalikan 'active' saat route saat ini cocok dengan string tunggal.
     */
    public function test_set_active_returns_default_active_class_when_route_matches_string()
    {
        Route::shouldReceive('is')
            ->once()
            ->with('admin')
            ->andReturn(true);

        $result = set_active('admin');

        $this->assertEquals('active', $result);
    }

    /**
     * Skenario Positif (Happy Path):
     * Menguji fungsi set_active() mengembalikan 'active' saat route saat ini cocok dengan salah satu item dalam array.
     */
    public function test_set_active_returns_active_when_route_matches_array()
    {
        Route::shouldReceive('is')
            ->once()
            ->with('data-siswa.index')
            ->andReturn(true);

        $result = set_active(['data-siswa.index', 'data-siswa.create']);

        $this->assertEquals('active', $result);
    }

    /**
     * Skenario Positif (Happy Path):
     * Menguji fungsi set_active() mengembalikan custom output class jika diberikan argumen kedua.
     */
    public function test_set_active_returns_custom_output_class()
    {
        Route::shouldReceive('is')
            ->once()
            ->with('dashboard')
            ->andReturn(true);

        $result = set_active('dashboard', 'is-active-tab');

        $this->assertEquals('is-active-tab', $result);
    }

    /**
     * Skenario Negatif (Edge Case):
     * Menguji fungsi set_active() mengembalikan null saat route saat ini tidak cocok.
     */
    public function test_set_active_returns_null_when_route_does_not_match()
    {
        Route::shouldReceive('is')
            ->with('unknown-route')
            ->andReturn(false);

        $result = set_active('unknown-route');

        $this->assertNull($result);
    }
}
