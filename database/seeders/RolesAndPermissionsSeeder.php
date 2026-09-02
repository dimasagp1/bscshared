<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\AppSetting;
use App\Models\ApiKey;
use Illuminate\Support\Str;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions per PRD §4 can_* per role
        $permissions = [
            'manage users',
            'manage settings',
            'manage apikey',
            'view systeminfo',
            'view dashboard',
            'manage ratios',
            'manage objectives',
            'manage actionplans',
            'view wiring',
            'view integration',
            'view staging',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // 6 Roles PRD §4
        $roles = [
            'Super Admin' => $permissions, // 13/13
            'Admin FAT' => ['view dashboard','manage ratios','manage objectives','manage actionplans','view wiring','view integration','view staging','manage apikey'],
            'Admin HRIS' => ['view dashboard','manage objectives','manage actionplans','view wiring','view staging'],
            'Kepala Departemen' => ['view dashboard','manage objectives','manage actionplans','view wiring'],
            'Operator' => ['view dashboard','manage objectives','manage actionplans'],
            'Viewer' => ['view dashboard','view wiring','view staging'],
        ];

        foreach ($roles as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($perms);
        }

        // Ensure Super Admin user exists
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@herbatech.co.id'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'is_active' => true,
            ]
        );
        if (!$superAdmin->hasRole('Super Admin')) {
            $superAdmin->assignRole('Super Admin');
        }

        // Keep test@example.com as Viewer for testing
        $testUser = User::where('email', 'test@example.com')->first();
        if ($testUser && !$testUser->hasAnyRole(Role::all()->pluck('name')->toArray())) {
            $testUser->assignRole('Viewer');
        }

        // Default App Settings
        $defaults = [
            'app_name' => 'Super Apps BSC',
            'app_tagline' => 'PT Herbatech Innopharma',
            'app_year' => '2026',
            'app_primary_color' => '#17a2b8',
            'app_logo' => '',
            'app_favicon' => '',
        ];
        foreach ($defaults as $k => $v) {
            AppSetting::firstOrCreate(['key' => $k], ['value' => $v]);
        }

        // Default API Key if none
        if (ApiKey::count() === 0) {
            ApiKey::create([
                'name' => 'Gateway Default',
                'key' => 'bsc_live_' . Str::random(24),
                'is_active' => true,
                'created_by' => $superAdmin->id,
            ]);
        }
    }
}
