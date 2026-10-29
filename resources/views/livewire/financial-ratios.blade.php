<div class="space-y-6">
    <!-- Header Banner & Period Controls -->
    <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-[#DCFCE7] text-[#166534] flex items-center justify-center text-xl shadow-xs">
                <i class="fas fa-arrow-trend-up"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded bg-gray-100 text-gray-700">LEVEL 2</span>
                    <h2 class="text-base font-bold text-gray-900">Rasio Keuangan Perusahaan</h2>
                </div>
                <p class="text-xs text-gray-500 mt-0.5">
                    Daftar 7 Rasio Keuangan Utama (5 Kategori) sebagai jembatan transmisi Apex Revenue ke Sasaran Mutu.
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <!-- Period Selector -->
            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-700 bg-gray-50/70">
                <i class="far fa-calendar text-gray-400 text-xs"></i>
                <span>Periode:</span>
                <select wire:model.live="selectedPeriod" class="bg-transparent font-bold text-gray-900 focus:outline-none cursor-pointer">
                    @foreach($periods as $p)
                        <option value="{{ $p }}">{{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Lock Badge -->
            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold {{ $isClosed ? 'bg-gray-100 text-gray-600 border border-gray-200' : 'bg-[#DCFCE7] text-[#166534] border border-green-200' }}">
                <i class="fas {{ $isClosed ? 'fa-lock' : 'fa-lock-open' }} text-[11px]"></i>
                <span>{{ $isClosed ? 'CLOSED (Terkunci)' : 'OPEN (Aktif)' }}</span>
            </div>
        </div>
    </div>

    <!-- FLASH MESSAGES -->
    @if(session()->has('message'))
        <div class="rounded-xl bg-green-50 border border-green-200 p-3.5 text-xs text-green-800 flex items-center gap-2">
            <i class="fas fa-check-circle text-green-600"></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="rounded-xl bg-red-50 border border-red-200 p-3.5 text-xs text-red-800 flex items-center gap-2">
            <i class="fas fa-exclamation-triangle text-red-600"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($isClosed)
        <div class="rounded-xl bg-amber-50 border border-amber-200 p-3.5 text-xs text-amber-800 flex items-center gap-2">
            <i class="fas fa-lock text-amber-600"></i>
            <span><strong>Periode {{ $selectedPeriod }} DITUTUP (CLOSED):</strong> Nilai rasio keuangan terkunci untuk pengubahan langsung.</span>
        </div>
    @endif

    <!-- MAIN TABLE CARD -->
    <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-xs">
        <!-- Table Filter Bar -->
        <div class="p-5 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                <i class="fas fa-list text-gray-400"></i>
                <span>Matriks 7 Rasio Finansial</span>
            </h3>

            <div class="flex items-center gap-2.5">
                <!-- Filter Kategori -->
                <select wire:model.live="selectedCategory" class="px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>

                <!-- Filter Status -->
                <select wire:model.live="selectedStatus" class="px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="bermasalah">⚠️ Hanya Bermasalah</option>
                    <option value="Tercapai">Tercapai (&ge;100%)</option>
                    <option value="Waspada">Waspada (80-99%)</option>
                    <option value="Di Bawah Target">Di Bawah Target (&lt;80%)</option>
                </select>
            </div>
        </div>

        <!-- Table View -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Nama Rasio</th>
                        <th class="py-3 px-4 text-center">Target</th>
                        <th class="py-3 px-4 text-center">Realisasi (Actual)</th>
                        <th class="py-3 px-4 text-center">Capaian (%)</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($ratios as $r)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-3.5 px-4 font-medium text-gray-600">
                                <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200/60 font-semibold text-[11px]">
                                    {{ $r->category }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-gray-900">
                                {{ $r->ratio_name }}
                            </td>
                            
                            @if($editingRatioId === $r->id)
                                <td class="py-3.5 px-4 text-center">
                                    <input type="number" step="0.01" wire:model="editTarget" class="w-24 px-2 py-1 rounded-lg border border-gray-300 text-center text-xs font-mono font-bold focus:ring-1 focus:ring-green-500">
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <input type="number" step="0.01" wire:model="editActual" class="w-24 px-2 py-1 rounded-lg border border-gray-300 text-center text-xs font-mono font-bold focus:ring-1 focus:ring-green-500">
                                </td>
                                <td class="py-3.5 px-4 text-center text-gray-400 italic">
                                    Kalkulasi...
                                </td>
                                <td class="py-3.5 px-4 text-center text-gray-400">-</td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="inline-flex items-center gap-1">
                                        <button wire:click="updateRatio" class="px-2 py-1 rounded-lg bg-[#166534] hover:bg-[#14532D] text-white text-[11px] font-bold" title="Simpan">
                                            <i class="fas fa-save"></i>
                                        </button>
                                        <button wire:click="cancelEdit" class="px-2 py-1 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 text-[11px]" title="Batal">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            @else
                                <td class="py-3.5 px-4 text-center font-mono font-semibold text-gray-700">
                                    {{ number_format($r->target, 2) }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-mono font-bold text-gray-900">
                                    {{ number_format($r->actual, 2) }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-mono font-bold text-[#166534]">
                                    {{ number_format($r->achievement_pct, 1) }}%
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    @if($r->status === 'Tercapai')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#DCFCE7] text-[#166534] border border-green-200 font-bold text-[11px]">
                                            <i class="fas fa-check-circle text-[10px]"></i> Tercapai
                                        </span>
                                    @elseif($r->status === 'Waspada')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#FEF9C3] text-[#854D0E] border border-yellow-200 font-bold text-[11px]">
                                            <i class="fas fa-exclamation-circle text-[10px]"></i> Waspada
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#FEE2E2] text-[#991B1B] border border-red-200 font-bold text-[11px]">
                                            <i class="fas fa-times-circle text-[10px]"></i> Off-Target
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <button wire:click="editRatio({{ $r->id }})" 
                                            class="px-2.5 py-1 rounded-lg text-[11px] font-semibold transition-all {{ $isClosed ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-gray-100 hover:bg-[#DCFCE7] text-gray-700 hover:text-[#166534]' }}"
                                            {{ $isClosed ? 'disabled' : '' }} 
                                            title="{{ $isClosed ? 'Terkunci' : 'Edit Rasio' }}">
                                        <i class="fas {{ $isClosed ? 'fa-lock' : 'fa-pen-to-square' }} mr-1"></i> Edit
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-400 py-8 italic">
                                Tidak ada data rasio keuangan untuk kategori ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
