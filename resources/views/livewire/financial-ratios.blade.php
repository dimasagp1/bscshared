<div class="space-y-6">
    <!-- Top Header Banner & Filter Controls -->
    <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 sm:p-6 shadow-xs flex flex-wrap items-center justify-between gap-4 transition-colors duration-200">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-[#DCFCE7] dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 border border-green-200/60 dark:border-emerald-800/50 flex items-center justify-center text-xl shadow-xs shrink-0">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <div class="flex items-center gap-2.5 flex-wrap">
                    <h2 class="text-base font-bold text-gray-900 dark:text-white">5 Kelompok Rasio Keuangan</h2>
                    <button wire:click="openCurriculumModal" type="button" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-gray-100 hover:bg-gray-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-300 text-[11px] font-semibold transition-colors cursor-pointer">
                        <i class="fas fa-book-open text-gray-500 dark:text-slate-400 text-[10px]"></i>
                        <span>Kurikulum / Panduan</span>
                    </button>
                </div>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                    Profitabilitas (30%), Aktivitas (25%), Produktivitas (20%), Likuiditas (15%), Solvabilitas (10%) — Total Bobot 100%
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
            <!-- Period Selector -->
            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-gray-200 dark:border-slate-700 text-xs font-semibold text-gray-700 dark:text-slate-300 bg-gray-50/70 dark:bg-slate-800/60">
                <i class="far fa-calendar text-gray-400 dark:text-slate-500 text-xs"></i>
                <span>Periode:</span>
                <select wire:model.live="selectedPeriod" class="bg-transparent font-bold text-gray-900 dark:text-slate-100 focus:outline-none cursor-pointer">
                    @foreach($periods as $p)
                        <option value="{{ $p }}" class="dark:bg-[#0F172A] dark:text-slate-100">{{ $p }} (OPEN)</option>
                    @endforeach
                </select>
            </div>

            <!-- Search Input -->
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-slate-500 text-xs pointer-events-none"></i>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kode/nama rasio..." 
                       class="pl-8 pr-3 py-1.5 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 w-44 sm:w-56 transition-all">
                @if($search)
                    <button wire:click="$set('search', '')" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-slate-300 text-xs">
                        <i class="fas fa-times"></i>
                    </button>
                @endif
            </div>

            <!-- Filter Rasio <100% Toggle -->
            <button wire:click="toggleFilterUnder100" type="button" 
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border text-xs font-semibold transition-all shadow-xs {{ $filterUnder100 ? 'bg-amber-500 border-amber-600 text-white' : 'border-gray-200 dark:border-slate-700 text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-900 hover:bg-gray-50 dark:hover:bg-slate-800' }}">
                <i class="fas fa-filter text-[10px]"></i>
                <span>Filter Rasio &lt;100%</span>
            </button>

            <!-- Sync Finance Button -->
            <button wire:click="syncFinance" type="button" wire:loading.attr="disabled" 
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-xs font-bold shadow-xs transition-colors cursor-pointer">
                <i class="fas fa-bolt text-[11px]" wire:loading.remove wire:target="syncFinance"></i>
                <i class="fas fa-spinner fa-spin text-[11px]" wire:loading wire:target="syncFinance"></i>
                <span>Sync Finance</span>
            </button>
        </div>
    </div>

    <!-- FLASH MESSAGES -->
    @if(session()->has('message'))
        <div class="rounded-2xl bg-green-50 dark:bg-emerald-950/40 border border-green-200 dark:border-emerald-800/50 p-4 text-xs text-green-800 dark:text-emerald-300 flex items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-check-circle text-green-600 dark:text-emerald-400 text-sm"></i>
                <span class="font-medium">{{ session('message') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-600 dark:text-emerald-400 hover:text-green-800 text-xs">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="rounded-2xl bg-red-50 dark:bg-rose-950/40 border border-red-200 dark:border-rose-800/50 p-4 text-xs text-red-800 dark:text-rose-300 flex items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-exclamation-triangle text-red-600 dark:text-rose-400 text-sm"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-600 dark:text-rose-400 hover:text-red-800 text-xs">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Overall Score Banner (Hero Card) -->
    <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 sm:p-6 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4 transition-colors duration-200">
        <div>
            <span class="text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider block">
                Skor Keseluruhan ({{ $selectedPeriod }})
            </span>
            <div class="flex items-center gap-3 mt-1.5 flex-wrap">
                <span class="font-mono font-black text-3xl sm:text-4xl text-amber-500 dark:text-amber-400 tracking-tight">
                    {{ number_format($overallScore, 2) }}%
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#DCFCE7] dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 border border-green-200 dark:border-emerald-800/50 text-xs font-bold shadow-xs">
                    <i class="fas fa-bolt text-[10px]"></i>
                    <span>HRIS Online : 20 Karyawan</span>
                </span>
            </div>
        </div>
        <div class="md:text-right max-w-lg">
            <p class="text-xs text-gray-500 dark:text-slate-400 leading-relaxed">
                Dihitung otomatis dari {{ $totalRatiosCount }} Rasio Keuangan berbobot 100 poin. Kelompok &lt;100% dapat ditelusuri ke KPI pendorong di Objective Departemen.
            </p>
        </div>
    </div>

    <!-- 5 Category Circular Gauge / Donut Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        @foreach($categoriesSummary as $catName => $summary)
            @php
                $isTercapai = $summary['status'] === 'Tercapai';
                $pct = min(100.0, max(0.0, $summary['achievement_pct']));
                // SVG Circle Calculation: radius 32, circumference 201.06
                $circumference = 201.06;
                $dashoffset = $circumference * (1 - ($pct / 100.0));
                $ringColor = $isTercapai ? '#166534' : '#F59E0B';
            @endphp
            <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 shadow-xs flex flex-col justify-between transition-colors duration-200">
                <!-- Card Header -->
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <h4 class="font-bold text-sm text-gray-900 dark:text-white">{{ $summary['name'] }}</h4>
                        <span class="text-[11px] font-mono text-gray-400 dark:text-slate-500 block mt-0.5">
                            {{ $summary['subtext'] }}
                        </span>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border shrink-0 {{ $isTercapai ? 'bg-[#DCFCE7] dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 border-green-200 dark:border-emerald-800/50' : 'bg-[#FEF9C3] dark:bg-amber-950/60 text-[#854D0E] dark:text-amber-300 border-yellow-200 dark:border-amber-800/50' }}">
                        {{ $summary['status'] }}
                    </span>
                </div>

                <!-- Donut Chart Visualization -->
                <div class="flex flex-col items-center justify-center my-4">
                    <div class="relative w-24 h-24 flex items-center justify-center">
                        <svg class="w-24 h-24 -rotate-90 transform" viewBox="0 0 88 88">
                            <!-- Background Circle -->
                            <circle cx="44" cy="44" r="32" 
                                    class="text-gray-100 dark:text-slate-800" 
                                    stroke="currentColor" 
                                    stroke-width="7" 
                                    fill="transparent" />
                            <!-- Active Progress Ring -->
                            <circle cx="44" cy="44" r="32" 
                                    stroke="{{ $ringColor }}" 
                                    stroke-width="7" 
                                    stroke-linecap="round" 
                                    stroke-dasharray="{{ $circumference }}" 
                                    stroke-dashoffset="{{ $dashoffset }}" 
                                    fill="transparent" 
                                    class="transition-all duration-700 ease-out" />
                        </svg>
                        <!-- Centered Percentage Text -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="font-mono font-black text-sm text-gray-900 dark:text-white">
                                {{ number_format($summary['achievement_pct'], 1) }}%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Footer Weight -->
                <div class="text-center text-xs font-semibold text-gray-600 dark:text-slate-400 pt-2 border-t border-gray-100 dark:border-slate-800/80">
                    Bobot {{ $summary['weight'] }}%
                </div>
            </div>
        @endforeach
    </div>

    <!-- 5 Detailed Category Tables / Accordions -->
    <div class="space-y-6">
        @php
            $catIcons = [
                'Profitabilitas' => 'fa-coins',
                'Aktivitas' => 'fa-cube',
                'Produktivitas' => 'fa-users-gear',
                'Likuiditas' => 'fa-faucet-drip',
                'Solvabilitas' => 'fa-shield-halved',
            ];
        @endphp

        @foreach($groupedRatios as $catName => $ratios)
            @php
                $summary = $categoriesSummary[$catName] ?? [
                    'weight' => 20,
                    'count' => count($ratios),
                    'total_pts' => 20,
                    'status' => 'Tercapai',
                ];
                $isCatTercapai = $summary['status'] === 'Tercapai';
                $isCollapsed = in_array($catName, $collapsedCategories);
            @endphp

            <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 overflow-hidden shadow-xs transition-colors duration-200">
                <!-- Table Section Header -->
                <div class="p-5 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-slate-800 text-[#166534] dark:text-emerald-400 flex items-center justify-center text-base shrink-0">
                            <i class="fas {{ $catIcons[$catName] ?? 'fa-chart-pie' }}"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $catName }}</h3>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                                Bobot Kelompok: {{ $summary['weight'] }}% · {{ $summary['count'] }} Indikator Rasio ({{ $summary['total_pts'] }} Pts)
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $isCatTercapai ? 'bg-[#DCFCE7] dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 border-green-200 dark:border-emerald-800/50' : 'bg-[#FEF9C3] dark:bg-amber-950/60 text-[#854D0E] dark:text-amber-300 border-yellow-200 dark:border-amber-800/50' }}">
                            {{ $summary['status'] }}
                        </span>
                        <button wire:click="toggleCategoryCollapse('{{ $catName }}')" type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-slate-300 p-1">
                            <i class="fas {{ $isCollapsed ? 'fa-chevron-down' : 'fa-chevron-up' }} text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Table Content -->
                @if(!$isCollapsed)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/70 dark:bg-slate-900/60 border-b border-gray-100 dark:border-slate-800 text-[10px] uppercase tracking-wider text-gray-500 dark:text-slate-400 font-bold">
                                    <th class="py-3.5 px-5">KODE & NAMA RASIO</th>
                                    <th class="py-3.5 px-4 text-center">AKTUAL ({{ $selectedPeriod }})</th>
                                    <th class="py-3.5 px-4 text-center">TARGET</th>
                                    <th class="py-3.5 px-4 text-center">PENCAPAIAN</th>
                                    <th class="py-3.5 px-4 text-center">STATUS</th>
                                    <th class="py-3.5 px-5 text-center">DETAIL & AKSI TELUSUR</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-slate-800/80 text-xs">
                                @forelse($ratios as $r)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/40 transition-colors">
                                        <!-- Kode & Nama Rasio Column -->
                                        <td class="py-4 px-5">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span class="px-2 py-0.5 rounded bg-[#DCFCE7] dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 border border-green-200/80 dark:border-emerald-800/50 font-mono font-bold text-xs">
                                                    {{ $r['code'] }}
                                                </span>
                                                <span class="font-bold text-gray-900 dark:text-white">
                                                    {{ $r['name'] }}
                                                </span>
                                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border border-amber-200/60 dark:border-amber-800/40 font-semibold">
                                                    Polaritas: {{ $r['polarity'] }}
                                                </span>
                                            </div>
                                            <div class="text-[11px] font-mono text-gray-400 dark:text-slate-500 mt-1">
                                                Bobot: {{ $r['weight_pts'] }} Pts ({{ $r['weight_pct_cat'] }})
                                            </div>
                                        </td>

                                        <!-- Edit Mode Row or Normal View -->
                                        @if($editingRatioCode === $r['code'])
                                            <td class="py-4 px-4 text-center">
                                                <input type="number" step="0.01" wire:model="editActual" class="w-24 px-2 py-1 text-center font-mono font-bold rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white text-xs">
                                            </td>
                                            <td class="py-4 px-4 text-center">
                                                <input type="number" step="0.01" wire:model="editTarget" class="w-24 px-2 py-1 text-center font-mono font-semibold rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-700 dark:text-slate-300 text-xs">
                                            </td>
                                            <td class="py-4 px-4 text-center text-gray-400 dark:text-slate-500 italic text-[11px]">
                                                Menghitung...
                                            </td>
                                            <td class="py-4 px-4 text-center text-gray-400 dark:text-slate-500">-</td>
                                            <td class="py-4 px-5 text-center">
                                                <div class="inline-flex items-center gap-1.5">
                                                    <button wire:click="updateRatio" class="px-2.5 py-1 rounded-lg bg-[#166534] hover:bg-[#14532D] text-white text-xs font-bold" title="Simpan">
                                                        <i class="fas fa-save mr-1"></i> Simpan
                                                    </button>
                                                    <button wire:click="cancelEdit" class="px-2.5 py-1 rounded-lg bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-200 text-xs" title="Batal">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        @else
                                            <!-- Aktual Column -->
                                            <td class="py-4 px-4 text-center font-mono font-bold text-gray-900 dark:text-slate-100 whitespace-nowrap">
                                                {{ $r['actual_display'] }}
                                            </td>

                                            <!-- Target Column -->
                                            <td class="py-4 px-4 text-center font-mono font-semibold text-gray-600 dark:text-slate-300 whitespace-nowrap">
                                                {{ $r['target_display'] }}
                                            </td>

                                            <!-- Pencapaian Column -->
                                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                                <div class="inline-flex items-center gap-2">
                                                    <div class="w-20 sm:w-28 bg-gray-100 dark:bg-slate-800 rounded-full h-1.5 overflow-hidden">
                                                        <div class="h-1.5 rounded-full {{ $r['achievement_pct'] >= 100 ? 'bg-[#166534] dark:bg-emerald-500' : ($r['achievement_pct'] >= 80 ? 'bg-amber-500' : 'bg-red-500') }}" 
                                                             style="width: {{ min(100, $r['achievement_pct']) }}%"></div>
                                                    </div>
                                                    <span class="font-mono font-bold text-xs {{ $r['achievement_pct'] >= 100 ? 'text-[#166534] dark:text-emerald-400' : ($r['achievement_pct'] >= 80 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">
                                                        {{ number_format($r['achievement_pct'], 1) }}%
                                                    </span>
                                                </div>
                                            </td>

                                            <!-- Status Column -->
                                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                                @if($r['status'] === 'Tercapai')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#DCFCE7] dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 border border-green-200 dark:border-emerald-800/50 font-bold text-[11px]">
                                                        Tercapai
                                                    </span>
                                                @elseif($r['status'] === 'Waspada')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#FEF9C3] dark:bg-amber-950/60 text-[#854D0E] dark:text-amber-300 border border-yellow-200 dark:border-amber-800/50 font-bold text-[11px]">
                                                        Waspada
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#FEE2E2] dark:bg-rose-950/60 text-[#991B1B] dark:text-rose-300 border border-red-200 dark:border-rose-800/50 font-bold text-[11px]">
                                                        Di Bawah Target
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Detail & Aksi Telusur Column -->
                                            <td class="py-4 px-5 text-center whitespace-nowrap">
                                                <div class="inline-flex items-center gap-2">
                                                    <!-- Fleksibilitas Button -->
                                                    <button wire:click="openFlexibilityModal('{{ $r['code'] }}')" type="button" 
                                                            class="px-2.5 py-1 rounded-xl border border-amber-300 dark:border-amber-700/60 bg-amber-50/70 hover:bg-amber-100 dark:bg-amber-950/30 dark:hover:bg-amber-950/60 text-amber-800 dark:text-amber-300 text-[11px] font-semibold transition-colors inline-flex items-center gap-1 shadow-xs cursor-pointer">
                                                        <i class="fas fa-sliders text-[10px]"></i>
                                                        <span>Fleksibilitas</span>
                                                    </button>

                                                    <!-- Detail Pembentuk Button -->
                                                    <button wire:click="openDetailModal('{{ $r['code'] }}')" type="button" 
                                                            class="px-2.5 py-1 rounded-xl border border-indigo-200 dark:border-indigo-800/60 bg-indigo-50/70 hover:bg-indigo-100 dark:bg-indigo-950/30 dark:hover:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 text-[11px] font-semibold transition-colors inline-flex items-center gap-1 shadow-xs cursor-pointer">
                                                        <i class="far fa-file-lines text-[10px]"></i>
                                                        <span>Detail Pembentuk</span>
                                                        <i class="fas fa-chevron-down text-[8px] ml-0.5"></i>
                                                    </button>

                                                    <!-- Telusur Button -->
                                                    <a href="{{ route('department-objectives', ['period' => $selectedPeriod, 'kpi' => $r['linked_kpi']]) }}" 
                                                       class="px-2.5 py-1 rounded-xl border border-green-200 dark:border-emerald-800/50 bg-green-50/70 hover:bg-green-100 dark:bg-emerald-950/30 dark:hover:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 text-[11px] font-semibold transition-colors inline-flex items-center gap-1 shadow-xs">
                                                        <span>Telusur</span>
                                                        <i class="fas fa-arrow-right text-[10px]"></i>
                                                    </a>

                                                    <!-- Admin Edit Pencil if Authorized -->
                                                    @if(auth()->user()?->can('manage ratios') || auth()->user()?->hasRole('Super Admin'))
                                                        <button wire:click="editRatio('{{ $r['code'] }}')" type="button" 
                                                                class="p-1 rounded-lg text-gray-400 hover:text-gray-700 dark:hover:text-slate-200 text-xs transition-colors" title="Edit Rasio Manual">
                                                            <i class="fas fa-pen-to-square"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-gray-400 dark:text-slate-500 py-8 italic text-xs">
                                            Tidak ada data rasio yang cocok dengan filter pencarian.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL 1: DETAIL PEMBENTUK RASIO (FORMULA & COA BREAKDOWN)                -->
    <!-- ========================================================================= -->
    @if($showDetailModal && $selectedRatioDetail)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/60 dark:bg-slate-950/80 backdrop-blur-xs transition-opacity" wire:click="closeDetailModal"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-white dark:bg-[#0F172A] text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-gray-200 dark:border-slate-800">
                    <!-- Modal Header -->
                    <div class="p-6 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-400 flex items-center justify-center text-base border border-indigo-200/60 dark:border-indigo-800/50">
                                <i class="far fa-file-lines"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded bg-indigo-100 dark:bg-indigo-950/80 text-indigo-800 dark:text-indigo-300 font-mono font-bold text-xs">
                                        {{ $selectedRatioDetail['code'] }}
                                    </span>
                                    <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                        Detail Pembentuk: {{ $selectedRatioDetail['name'] }}
                                    </h3>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                                    Kategori: {{ $selectedRatioDetail['category'] }} · Bobot: {{ $selectedRatioDetail['weight_pts'] }} Pts
                                </p>
                            </div>
                        </div>
                        <button wire:click="closeDetailModal" class="w-8 h-8 rounded-full bg-gray-100 dark:bg-slate-800 text-gray-500 hover:text-gray-800 dark:text-slate-400 dark:hover:text-white flex items-center justify-center transition-colors">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 space-y-5 text-xs">
                        <!-- Mathematical Formula Banner -->
                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800">
                            <span class="text-[10px] uppercase font-bold text-gray-400 dark:text-slate-500 tracking-wider block mb-1">
                                Formula Perhitungan Matematis
                            </span>
                            <div class="font-mono font-bold text-sm text-[#166534] dark:text-emerald-400">
                                {{ $selectedRatioDetail['formula'] }}
                            </div>
                        </div>

                        <!-- Breakdown Pembilang & Penyebut -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Pembilang (Numerator) -->
                            <div class="p-4 rounded-2xl bg-blue-50/60 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-900/50">
                                <div class="text-[10px] uppercase font-bold text-blue-700 dark:text-blue-400 tracking-wider flex items-center gap-1.5 mb-1.5">
                                    <i class="fas fa-arrow-up text-[9px]"></i>
                                    <span>Komponen Pembilang (Numerator)</span>
                                </div>
                                <div class="font-semibold text-gray-900 dark:text-white text-xs mb-1">
                                    {{ $selectedRatioDetail['numerator_label'] }}
                                </div>
                                <div class="font-mono font-bold text-sm text-blue-800 dark:text-blue-300">
                                    {{ $selectedRatioDetail['numerator_val'] }}
                                </div>
                            </div>

                            <!-- Penyebut (Denominator) -->
                            <div class="p-4 rounded-2xl bg-indigo-50/60 dark:bg-indigo-950/30 border border-indigo-200 dark:border-indigo-900/50">
                                <div class="text-[10px] uppercase font-bold text-indigo-700 dark:text-indigo-400 tracking-wider flex items-center gap-1.5 mb-1.5">
                                    <i class="fas fa-arrow-down text-[9px]"></i>
                                    <span>Komponen Penyebut (Denominator)</span>
                                </div>
                                <div class="font-semibold text-gray-900 dark:text-white text-xs mb-1">
                                    {{ $selectedRatioDetail['denominator_label'] }}
                                </div>
                                <div class="font-mono font-bold text-sm text-indigo-800 dark:text-indigo-300">
                                    {{ $selectedRatioDetail['denominator_val'] }}
                                </div>
                            </div>
                        </div>

                        <!-- SSOT Chart of Accounts Ledger Mapping -->
                        <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-800">
                            <span class="text-[10px] uppercase font-bold text-gray-500 dark:text-slate-400 tracking-wider block mb-2">
                                Pemetaan Chart of Accounts (CoA) & Sumber Data SSOT
                            </span>
                            <div class="flex items-center gap-2 flex-wrap">
                                @foreach($selectedRatioDetail['coa_refs'] as $coa)
                                    <span class="px-2.5 py-1 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-800 dark:text-slate-200 font-mono text-[11px] font-semibold flex items-center gap-1.5 shadow-2xs">
                                        <i class="fas fa-receipt text-gray-400 dark:text-slate-500 text-[10px]"></i>
                                        <span>{{ $coa }}</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Transmisi ke Objective Departemen -->
                        <div class="p-4 rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-200/60 dark:border-emerald-800/40 flex items-center justify-between gap-4">
                            <div>
                                <span class="text-[10px] uppercase font-bold text-[#166534] dark:text-emerald-400 tracking-wider block mb-0.5">
                                    Jembatan Transmisi KPI Pendorong
                                </span>
                                <div class="font-bold text-gray-900 dark:text-white text-xs">
                                    {{ $selectedRatioDetail['linked_kpi'] }} — {{ $selectedRatioDetail['linked_kpi_name'] }}
                                </div>
                                <span class="text-[11px] text-gray-500 dark:text-slate-400">
                                    Unit Pemilik: {{ $selectedRatioDetail['linked_dept'] }}
                                </span>
                            </div>
                            <a href="{{ route('department-objectives', ['period' => $selectedPeriod, 'kpi' => $selectedRatioDetail['linked_kpi']]) }}" 
                               class="px-3 py-1.5 rounded-xl bg-[#166534] hover:bg-[#14532D] text-white text-xs font-bold inline-flex items-center gap-1.5 shadow-xs shrink-0">
                                <span>Buka KPI</span>
                                <i class="fas fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="p-4 bg-gray-50 dark:bg-slate-900/60 border-t border-gray-100 dark:border-slate-800 flex justify-end">
                        <button wire:click="closeDetailModal" class="px-4 py-2 rounded-xl bg-gray-200 dark:bg-slate-800 hover:bg-gray-300 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-200 text-xs font-bold transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- MODAL 2: FLEKSIBILITAS & SAFETY BUFFER (STRESS TEST CALIBRATION)          -->
    <!-- ========================================================================= -->
    @if($showFlexibilityModal && $selectedRatioFlexibility)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-slate-900/60 dark:bg-slate-950/80 backdrop-blur-xs transition-opacity" wire:click="closeFlexibilityModal"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-white dark:bg-[#0F172A] text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl border border-gray-200 dark:border-slate-800">
                    <!-- Modal Header -->
                    <div class="p-6 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 flex items-center justify-center text-base border border-amber-200/60 dark:border-amber-800/50">
                                <i class="fas fa-sliders"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 font-mono font-bold text-xs">
                                        {{ $selectedRatioFlexibility['code'] }}
                                    </span>
                                    <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                        Kalibrasi Fleksibilitas & Safety Buffer
                                    </h3>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                                    {{ $selectedRatioFlexibility['name'] }}
                                </p>
                            </div>
                        </div>
                        <button wire:click="closeFlexibilityModal" class="w-8 h-8 rounded-full bg-gray-100 dark:bg-slate-800 text-gray-500 hover:text-gray-800 dark:text-slate-400 dark:hover:text-white flex items-center justify-center transition-colors">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 space-y-4 text-xs">
                        <!-- Stress Test Grid -->
                        <div class="grid grid-cols-2 gap-3.5">
                            <div class="p-3.5 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800">
                                <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase block mb-1">Ambang Batas Efektif</span>
                                <span class="font-mono font-bold text-sm text-gray-900 dark:text-white">
                                    {{ $selectedRatioFlexibility['stress_test']['ambang_efektif'] }}
                                </span>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800">
                                <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase block mb-1">Margin of Safety</span>
                                <span class="font-mono font-bold text-sm text-[#166534] dark:text-emerald-400">
                                    {{ $selectedRatioFlexibility['stress_test']['margin_safety'] }}
                                </span>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800">
                                <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase block mb-1">Indeks Sensitivitas</span>
                                <span class="font-mono font-bold text-sm text-indigo-600 dark:text-indigo-400">
                                    {{ $selectedRatioFlexibility['stress_test']['indeks_sensitivitas'] }}
                                </span>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800">
                                <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase block mb-1">Status Buffer</span>
                                <span class="font-bold text-xs {{ $selectedRatioFlexibility['stress_test']['status_buffer'] === 'AMAT AMAN' ? 'text-green-700 dark:text-emerald-400' : ($selectedRatioFlexibility['stress_test']['status_buffer'] === 'WASPADA' ? 'text-amber-700 dark:text-amber-400' : 'text-red-700 dark:text-rose-400') }}">
                                    {{ $selectedRatioFlexibility['stress_test']['status_buffer'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Explanatory Note -->
                        <div class="p-3.5 rounded-2xl bg-amber-50/60 dark:bg-amber-950/30 border border-amber-200/80 dark:border-amber-900/50 text-amber-800 dark:text-amber-300 text-[11px] leading-relaxed">
                            <i class="fas fa-info-circle mr-1"></i>
                            Indeks sensitivitas mengukur ketahanan rasio terhadap skenario stress-test pengetatan ambang batas (+10% hingga +40%) dan syok makro-ekonomi.
                        </div>

                        <!-- Action Link to Sensitivity Menu -->
                        <div class="pt-2 flex justify-between items-center">
                            <a href="{{ route('sensitivity') }}" class="text-xs font-bold text-[#166534] dark:text-emerald-400 hover:underline inline-flex items-center gap-1.5">
                                <span>Buka Simulator Kalibrasi & Sensitivitas Lengkap</span>
                                <i class="fas fa-arrow-up-right-from-square text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="p-4 bg-gray-50 dark:bg-slate-900/60 border-t border-gray-100 dark:border-slate-800 flex justify-end">
                        <button wire:click="closeFlexibilityModal" class="px-4 py-2 rounded-xl bg-gray-200 dark:bg-slate-800 hover:bg-gray-300 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-200 text-xs font-bold transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- MODAL 3: KURIKULUM & PANDUAN 5 KELOMPOK RASIO KEUANGAN                   -->
    <!-- ========================================================================= -->
    @if($showCurriculumModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-slate-900/60 dark:bg-slate-950/80 backdrop-blur-xs transition-opacity" wire:click="closeCurriculumModal"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-white dark:bg-[#0F172A] text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-gray-200 dark:border-slate-800">
                    <!-- Modal Header -->
                    <div class="p-6 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-[#DCFCE7] dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 flex items-center justify-center text-base border border-green-200/60 dark:border-emerald-800/50">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                    Kurikulum & Panduan 5 Kelompok Rasio Keuangan
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                                    PT Herbatech Innopharma — Balanced Scorecard Framework 2026
                                </p>
                            </div>
                        </div>
                        <button wire:click="closeCurriculumModal" class="w-8 h-8 rounded-full bg-gray-100 dark:bg-slate-800 text-gray-500 hover:text-gray-800 dark:text-slate-400 dark:hover:text-white flex items-center justify-center transition-colors">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 space-y-4 text-xs">
                        <p class="text-gray-600 dark:text-slate-300 leading-relaxed">
                            Tingkat Level 2 Balanced Scorecard dirancang dengan 5 pilar kelompok rasio berbobot kumulatif 100 poin untuk menerjemahkan realisasi target Apex Revenue korporasi ke dalam sasaran mutu departemen:
                        </p>

                        <div class="space-y-3">
                            <div class="p-3.5 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-bold text-gray-900 dark:text-white">1. Profitabilitas (Bobot 30% · 4 Rasio)</span>
                                    <span class="font-mono font-bold text-[#166534] dark:text-emerald-400">30 Pts</span>
                                </div>
                                <p class="text-gray-500 dark:text-slate-400 text-[11px]">
                                    Mengukur efisiensi marjin laba kotor (GPM), laba bersih (NPM), serta hasil imbal atas aset (ROA) dan modal pemegang saham (ROE).
                                </p>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-bold text-gray-900 dark:text-white">2. Aktivitas (Bobot 25% · 6 Rasio)</span>
                                    <span class="font-mono font-bold text-[#166534] dark:text-emerald-400">25 Pts</span>
                                </div>
                                <p class="text-gray-500 dark:text-slate-400 text-[11px]">
                                    Mengukur kecepatan perputaran persediaan obat (ITO), aset pabrik (ATO), piutang distributor (ARTO), serta siklus kas (DIO, DSO, DPO).
                                </p>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-bold text-gray-900 dark:text-white">3. Produktivitas (Bobot 20% · 4 Rasio)</span>
                                    <span class="font-mono font-bold text-[#166534] dark:text-emerald-400">20 Pts</span>
                                </div>
                                <p class="text-gray-500 dark:text-slate-400 text-[11px]">
                                    Dihitung dari integrasi HRIS Online (20 karyawan), jam kerja efektif, produktivitas biaya tenaga kerja, dan imbal hasil modal modalitas (CPR).
                                </p>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-bold text-gray-900 dark:text-white">4. Likuiditas (Bobot 15% · 3 Rasio)</span>
                                    <span class="font-mono font-bold text-[#166534] dark:text-emerald-400">15 Pts</span>
                                </div>
                                <p class="text-gray-500 dark:text-slate-400 text-[11px]">
                                    Menjaga ketahanan likuiditas operasional jangka pendek melalui Current Ratio (CR), Cash Ratio, dan Quick Ratio (Acid Test).
                                </p>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-bold text-gray-900 dark:text-white">5. Solvabilitas (Bobot 10% · 2 Rasio)</span>
                                    <span class="font-mono font-bold text-[#166534] dark:text-emerald-400">10 Pts</span>
                                </div>
                                <p class="text-gray-500 dark:text-slate-400 text-[11px]">
                                    Memastikan rasio hutang terhadap modal (DER &le; 0.5x) dan aset (DAR &le; 0.3x) tetap dalam batas aman dan solvabel.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="p-4 bg-gray-50 dark:bg-slate-900/60 border-t border-gray-100 dark:border-slate-800 flex justify-end">
                        <button wire:click="closeCurriculumModal" class="px-4 py-2 rounded-xl bg-[#166534] hover:bg-[#14532D] text-white text-xs font-bold transition-colors">
                            Mengerti & Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
