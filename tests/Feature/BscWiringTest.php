<?php

namespace Tests\Feature;

use App\Livewire\BscWiring;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BscWiringTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $permissions = [
            'view dashboard', 'view wiring', 'view ratios', 'view objectives',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->syncPermissions($permissions);

        $this->user = User::factory()->create(['is_active' => true]);
        $this->user->assignRole('Super Admin');
    }

    public function test_wiring_peta_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->user)->get(route('bsc-wiring'));

        $response->assertStatus(200);
        $response->assertSee('Wiring Diagram Hubungan BSC');
        $response->assertSee('35 sasaran');
        $response->assertSee('Wiring Rasio (Makro)');
        $response->assertSee('Wiring Sasaran Mutu (35 KPI)');
    }

    public function test_default_macro_view_displays_all_drivers_and_departments(): void
    {
        Livewire::actingAs($this->user)
            ->test(BscWiring::class)
            ->assertSet('activeTab', 'macro')
            ->assertSee('TARGET REVENUE')
            ->assertSee('Profitabilitas')
            ->assertSee('Aktivitas')
            ->assertSee('Produktivitas')
            ->assertSee('Likuiditas')
            ->assertSee('Solvabilitas')
            ->assertSee('Finance, Accounting')
            ->assertSee('General Affair')
            ->assertSee('Human Capital (HRD)')
            ->assertSee('Operations Manager')
            ->assertSee('Procurement')
            ->assertSee('Production')
            ->assertSee('Quality Management')
            ->assertSee('Research & Development')
            ->assertSee('Supply Chain Management')
            ->assertSee('TARGET YANG BERGESER')
            ->assertSee('0 sasaran terdampak')
            ->assertSee('SIMPUL YANG DISOROT')
            ->assertSee('Belum ada yang disorot');
    }

    public function test_switch_tab_to_kpi35_and_back(): void
    {
        Livewire::actingAs($this->user)
            ->test(BscWiring::class)
            ->call('switchTab', 'kpi35')
            ->assertSet('activeTab', 'kpi35')
            ->assertSee('FAT-01')
            ->assertSee('Rasio penagihan invoice')
            ->assertSee('OPS-01')
            ->assertSee('PRD-01')
            ->assertSee('dikunci')
            ->call('switchTab', 'macro')
            ->assertSet('activeTab', 'macro');
    }

    public function test_revenue_slider_adjusts_revenue_and_cascades_to_unlocked_kpis(): void
    {
        Livewire::actingAs($this->user)
            ->test(BscWiring::class)
            ->set('revenueSliderPercent', 10)
            ->assertSet('revenueSliderPercent', 10)
            // Revenue baseline is 96000 JT, +10% = 105600 JT -> '105.600'
            ->assertSee('105.600')
            ->assertSee('bergeser');
    }

    public function test_driver_stepper_adjustments(): void
    {
        Livewire::actingAs($this->user)
            ->test(BscWiring::class)
            ->call('adjustDriver', 'profitabilitas', 1)
            ->assertSet('stepperAdjustments.profitabilitas', 1)
            ->call('adjustDriver', 'profitabilitas', 2)
            ->assertSet('stepperAdjustments.profitabilitas', 3)
            ->call('adjustDriver', 'profitabilitas', -1)
            ->assertSet('stepperAdjustments.profitabilitas', 2);
    }

    public function test_node_selection_and_highlighting(): void
    {
        Livewire::actingAs($this->user)
            ->test(BscWiring::class)
            ->assertSet('selectedNode', null)
            ->call('selectNode', 'profitabilitas')
            ->assertSet('selectedNode', 'profitabilitas')
            ->assertSee('Kelompok Rasio Driver: Profitabilitas')
            ->assertSee('Transmisi Tingkat 2 (BSC Hop 2)')
            ->call('selectNode', 'profitabilitas')
            ->assertSet('selectedNode', null)
            ->assertSee('Belum ada yang disorot');
    }

    public function test_department_node_selection(): void
    {
        Livewire::actingAs($this->user)
            ->test(BscWiring::class)
            ->call('selectNode', 'FAT')
            ->assertSet('selectedNode', 'FAT')
            ->assertSee('Unit Kerja: Finance, Accounting & Tax')
            ->assertSee('DRIVER PENGGERAK')
            ->call('resetHighlight')
            ->assertSet('selectedNode', null);
    }

    public function test_locked_kpis_do_not_shift_when_revenue_changes(): void
    {
        $component = Livewire::actingAs($this->user)
            ->test(BscWiring::class)
            ->call('switchTab', 'kpi35')
            ->set('revenueSliderPercent', 20);

        // FAT-04 is locked with baseline 67.7%
        // It should still have 67.7 % and badge 'dikunci'
        $component->assertSee('FAT-04')
                  ->assertSee('67.7 %')
                  ->assertSee('dikunci');
    }

    public function test_unit_kerja_filter_in_kpi35_mode(): void
    {
        Livewire::actingAs($this->user)
            ->test(BscWiring::class)
            ->call('switchTab', 'kpi35')
            ->set('selectedUnit', 'FAT')
            ->assertSee('FAT-01')
            ->assertDontSee('HC-01')
            ->set('selectedUnit', 'all')
            ->assertSee('HC-01');
    }

    public function test_reset_simulation_restores_defaults(): void
    {
        Livewire::actingAs($this->user)
            ->test(BscWiring::class)
            ->set('revenueSliderPercent', 15)
            ->call('adjustDriver', 'aktivitas', 5)
            ->call('selectNode', 'aktivitas')
            ->call('resetSimulation')
            ->assertSet('revenueSliderPercent', 0)
            ->assertSet('stepperAdjustments.aktivitas', 0)
            ->assertSet('selectedNode', null)
            ->assertSee('Simulasi berhasil di-reset ke baseline target awal');
    }
}
