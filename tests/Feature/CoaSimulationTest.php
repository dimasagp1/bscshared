<?php

namespace Tests\Feature;

use App\Livewire\CoaSimulation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CoaSimulationTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $permissions = [
            'view coa',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->syncPermissions($permissions);

        $this->user = User::factory()->create(['is_active' => true]);
        $this->user->assignRole('Super Admin');
    }

    public function test_coa_simulation_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->user)->get(route('coa'));
        $response->assertStatus(200);
        $response->assertSee('Simulasi Murni CoA Sandbox (Tanpa Dampak Persisten)');
        $response->assertSee('32.64%');
        $response->assertSee('3.43x');
        $response->assertSee('Rp 181 JT');
        $response->assertSee('PENYESUAIAN SANDBOX AKUN KUNCI (JUTA RUPIAH)');
        $response->assertSee('PERBANDINGAN SALDO AKUN AKTUAL VS SIMULASI');
    }

    public function test_all_9_coa_accounts_are_rendered(): void
    {
        $codes = ['1101', '1102', '1103', '1201', '2101', '3101', '4101', '5101', '6101'];

        $component = Livewire::actingAs($this->user)->test(CoaSimulation::class);

        foreach ($codes as $code) {
            $component->assertSee($code);
        }

        $component->assertSee('Kas & Bank Utama');
        $component->assertSee('Piutang Usaha (Distributor & Apotek)');
        $component->assertSee('Persediaan Bahan Baku & Barang Jadi');
        $component->assertSee('Aset Tetap Pabrik & Mesin');
        $component->assertSee('Utang Usaha & Pemasok Bahan');
        $component->assertSee('Modal Saham & Laba Ditahan');
        $component->assertSee('Penjualan Produk Herbal & Farmasi');
        $component->assertSee('Harga Pokok Penjualan (HPP)');
        $component->assertSee('Beban Operasional & Distribusi');
    }

    public function test_slider_adjustment_and_reset_simulation(): void
    {
        Livewire::actingAs($this->user)
            ->test(CoaSimulation::class)
            ->set('delta_4101', 100)
            ->assertSet('delta_4101', 100)
            ->call('resetSimulation')
            ->assertSet('delta_4101', 0)
            ->assertSet('delta_1101', 0)
            ->assertSet('delta_1102', 0)
            ->assertSee('Simulasi CoA berhasil di-rollback ke saldo aktual (Base SSOT).');
    }
}

