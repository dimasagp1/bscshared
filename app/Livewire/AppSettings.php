<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Url;
use App\Models\AppSetting;
use App\Models\ApiKey;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class AppSettings extends Component
{
    use WithFileUploads;

    #[Url]
    public $activeTab = 'identity'; // identity, api, system

    // Identity fields
    public $app_name = '';
    public $app_tagline = '';
    public $app_year = '';
    public $app_primary_color = '#17a2b8';
    public $logoUpload;
    public $faviconUpload;

    // API Key fields
    public $showKeyId = null; // for reveal
    public $newKeyName = 'Gateway Key';

    public function mount()
    {
        $this->loadIdentity();
    }

    private function loadIdentity()
    {
        $this->app_name = AppSetting::getValue('app_name', 'Super Apps BSC');
        $this->app_tagline = AppSetting::getValue('app_tagline', 'PT Herbatech Innopharma');
        $this->app_year = AppSetting::getValue('app_year', '2026');
        $this->app_primary_color = AppSetting::getValue('app_primary_color', '#17a2b8');
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function saveIdentity()
    {
        $this->validate([
            'app_name' => 'required|string|min:3|max:100',
            'app_tagline' => 'nullable|string|max:255',
            'app_year' => 'required|digits:4',
            'app_primary_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'logoUpload' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'faviconUpload' => 'nullable|image|mimes:png,jpg,jpeg,ico,svg|max:1024',
        ]);

        AppSetting::setValue('app_name', $this->app_name);
        AppSetting::setValue('app_tagline', $this->app_tagline);
        AppSetting::setValue('app_year', $this->app_year);
        AppSetting::setValue('app_primary_color', $this->app_primary_color);

        if ($this->logoUpload) {
            $path = $this->logoUpload->store('branding', 'public');
            AppSetting::setValue('app_logo', $path);
        }
        if ($this->faviconUpload) {
            $path = $this->faviconUpload->store('branding', 'public');
            AppSetting::setValue('app_favicon', $path);
        }

        $this->logoUpload = null;
        $this->faviconUpload = null;

        session()->flash('message', 'Identitas aplikasi berhasil diperbarui!');
    }

    public function resetIdentity()
    {
        AppSetting::setValue('app_name', 'Super Apps BSC');
        AppSetting::setValue('app_tagline', 'PT Herbatech Innopharma');
        AppSetting::setValue('app_year', '2026');
        AppSetting::setValue('app_primary_color', '#17a2b8');
        $this->loadIdentity();
        session()->flash('message', 'Identitas direset ke default!');
    }

    public function generateApiKey()
    {
        $this->validate(['newKeyName' => 'required|string|min:3|max:100']);
        $raw = 'bsc_live_' . Str::random(32);
        ApiKey::create([
            'name' => $this->newKeyName,
            'key' => $raw,
            'is_active' => true,
        ]);

        // Deactivate old keys (keep history but only one active)
        ApiKey::where('key', '!=', $raw)->update(['is_active' => false]);

        $this->newKeyName = 'Gateway Key';
        session()->flash('message', 'Kunci API baru berhasil digenerate!');
    }

    public function toggleKey($id)
    {
        $k = ApiKey::findOrFail($id);
        $k->update(['is_active' => !$k->is_active]);
        session()->flash('message', 'Status kunci ' . $k->name . ' diubah!');
    }

    public function deleteKey($id)
    {
        $k = ApiKey::findOrFail($id);
        // Guard: at least one active key must remain
        if ($k->is_active && ApiKey::where('is_active', true)->count() <= 1) {
            session()->flash('error', 'Tidak dapat menghapus kunci aktif terakhir!');
            return;
        }
        $k->delete();
        session()->flash('message', 'Kunci ' . $k->name . ' dihapus!');
    }

    public function revealKey($id)
    {
        $this->showKeyId = $this->showKeyId === $id ? null : $id;
    }

    public function render()
    {
        $apiKeys = ApiKey::latest()->get();
        $logoPath = AppSetting::getValue('app_logo', '');
        $faviconPath = AppSetting::getValue('app_favicon', '');

        // System info
        $systemInfo = [
            'PHP Version' => PHP_VERSION,
            'Laravel Version' => app()->version(),
            'App Env' => config('app.env'),
            'App Debug' => config('app.debug') ? 'true' : 'false',
            'App URL' => config('app.url'),
            'Database Driver' => config('database.default') . ' (' . DB::connection()->getDriverName() . ')',
            'Database Name' => DB::connection()->getDatabaseName(),
            'Cache Store' => config('cache.default'),
            'Queue Connection' => config('queue.default'),
            'Session Driver' => config('session.driver') . ' (' . config('session.lifetime') . ' menit)',
            'Timezone' => config('app.timezone'),
            'Storage Link' => is_link(public_path('storage')) ? 'OK (linked)' : 'Missing (run storage:link)',
        ];

        return view('livewire.app-settings', [
            'apiKeys' => $apiKeys,
            'logoPath' => $logoPath,
            'faviconPath' => $faviconPath,
            'systemInfo' => $systemInfo,
        ])->layout('layouts.app', ['title' => 'Setting Sistem']);
    }
}
