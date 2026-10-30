<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DarkModeViewsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $permissions = [
            'view dashboard', 'view ratios', 'view objectives', 'view wiring',
            'view dampak', 'view coa', 'view actionplans', 'view ibp',
            'view sensitivity', 'view skenario', 'view dokumentasi',
            'view gateway', 'view integration', 'view staging',
            'manage users', 'can_manage_users', 'manage settings', 'view systeminfo', 'manage apikey'
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->syncPermissions($permissions);
    }

    public function test_authenticated_page_loads_with_dark_mode_infrastructure(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $user->assignRole('Super Admin');

        $routes = [
            route('dashboard'),
            route('financial-ratios'),
            route('department-objectives'),
            route('bsc-wiring'),
            route('dampak'),
            route('coa'),
            route('sensitivity'),
            route('skenario'),
            route('dokumentasi'),
            route('action-plans'),
            route('ibp'),
            route('system-integration'),
            route('manage-users'),
            route('staging-logs'),
            route('settings'),
        ];

        foreach ($routes as $url) {
            $response = $this->actingAs($user)->get($url);
            $response->assertStatus(200);
            $response->assertSee('bsc_dark_mode', false);
            $response->assertSee('toggleDark()', false);
            $response->assertSee('dark:bg-[#121214]', false);
            $response->assertSee('dark:bg-[#18181A]', false);
        }
    }

    public function test_all_blade_views_compile_without_errors(): void
    {
        $views = [
            'layouts.app',
            'layouts.guest',
            'livewire.periodic-monitor',
            'livewire.bsc-dashboard',
            'livewire.department-objectives',
            'livewire.financial-ratios',
            'livewire.bsc-wiring',
            'livewire.sensitivity-analysis',
            'livewire.method-documentation',
            'livewire.action-plans',
            'livewire.system-integration',
            'livewire.manage-users',
            'livewire.staging-logs',
            'livewire.app-settings',
            'livewire.coming-soon',
            'livewire.auth.login',
        ];

        foreach ($views as $view) {
            $compiled = app('blade.compiler')->compileString(
                file_get_contents(resource_path('views/' . str_replace('.', '/', $view) . '.blade.php'))
            );
            $this->assertNotEmpty($compiled, "Failed compiling view: {$view}");
        }
    }
}
