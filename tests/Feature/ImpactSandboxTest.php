<?php

namespace Tests\Feature;

use App\Livewire\ImpactSandbox;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ImpactSandboxTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $permissions = [
            'view dampak',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->syncPermissions($permissions);

        $this->user = User::factory()->create(['is_active' => true]);
        $this->user->assignRole('Super Admin');
    }

    public function test_impact_sandbox_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->user)->get(route('dampak'));
        $response->assertStatus(200);
        $response->assertSee('Analisis What-If');
        $response->assertSee('Simulation Sandbox');
        $response->assertSee('KONTROL PARAMETER REALISASI KPI');
        $response->assertSee('FAT-01');
        $response->assertSee('Hitung Transmisi');
        $response->assertSee('Pilih KPI dan klik tombol');
    }

    public function test_calculate_transmission_renders_3_hop_diagram(): void
    {
        Livewire::actingAs($this->user)
            ->test(ImpactSandbox::class)
            ->assertSee('Pilih KPI dan klik tombol')
            ->call('calculateTransmission')
            ->assertSet('isCalculated', true)
            ->assertSee('HOP 1: SASARAN MUTU DEPARTEMEN')
            ->assertSee('HOP 2: POS LAPORAN KEUANGAN (COA)')
            ->assertSee('HOP 3: PERGESERAN RASIO FINANSIAL')
            ->assertSee('DSO')
            ->assertSee('1102 - Piutang Usaha');
    }

    public function test_tab_switching_works(): void
    {
        Livewire::actingAs($this->user)
            ->test(ImpactSandbox::class)
            ->call('setTab', 'table')
            ->assertSet('activeTab', 'table')
            ->assertSee('Nilai Baseline')
            ->call('setTab', 'journal')
            ->assertSet('activeTab', 'journal')
            ->assertSee('Debet')
            ->assertSee('Kredit')
            ->call('setTab', 'ledger')
            ->assertSet('activeTab', 'ledger')
            ->assertSee('Status Isolasi Sandbox');
    }
}

