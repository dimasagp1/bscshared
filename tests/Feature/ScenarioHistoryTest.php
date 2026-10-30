<?php

namespace Tests\Feature;

use App\Livewire\ScenarioHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ScenarioHistoryTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $permissions = [
            'view skenario',
            'manage skenario',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->syncPermissions($permissions);

        $this->user = User::factory()->create(['is_active' => true]);
        $this->user->assignRole('Super Admin');
    }

    public function test_scenario_history_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->user)->get(route('skenario'));
        $response->assertStatus(200);
        $response->assertSee('Simulation Session');
        $response->assertSee('Undo/Redo History');
        $response->assertSee('Langkah: 0/0');
        $response->assertSee('DAFTAR SKENARIO TERSIMPAN');
        $response->assertSee('NAIK TARGET REVENUE');
    }

    public function test_save_new_scenario(): void
    {
        Livewire::actingAs($this->user)
            ->test(ScenarioHistory::class)
            ->set('scenarioName', 'Kenaikan Target Revenue 10%')
            ->call('saveScenario')
            ->assertSee('KENAIKAN TARGET REVENUE 10%')
            ->assertSet('scenarioName', '');
    }

    public function test_load_and_delete_scenario(): void
    {
        $component = Livewire::actingAs($this->user)->test(ScenarioHistory::class);
        $scenarios = $component->get('savedScenarios');
        $firstId = $scenarios[0]['id'];

        $component->call('loadScenario', $firstId)
            ->assertSee('berhasil dimuat')
            ->call('deleteScenario', $firstId)
            ->assertSee('berhasil dihapus');
    }

    public function test_export_and_import_scenario_modals(): void
    {
        Livewire::actingAs($this->user)
            ->test(ScenarioHistory::class)
            ->call('openExportModal')
            ->assertSet('showExportModal', true)
            ->assertSee('Ekspor Skenario JSON')
            ->call('closeExportModal')
            ->assertSet('showExportModal', false)
            ->call('openImportModal')
            ->assertSet('showImportModal', true)
            ->assertSee('Impor Skenario JSON')
            ->set('importJsonContent', json_encode(['name' => 'Skenario Impor Baru', 'steps_count' => 2]))
            ->call('importJson')
            ->assertSet('showImportModal', false)
            ->assertSee('SKENARIO IMPOR BARU');
    }
}
