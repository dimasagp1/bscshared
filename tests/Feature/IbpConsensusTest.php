<?php

namespace Tests\Feature;

use App\Livewire\IbpConsensus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class IbpConsensusTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $permissions = [
            'view ibp',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->syncPermissions($permissions);

        $this->user = User::factory()->create(['is_active' => true]);
        $this->user->assignRole('Super Admin');
    }

    public function test_ibp_consensus_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->user)->get(route('ibp'));
        $response->assertStatus(200);
        $response->assertSee('Simulasi IBP');
        $response->assertSee('PERENCANAAN');
        $response->assertSee('Product Review');
        $response->assertSee('3 NEW SKU PIPELINE');
        $response->assertSee('Herbalmmune Forte 60s');
        $response->assertSee('Curcuma Hepato Guard');
        $response->assertSee('Bio-Diabeta Extract');
    }

    public function test_stepper_navigation_switches_steps_cleanly(): void
    {
        Livewire::actingAs($this->user)
            ->test(IbpConsensus::class)
            ->assertSee('1 - PRODUCT REVIEW')
            ->call('setStep', 2)
            ->assertSet('currentStep', 2)
            ->assertSee('2 - DEMAND REVIEW')
            ->call('setStep', 3)
            ->assertSet('currentStep', 3)
            ->assertSee('3 - SUPPLY REVIEW')
            ->call('setStep', 4)
            ->assertSet('currentStep', 4)
            ->assertSee('4 - REKONSILIASI FINANSIAL')
            ->call('setStep', 5)
            ->assertSet('currentStep', 5)
            ->assertSee('5 - MANAGEMENT BUSINESS REVIEW');
    }

    public function test_full_view_toggle_shows_all_steps(): void
    {
        Livewire::actingAs($this->user)
            ->test(IbpConsensus::class)
            ->call('toggleShowAllSteps')
            ->assertSet('showAllSteps', true)
            ->assertSee('1 - PRODUCT REVIEW')
            ->assertSee('2 - DEMAND REVIEW')
            ->assertSee('3 - SUPPLY REVIEW')
            ->assertSee('4 - REKONSILIASI FINANSIAL')
            ->assertSee('5 - MANAGEMENT BUSINESS REVIEW');
    }

    public function test_transmit_consensus_to_bsc(): void
    {
        Livewire::actingAs($this->user)
            ->test(IbpConsensus::class)
            ->assertSee('Simulasi — belum dikirim ke BSC')
            ->call('transmitToBsc')
            ->assertSet('isTransmitted', true)
            ->assertSee('Terkirim ke BSC')
            ->call('resetTransmission')
            ->assertSet('isTransmitted', false)
            ->assertSee('Simulasi — belum dikirim ke BSC');
    }
}

