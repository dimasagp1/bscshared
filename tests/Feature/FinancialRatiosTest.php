<?php

namespace Tests\Feature;

use App\Livewire\FinancialRatios;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FinancialRatiosTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $permissions = [
            'view ratios',
            'manage ratios',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->syncPermissions($permissions);

        $this->user = User::factory()->create(['is_active' => true]);
        $this->user->assignRole('Super Admin');
    }

    public function test_financial_ratios_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->user)->get(route('financial-ratios'));
        $response->assertStatus(200);
        $response->assertSee('5 Kelompok Rasio Keuangan');
        $response->assertSee('98.34%');
        $response->assertSee('HRIS Online : 20 Karyawan');
        $response->assertSee('Profitabilitas (30%), Aktivitas (25%), Produktivitas (20%), Likuiditas (15%), Solvabilitas (10%)');
    }

    public function test_all_19_financial_ratios_are_present(): void
    {
        $codes = [
            'GPM', 'NPM', 'ROA', 'ROE',
            'ITO', 'ATO', 'ARTO', 'DIO', 'DSO', 'DPO',
            'PROD_EMP', 'PROD_HR', 'PROD_LABOR_COST', 'CPR',
            'CR', 'CASH_R', 'QR',
            'DER', 'DAR'
        ];

        $component = Livewire::actingAs($this->user)->test(FinancialRatios::class);

        foreach ($codes as $code) {
            $component->assertSee($code);
        }

        $component->assertSee('98.34%');
        $component->assertSee('Aktivitas');
        $component->assertSee('93.4%');
        $component->assertSee('Di Bawah Target');
    }

    public function test_filter_under_100_percent_shows_only_off_target_ratios(): void
    {
        Livewire::actingAs($this->user)
            ->test(FinancialRatios::class)
            ->call('toggleFilterUnder100')
            ->assertSet('filterUnder100', true)
            ->assertSee('DPO')
            ->assertDontSee('GPM')
            ->assertDontSee('NPM');
    }

    public function test_search_filter_works_properly(): void
    {
        Livewire::actingAs($this->user)
            ->test(FinancialRatios::class)
            ->set('search', 'Inventory')
            ->assertSee('ITO')
            ->assertSee('DIO')
            ->assertDontSee('NPM');
    }

    public function test_modals_open_and_close_cleanly(): void
    {
        Livewire::actingAs($this->user)
            ->test(FinancialRatios::class)
            ->call('openDetailModal', 'GPM')
            ->assertSet('showDetailModal', true)
            ->assertSee('Detail Pembentuk: Gross Profit Margin')
            ->call('closeDetailModal')
            ->assertSet('showDetailModal', false)
            ->call('openFlexibilityModal', 'ITO')
            ->assertSet('showFlexibilityModal', true)
            ->assertSee('Kalibrasi Fleksibilitas')
            ->call('closeFlexibilityModal')
            ->assertSet('showFlexibilityModal', false)
            ->call('openCurriculumModal')
            ->assertSet('showCurriculumModal', true)
            ->assertSee('Kurikulum')
            ->call('closeCurriculumModal')
            ->assertSet('showCurriculumModal', false);
    }
}
