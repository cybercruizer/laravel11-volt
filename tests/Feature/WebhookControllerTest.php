<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Pembayaran2425;
use App\Models\Siswa;

class WebhookControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_spp_data_for_a_student()
    {
        // Setup: Create a student and a payment record
        $siswa = Siswa::factory()->create(['nis' => '12345']);
        Pembayaran2425::factory()->create([
            'nis' => '12345',
            'nama' => $siswa->nama,
            'jenis' => 'A',
            'jumlah' => 500000,
        ]);

        // Action: Call the endpoint
        $response = $this->getJson('/api/webhook/spp/12345');

        // Assertion: Check the response
        $response->assertStatus(200)
            ->assertJson([
                'nis' => '12345',
                'jenis' => 'A',
                'jumlah' => 500000,
            ]);
    }

    /** @test */
    public function it_returns_404_if_no_spp_data_is_found()
    {
        // Action: Call the endpoint with a NIS that has no payment
        $response = $this->getJson('/api/webhook/spp/99999');

        // Assertion: Check the response
        $response->assertStatus(404)
            ->assertJson(['message' => 'Data not found']);
    }

    /** @test */
    public function it_returns_404_if_student_has_no_type_a_payment()
    {
        // Setup: Create a student and a non-'A' type payment
        $siswa = Siswa::factory()->create(['nis' => '54321']);
        Pembayaran2425::factory()->create([
            'nis' => '54321',
            'nama' => $siswa->nama,
            'jenis' => 'B', // Different type
            'jumlah' => 100000,
        ]);

        // Action: Call the endpoint
        $response = $this->getJson('/api/webhook/spp/54321');

        // Assertion: Check the response
        $response->assertStatus(404)
            ->assertJson(['message' => 'Data not found']);
    }
}
