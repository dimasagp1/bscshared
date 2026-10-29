<div class="space-y-6">
    <!-- Header Banner -->
    <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-gray-100 text-gray-800 flex items-center justify-center text-xl shadow-xs">
                <i class="fas fa-gear"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded bg-purple-100 text-purple-700">SUPER ADMIN</span>
                    <h2 class="text-base font-bold text-gray-900">Pengaturan Sistem &amp; Konfigurasi Global</h2>
                </div>
                <p class="text-xs text-gray-500 mt-0.5">
                    Identitas aplikasi, manajemen kunci API Gateway, dan telemetri runtime lingkungan produksi.
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('manage-users') }}" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-700 transition-colors">
                <i class="fas fa-users-gear mr-1.5 text-gray-400"></i> Kelola Pengguna
            </a>
        </div>
    </div>

    <!-- FLASH MESSAGES -->
    @if (session()->has('message'))
        <div class="rounded-xl bg-green-50 border border-green-200 p-3.5 text-xs text-green-800 flex items-center gap-2">
            <i class="fas fa-check-circle text-green-600"></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="rounded-xl bg-red-50 border border-red-200 p-3.5 text-xs text-red-800 flex items-center gap-2">
            <i class="fas fa-exclamation-triangle text-red-600"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- MAIN TABS CONTAINER -->
    <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-xs">
        <!-- Tabs Header -->
        <div class="flex items-center gap-2 p-3 bg-gray-50/60 border-b border-gray-100 text-xs font-semibold">
            <button type="button" wire:click="switchTab('identity')" 
                    class="px-4 py-2 rounded-xl transition-all flex items-center gap-2 {{ $activeTab==='identity' ? 'bg-[#DCFCE7] text-[#166534] shadow-xs' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                <i class="fas fa-id-card text-xs"></i>
                <span>Identitas Aplikasi</span>
            </button>
            <button type="button" wire:click="switchTab('api')" 
                    class="px-4 py-2 rounded-xl transition-all flex items-center gap-2 {{ $activeTab==='api' ? 'bg-[#DCFCE7] text-[#166534] shadow-xs' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                <i class="fas fa-key text-xs"></i>
                <span>Kunci API Gateway</span>
            </button>
            <button type="button" wire:click="switchTab('system')" 
                    class="px-4 py-2 rounded-xl transition-all flex items-center gap-2 {{ $activeTab==='system' ? 'bg-[#DCFCE7] text-[#166534] shadow-xs' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                <i class="fas fa-server text-xs"></i>
                <span>Informasi Sistem</span>
            </button>
        </div>

        <div class="p-6">
            @if($activeTab === 'identity')
                <!-- TAB 1: IDENTITAS APLIKASI -->
                <div class="space-y-6">
                    <!-- Brand Preview Card -->
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-200 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-[#DCFCE7] text-[#166534] flex items-center justify-center text-xl shadow-xs">
                                <i class="fas fa-cubes"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-extrabold text-gray-900">
                                    {{ $app_name }} <span class="text-xs font-normal text-gray-500 font-mono">({{ $app_year }})</span>
                                </h3>
                                <p class="text-xs text-gray-500">{{ $app_tagline }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 text-xs font-medium text-gray-600">
                            <span>Warna Aksen:</span>
                            <span class="w-6 h-6 rounded-lg border border-gray-300 inline-block shadow-2xs" style="background-color: {{ $app_primary_color }}"></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Nama Aplikasi *</label>
                            <input type="text" wire:model="app_name" class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-green-600">
                            @error('app_name') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Tagline Organisasi</label>
                            <input type="text" wire:model="app_tagline" class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-green-600">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Tahun Anggaran *</label>
                            <input type="text" wire:model="app_year" class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-green-600 font-mono">
                            @error('app_year') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Warna Brand Primary *</label>
                            <input type="color" wire:model.live="app_primary_color" class="w-full h-10 p-1 rounded-xl border border-gray-200 cursor-pointer">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-2 text-xs">
                        <button type="button" wire:click="resetIdentity" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 font-semibold text-gray-700">
                            <i class="fas fa-undo mr-1"></i> Reset Default
                        </button>
                        <button type="button" wire:click="saveIdentity" class="px-4 py-2 rounded-xl bg-[#166534] hover:bg-[#14532D] font-bold text-white shadow-xs">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>

            @elseif($activeTab === 'api')
                <!-- TAB 2: KUNCI API GATEWAY -->
                <div class="space-y-6">
                    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-xs text-amber-800 flex items-start gap-2.5">
                        <i class="fas fa-shield-halved text-amber-600 text-sm mt-0.5"></i>
                        <span>Kunci API Gateway bersifat rahasia dan digunakan untuk mengotentikasi pertukaran data otomatis dari sistem Hop 1–Hop 3.</span>
                    </div>

                    <!-- Generate Key Form -->
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-200">
                        <h4 class="font-bold text-xs text-gray-900 mb-2">Buat Kunci API Baru</h4>
                        <div class="flex items-center gap-2 max-w-md">
                            <input type="text" wire:model="newKeyName" placeholder="Nama kunci, mis: Gateway ERP SSOT" 
                                   class="w-full px-3 py-2 rounded-xl border border-gray-200 text-xs focus:outline-none focus:ring-1 focus:ring-green-600 bg-white">
                            <button type="button" wire:click="generateApiKey" class="px-4 py-2 rounded-xl bg-[#166534] hover:bg-[#14532D] text-white text-xs font-bold shrink-0">
                                <i class="fas fa-key mr-1"></i> Generate
                            </button>
                        </div>
                        <p class="text-[11px] text-gray-400 mt-1.5">Kunci lama akan dinonaktifkan secara otomatis (hanya 1 kunci aktif).</p>
                    </div>

                    <!-- Table of API Keys -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="bg-gray-50/70 border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                                    <th class="py-3 px-4">#</th>
                                    <th class="py-3 px-4">Nama Kunci</th>
                                    <th class="py-3 px-4">Token Key</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4">Dibuat</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($apiKeys as $k)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="py-3 px-4 font-mono text-gray-400">{{ $loop->iteration }}</td>
                                        <td class="py-3 px-4 font-bold text-gray-900">{{ $k->name }}</td>
                                        <td class="py-3 px-4 font-mono">
                                            @if($showKeyId === $k->id)
                                                <code>{{ $k->key }}</code>
                                                <button type="button" wire:click="revealKey({{ $k->id }})" class="ml-1 text-gray-400 hover:text-gray-600"><i class="fas fa-eye-slash"></i></button>
                                            @else
                                                <code>bsc_live_****{{ substr($k->key, -4) }}</code>
                                                <button type="button" wire:click="revealKey({{ $k->id }})" class="ml-1 text-[#166534] hover:underline text-[11px]">Lihat</button>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            @if($k->is_active)
                                                <span class="px-2 py-0.5 rounded-full bg-[#DCFCE7] text-[#166534] text-[10px] font-bold">Aktif</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-[10px] font-bold">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-gray-500 text-[11px]">{{ $k->created_at->format('d M Y H:i') }}</td>
                                        <td class="py-3 px-4 text-center">
                                            <div class="inline-flex items-center gap-1">
                                                <button type="button" wire:click="toggleKey({{ $k->id }})" class="p-1.5 rounded-lg text-gray-500 hover:text-amber-600 transition-colors" title="Toggle On/Off">
                                                    <i class="fas fa-power-off text-xs"></i>
                                                </button>
                                                <button type="button" wire:click="deleteKey({{ $k->id }})" class="p-1.5 rounded-lg text-gray-500 hover:text-red-600 transition-colors" title="Hapus">
                                                    <i class="fas fa-trash text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-gray-400 py-6 italic">Belum ada kunci API terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            @elseif($activeTab === 'system')
                <!-- TAB 3: INFORMASI SISTEM -->
                <div class="space-y-4">
                    <div class="overflow-x-auto rounded-2xl border border-gray-200">
                        <table class="w-full text-left text-xs">
                            <tbody class="divide-y divide-gray-100">
                                @foreach($systemInfo as $label => $val)
                                    <tr class="hover:bg-gray-50/50">
                                        <td class="py-3 px-4 font-bold text-gray-700 w-1/3">{{ $label }}</td>
                                        <td class="py-3 px-4 font-mono text-gray-900">
                                            @if($label === 'App Env')
                                                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold">{{ $val }}</span>
                                            @elseif($label === 'App Debug')
                                                <span class="px-2 py-0.5 rounded-full {{ $val === 'true' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }} text-[10px] font-bold">{{ $val }}</span>
                                            @else
                                                {{ $val }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="text-[11px] text-gray-400 italic">
                        Informasi sistem di atas bersifat read-only untuk audit and troubleshooting kepatuhan SLA.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
