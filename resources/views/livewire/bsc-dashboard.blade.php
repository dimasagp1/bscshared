<div class="space-y-5">
    
    @php
        $apexFillClass = $revenueScore < 80 ? 'fill-[#FFF1F2] dark:fill-rose-950/40' : ($revenueScore < 100 ? 'fill-[#FFFBEB] dark:fill-amber-950/40' : 'fill-[#ECFDF5] dark:fill-emerald-950/40');
        $apexStrokeClass = $revenueScore < 80 ? 'stroke-[#EF4444] dark:stroke-rose-500' : ($revenueScore < 100 ? 'stroke-[#F59E0B] dark:stroke-amber-500' : 'stroke-[#10B981] dark:stroke-emerald-500');
        $apexTextColorClass = $revenueScore < 80 ? 'text-[#DC2626] dark:text-rose-400' : ($revenueScore < 100 ? 'text-[#D97706] dark:text-amber-400' : 'text-[#166534] dark:text-emerald-400');
    @endphp

    <!-- ALERT BANNER -->
    @if($revenueScore < 80)
        <div class="rounded-xl bg-[#FEF2F2] dark:bg-rose-950/30 border border-[#FECACA] dark:border-rose-900/50 p-3.5 flex items-center justify-between text-xs font-medium text-red-700 dark:text-rose-300 shadow-xs">
            <div class="flex items-center gap-2.5">
                <i class="far fa-circle-exclamation text-red-600 dark:text-rose-400 text-sm"></i>
                <span>
                    Realisasi revenue mencapai <strong>{{ number_format($revenueScore, 2) }}%</strong> dari target {{ $viewMode === 'ytd' ? 'Akumulasi YTD' : '' }}. 
                    <a href="{{ route('bsc-wiring') }}" class="underline font-bold hover:text-red-900 dark:hover:text-rose-200 transition-colors">
                        Simulasikan kaskade di Menu 10.
                    </a>
                </span>
            </div>
            <button type="button" class="text-red-400 dark:text-rose-400 hover:text-red-700 dark:hover:text-rose-200">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
    @else
        <div class="rounded-xl bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-900/50 p-3.5 flex items-center justify-between text-xs font-medium text-amber-800 dark:text-amber-300 shadow-xs">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-circle-info text-amber-600 dark:text-amber-400 text-sm"></i>
                <span>
                    Realisasi revenue {{ $viewMode === 'ytd' ? 'Akumulasi YTD' : 'Bulan Berjalan' }} mencapai <strong>{{ number_format($revenueScore, 1) }}%</strong> dari target. 
                    <a href="{{ route('bsc-wiring') }}" class="underline font-bold hover:text-amber-900 dark:hover:text-amber-200 transition-colors">
                        Simulasikan kaskade di Menu 10.
                    </a>
                </span>
            </div>
        </div>
    @endif

    <!-- FLASH MESSAGES -->
    @if(session()->has('message'))
        <div class="rounded-xl bg-green-50 dark:bg-emerald-950/40 border border-green-200 dark:border-emerald-800/50 p-3.5 text-xs text-green-800 dark:text-emerald-300 flex items-center gap-2">
            <i class="fas fa-check-circle text-green-600 dark:text-emerald-400"></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- MAIN 2-COLUMN GRID (KIRI: PIRAMIDA 4 TINGKAT, KANAN: 3 KARTU DIAGNOSTIK) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- KOLOM KIRI: KARTU PIRAMIDA SKORING 4 TINGKAT (col-span-7) -->
        <div class="lg:col-span-7 bg-white dark:bg-[#121214] rounded-3xl border border-gray-200 dark:border-[#1F2026] p-6 shadow-xs flex flex-col justify-between transition-colors duration-200">
            <div>
                <!-- Card Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-2.5">
                        <i class="fas fa-wave-square text-[#10B981] text-base"></i>
                        <div>
                            <h2 class="text-base font-bold text-gray-900 dark:text-white">Piramida Skoring 4 Tingkat</h2>
                            <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                                Klik tingkat L1 untuk rincian 100% Revenue &amp; Breakdown, atau L2–L4 untuk penelusuran akar masalah
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Sub-Controls Bar -->
                <div class="flex flex-wrap items-center justify-between gap-2.5 pb-4 border-b border-gray-100 dark:border-[#1F2026]">
                    <div class="flex items-center gap-2">
                        <!-- Dropdown Periode Indicator -->
                        <div class="px-2.5 py-1 rounded-lg border border-gray-200 dark:border-slate-700 text-xs font-semibold text-gray-800 dark:text-slate-200 flex items-center gap-1.5 bg-gray-50/50 dark:bg-slate-800/60">
                            <i class="far fa-calendar text-gray-400 dark:text-slate-500"></i>
                            <span>{{ $selectedPeriod }}</span>
                            <i class="fas fa-chevron-down text-[9px] text-gray-400 dark:text-slate-500"></i>
                        </div>

                        <!-- Segmented Pill Toggle: Bulanan vs YTD -->
                        <div class="flex items-center bg-gray-100 dark:bg-slate-800/80 p-0.5 rounded-lg border border-gray-200 dark:border-slate-700 text-[11px] font-semibold">
                            <button type="button" 
                                    wire:click="setViewMode('monthly')"
                                    class="px-2.5 py-1 rounded-md transition-all {{ $viewMode === 'monthly' ? 'bg-[#DCFCE7] dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 shadow-xs' : 'text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200' }}">
                                <i class="far fa-calendar-check mr-1"></i> Bulanan
                            </button>
                            <button type="button" 
                                    wire:click="setViewMode('ytd')"
                                    class="px-2.5 py-1 rounded-md transition-all {{ $viewMode === 'ytd' ? 'bg-[#DCFCE7] dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 shadow-xs' : 'text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200' }}">
                                <i class="fas fa-chart-column mr-1"></i> Akumulasi YTD
                            </button>
                        </div>
                    </div>

                    <!-- Sync Timestamp Pill -->
                    <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-gray-50 dark:bg-slate-800 text-gray-600 dark:text-slate-400 border border-gray-200 dark:border-slate-700 text-xs font-medium font-mono">
                        <i class="fas fa-arrows-rotate text-gray-400 dark:text-slate-500 text-[10px]"></i>
                        <span>27 Okt 2026, 05.52</span>
                    </div>
                </div>

                <!-- Sub-Banner Target vs Realisasi -->
                <div class="mt-4 px-3.5 py-2 rounded-xl bg-gray-50/70 dark:bg-slate-800/60 border border-gray-100 dark:border-slate-700/60 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#10B981]"></span>
                        <span class="font-bold text-[#166534] dark:text-emerald-400">
                            Mode Tampilan: {{ $viewMode === 'ytd' ? 'Akumulasi YTD (Jan – ' . $monthShort . ' ' . $year . ')' : 'Bulan Berjalan (' . $selectedPeriod . ')' }}
                        </span>
                    </div>
                    <div class="font-mono text-gray-600 dark:text-slate-400 text-[11px]">
                        Target: <span class="font-bold text-gray-900 dark:text-slate-100">Rp {{ number_format($activeTargetM, 2) }} M</span> | 
                        Realisasi: <span class="font-bold text-gray-900 dark:text-slate-100">
                            @if($viewMode === 'ytd' || $activeActualM >= 1.0)
                                Rp {{ number_format($activeActualM, 2) }} M
                            @else
                                Rp {{ number_format($activeActualM * 1000, 1) }} Jt
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Centered Badge Above Apex -->
                <div class="text-center mt-6 mb-3">
                    <span class="inline-flex items-center gap-1.5 px-4 py-1 rounded-full bg-green-50 dark:bg-emerald-950/50 border border-green-300 dark:border-emerald-800/60 text-xs font-semibold text-[#166534] dark:text-emerald-400 shadow-xs">
                        Bobot <strong class="text-green-800 dark:text-emerald-300">100%</strong> Revenue ({{ $viewMode === 'ytd' ? 'Pencapaian Akumulatif YTD' : 'Pencapaian Bulanan' }})
                    </span>
                </div>

                <!-- 4-TIER INTERACTIVE SVG PYRAMID (GEOMETRI PRESISI MOCKUP) -->
                <div class="relative w-full max-w-lg mx-auto py-2">
                    
                    <!-- SVG CONTAINER FOR CRISP OUTLINES & PASTEL FILLS -->
                    <svg viewBox="0 0 500 370" class="w-full h-auto drop-shadow-xs select-none">
                        <!-- TIER 1: APEX REVENUE (Segitiga Lancip Puncak) -->
                        <polygon points="250,15 320,95 180,95" 
                                 class="{{ $apexFillClass }} {{ $apexStrokeClass }} stroke-[1.5] transition-all duration-150 hover:opacity-90 cursor-pointer"
                                 wire:click="selectLevel(1)" />

                        <!-- TIER 2: RASIO KEUANGAN (Trapesium Atas) -->
                        <polygon points="175,102 325,102 380,185 120,185" 
                                 class="fill-[#FFFBEB] dark:fill-amber-950/30 stroke-[#F59E0B] dark:stroke-amber-500/80 stroke-[1.5] transition-all duration-150 hover:fill-[#FEF3C7] dark:hover:fill-amber-950/50 cursor-pointer"
                                 wire:click="selectLevel(2)" />

                        <!-- TIER 3: OBJECTIVE DEPARTEMEN (Trapesium Tengah) -->
                        <polygon points="115,192 385,192 440,275 60,275" 
                                 class="fill-[#FFFBEB] dark:fill-amber-950/30 stroke-[#F59E0B] dark:stroke-amber-500/80 stroke-[1.5] transition-all duration-150 hover:fill-[#FEF3C7] dark:hover:fill-amber-950/50 cursor-pointer"
                                 wire:click="selectLevel(3)" />

                        <!-- TIER 4: ACTION PLANS (Trapesium Dasar) -->
                        <polygon points="55,282 445,282 495,362 5,362" 
                                 class="fill-[#FFF1F2] dark:fill-rose-950/30 stroke-[#EF4444] dark:stroke-rose-500/80 stroke-[1.5] transition-all duration-150 hover:fill-[#FFE4E6] dark:hover:fill-rose-950/50 cursor-pointer"
                                 wire:click="selectLevel(4)" />
                    </svg>

                    <!-- HTML OVERLAY TEXT LAYER (PERSIS SESUAI GAMBAR) -->
                    <div class="absolute inset-0 pointer-events-none">
                        
                        <!-- TIER 1 CONTENT OVERLAY -->
                        <div class="absolute top-[38px] inset-x-0 flex flex-col items-center justify-center text-center pointer-events-auto cursor-pointer"
                             wire:click="selectLevel(1)">
                            <div class="w-4 h-4 rounded-full bg-gray-900 dark:bg-slate-700 text-white text-[9px] font-bold flex items-center justify-center mb-0.5">L1</div>
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-900 dark:text-slate-100 leading-tight">REVENUE</span>
                            <span class="text-base font-extrabold {{ $apexTextColorClass }} leading-none my-0.5">{{ number_format($revenueScore, 1) }}%</span>
                            <div class="flex items-center gap-1 text-[9px]">
                                <span class="{{ $apexTextColorClass }} font-medium">{{ $activeStatus }}</span>
                                <span class="text-teal-700 dark:text-teal-400 font-bold hover:underline">Detail &gt;</span>
                            </div>
                        </div>

                        <!-- TIER 2 CONTENT OVERLAY -->
                        <div class="absolute top-[125px] inset-x-0 px-24 flex items-center justify-between pointer-events-auto cursor-pointer"
                             wire:click="selectLevel(2)">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full bg-gray-900 dark:bg-slate-700 text-white text-[9px] font-bold flex items-center justify-center">L2</div>
                                <div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-slate-100 flex items-center gap-1">
                                        RASIO KEUANG... <i class="fas fa-arrow-up-right text-[10px] text-gray-500 dark:text-slate-400"></i>
                                    </span>
                                    <span class="text-[10px] text-[#D97706] dark:text-amber-400 font-medium block">Status: Waspada</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-base font-extrabold text-[#D97706] dark:text-amber-400">{{ number_format($avgRatioScore, 1) }}%</span>
                                <span class="text-[10px] font-bold text-teal-700 dark:text-teal-400 block hover:underline">Telusuri &gt;</span>
                            </div>
                        </div>

                        <!-- TIER 3 CONTENT OVERLAY -->
                        <div class="absolute top-[215px] inset-x-0 px-16 flex items-center justify-between pointer-events-auto cursor-pointer"
                             wire:click="selectLevel(3)">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full bg-gray-900 dark:bg-slate-700 text-white text-[9px] font-bold flex items-center justify-center">L3</div>
                                <div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-slate-100 flex items-center gap-1">
                                        OBJECTIVE DEPARTEMEN <i class="fas fa-arrow-up-right text-[10px] text-gray-500 dark:text-slate-400"></i>
                                    </span>
                                    <span class="text-[10px] text-[#D97706] dark:text-amber-400 font-medium block">Status: Waspada</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-base font-extrabold text-[#D97706] dark:text-amber-400">{{ number_format($avgObjScore, 1) }}%</span>
                                <span class="text-[10px] font-bold text-teal-700 dark:text-teal-400 block hover:underline">Telusuri &gt;</span>
                            </div>
                        </div>

                        <!-- TIER 4 CONTENT OVERLAY -->
                        <div class="absolute top-[305px] inset-x-0 px-10 flex items-center justify-between pointer-events-auto cursor-pointer"
                             wire:click="selectLevel(4)">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full bg-gray-900 dark:bg-slate-700 text-white text-[9px] font-bold flex items-center justify-center">L4</div>
                                <div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-slate-100 flex items-center gap-1">
                                        PROGRAM KERJA &amp; ACTION PLAN <i class="fas fa-arrow-up-right text-[10px] text-gray-500 dark:text-slate-400"></i>
                                    </span>
                                    <span class="text-[10px] text-[#DC2626] dark:text-rose-400 font-medium block">Status: Di Bawah Target</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-base font-extrabold text-[#DC2626] dark:text-rose-400">{{ number_format($avgActionProgress, 1) }}%</span>
                                <span class="text-[10px] font-bold text-teal-700 dark:text-teal-400 block hover:underline">Telusuri &gt;</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- KOLOM KANAN: 3 KARTU DIAGNOSTIK (col-span-5) -->
        <div class="lg:col-span-5 space-y-4">
            
            <!-- KARTU 1: KESEHATAN TINGKATAN -->
            <div class="bg-white dark:bg-[#121214] rounded-3xl border border-gray-200 dark:border-[#1F2026] p-6 shadow-xs transition-colors duration-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-shield-halved text-[#10B981] text-sm"></i>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-slate-200">KESEHATAN TINGKATAN</h3>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full bg-[#DCFCE7] dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 border border-transparent dark:border-emerald-800/50 text-[10px] font-bold">
                        4 Tier Aktif
                    </span>
                </div>

                <!-- 4 Level Health Cards Rows -->
                <div class="space-y-2.5">
                    <!-- Level 1 -->
                    <div wire:click="selectLevel(1)" 
                         class="p-3 rounded-2xl border {{ $revenueScore < 80 ? 'border-rose-100 dark:border-rose-950/60 bg-rose-50/40 dark:bg-rose-950/20 hover:bg-rose-50 dark:hover:bg-rose-950/30' : 'border-amber-100 dark:border-amber-950/60 bg-amber-50/40 dark:bg-amber-950/20 hover:bg-amber-50 dark:hover:bg-amber-950/30' }} flex items-center justify-between cursor-pointer transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl {{ $revenueScore < 80 ? 'bg-rose-100 dark:bg-rose-950/60 text-[#DC2626] dark:text-rose-400' : 'bg-amber-100 dark:bg-amber-950/60 text-[#D97706] dark:text-amber-400' }} flex items-center justify-center text-xs">
                                <i class="fas fa-arrow-trend-up"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-bold text-gray-900 dark:text-slate-100">Level 1: REVENUE</span>
                                    <span class="bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-slate-300 text-[9px] px-1 py-0.2 rounded font-medium">
                                        {{ $viewMode === 'ytd' ? 'Akumulasi YTD' : 'Bulanan' }}
                                    </span>
                                </div>
                                <span class="text-[11px] {{ $apexTextColorClass }} font-medium block">Status: {{ $activeStatus }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-extrabold {{ $apexTextColorClass }}">{{ number_format($revenueScore, 1) }}%</span>
                            <i class="fas fa-chevron-right text-xs text-gray-300 dark:text-slate-600"></i>
                        </div>
                    </div>

                    <!-- Level 2 -->
                    <div wire:click="selectLevel(2)" 
                         class="p-3 rounded-2xl border border-amber-100 dark:border-amber-950/60 bg-amber-50/40 dark:bg-amber-950/20 hover:bg-amber-50 dark:hover:bg-amber-950/30 flex items-center justify-between cursor-pointer transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-950/60 text-[#D97706] dark:text-amber-400 flex items-center justify-center text-xs">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-gray-900 dark:text-slate-100">Level 2: RASIO KEUANGAN</span>
                                <span class="text-[11px] text-[#D97706] dark:text-amber-400 font-medium block">Status: Waspada</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-extrabold text-[#D97706] dark:text-amber-400">{{ number_format($avgRatioScore, 1) }}%</span>
                            <i class="fas fa-chevron-right text-xs text-gray-300 dark:text-slate-600"></i>
                        </div>
                    </div>

                    <!-- Level 3 -->
                    <div wire:click="selectLevel(3)" 
                         class="p-3 rounded-2xl border border-amber-100 dark:border-amber-950/60 bg-amber-50/40 dark:bg-amber-950/20 hover:bg-amber-50 dark:hover:bg-amber-950/30 flex items-center justify-between cursor-pointer transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-950/60 text-[#D97706] dark:text-amber-400 flex items-center justify-center text-xs">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-gray-900 dark:text-slate-100">Level 3: OBJECTIVE DEPARTEMEN</span>
                                <span class="text-[11px] text-[#D97706] dark:text-amber-400 font-medium block">Status: Waspada</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-extrabold text-[#D97706] dark:text-amber-400">{{ number_format($avgObjScore, 1) }}%</span>
                            <i class="fas fa-chevron-right text-xs text-gray-300 dark:text-slate-600"></i>
                        </div>
                    </div>

                    <!-- Level 4 -->
                    <div wire:click="selectLevel(4)" 
                         class="p-3 rounded-2xl border border-rose-100 dark:border-rose-950/60 bg-rose-50/40 dark:bg-rose-950/20 hover:bg-rose-50 dark:hover:bg-rose-950/30 flex items-center justify-between cursor-pointer transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-rose-100 dark:bg-rose-950/60 text-[#DC2626] dark:text-rose-400 flex items-center justify-center text-xs">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-gray-900 dark:text-slate-100">Level 4: PROGRAM KERJA &amp; ACTION PLAN</span>
                                <span class="text-[11px] text-[#DC2626] dark:text-rose-400 font-medium block">Status: Di Bawah Target</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-extrabold text-[#DC2626] dark:text-rose-400">{{ number_format($avgActionProgress, 1) }}%</span>
                            <i class="fas fa-chevron-right text-xs text-gray-300 dark:text-slate-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KARTU 2: RINGKASAN INDIKATOR (2X2 GRID METRIK) -->
            <div class="bg-white dark:bg-[#121214] rounded-3xl border border-gray-200 dark:border-[#1F2026] p-6 shadow-xs transition-colors duration-200">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-slate-200 mb-4">
                    RINGKASAN INDIKATOR ({{ $viewMode === 'ytd' ? 'AKUMULATIF YTD' : 'BULANAN' }})
                </h3>

                <div class="grid grid-cols-2 gap-3.5">
                    <!-- Tile 1 -->
                    <div class="p-4 rounded-2xl border border-gray-100 dark:border-[#1F2026] bg-gray-50/50 dark:bg-slate-800/40">
                        <span class="text-[11px] font-medium text-gray-500 dark:text-slate-400 block mb-1">Skor Revenue ({{ $viewMode === 'ytd' ? 'YTD' : 'Bulan Ini' }})</span>
                        <span class="text-2xl font-extrabold {{ $apexTextColorClass }} font-mono">{{ number_format($revenueScore, 1) }}%</span>
                    </div>

                    <!-- Tile 2 -->
                    <div class="p-4 rounded-2xl border border-gray-100 dark:border-[#1F2026] bg-gray-50/50 dark:bg-slate-800/40">
                        <span class="text-[11px] font-medium text-gray-500 dark:text-slate-400 block mb-1">Skor Rasio Keuangan</span>
                        <span class="text-2xl font-extrabold text-teal-700 dark:text-teal-400 font-mono">{{ number_format($avgRatioScore, 1) }}%</span>
                    </div>

                    <!-- Tile 3 -->
                    <div class="p-4 rounded-2xl border border-gray-100 dark:border-[#1F2026] bg-gray-50/50 dark:bg-slate-800/40">
                        <span class="text-[11px] font-medium text-gray-500 dark:text-slate-400 block mb-1">Skor Puncak Apex</span>
                        <span class="text-2xl font-extrabold {{ $apexTextColorClass }} font-mono">{{ number_format($apexScore, 1) }}%</span>
                    </div>

                    <!-- Tile 4 -->
                    <div class="p-4 rounded-2xl border border-gray-100 dark:border-[#1F2026] bg-gray-50/50 dark:bg-slate-800/40">
                        <span class="text-[11px] font-medium text-gray-500 dark:text-slate-400 block mb-1">Status Capaian</span>
                        <span class="text-xl font-extrabold {{ $apexTextColorClass }} block">{{ $activeStatus }}</span>
                    </div>
                </div>
            </div>

            <!-- KARTU 3: METODOLOGI BOBOT APEX & BREAKDOWN -->
            <div class="bg-white dark:bg-[#121214] rounded-3xl border border-gray-200 dark:border-[#1F2026] p-6 shadow-xs transition-colors duration-200">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-sparkles text-[#10B981] text-xs"></i>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-[#166534] dark:text-emerald-400">
                            METODOLOGI BOBOT APEX &amp; BREAKDOWN
                        </h3>
                    </div>
                    <button type="button" 
                            wire:click="openDrilldown('revenue', 0)"
                            class="text-xs text-[#166534] dark:text-emerald-400 font-bold hover:underline flex items-center gap-1">
                        <span>Detail Drilldown</span>
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </button>
                </div>

                <!-- Formula Monospace Code Box -->
                <div class="p-3 rounded-xl bg-gray-50 dark:bg-slate-800/70 border border-gray-100 dark:border-slate-700 font-mono text-xs text-gray-800 dark:text-slate-200 font-semibold mb-2">
                    @if($viewMode === 'ytd')
                        Apex Score (Akumulatif YTD) = <strong class="text-green-700 dark:text-emerald-400">100%</strong> &times; (Total Realisasi YTD &divide; Total Target YTD)
                    @else
                        Apex Score (Bulanan) = <strong class="text-green-700 dark:text-emerald-400">100%</strong> &times; (Actual &divide; Target)
                    @endif
                </div>

                <p class="text-[11px] text-gray-500 dark:text-slate-400 leading-relaxed">
                    Realisasi terhubung langsung ke Odoo ERP melalui Finance Monitoring SSOT.
                </p>
            </div>

        </div>
    </div>

    <!-- DETAIL DRILLDOWN MODAL -->
    @if($showModal && $selectedItemDetail)
        <div class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm animate-in fade-in duration-150"
             wire:click.self="closeModal">
            <div class="bg-white dark:bg-[#121214] rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 dark:border-[#1F2026] text-left">
                <!-- Modal Header -->
                <div class="flex items-start justify-between pb-3 border-b border-gray-100 dark:border-[#1F2026] mb-4">
                    <div>
                        <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 uppercase">
                            {{ $selectedItemDetail['code'] }}
                        </span>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white mt-1">
                            {{ $selectedItemDetail['name'] }}
                        </h3>
                        <span class="text-xs font-semibold text-[#166534] dark:text-emerald-400">{{ $selectedItemDetail['type'] }}</span>
                    </div>
                    <button type="button" wire:click="closeModal" class="text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 p-1">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="space-y-3.5 text-xs">
                    <div class="grid grid-cols-3 gap-2 p-3 bg-gray-50 dark:bg-slate-800/70 rounded-xl">
                        <div>
                            <span class="text-gray-400 dark:text-slate-500 block text-[10px]">TARGET</span>
                            <span class="font-bold text-gray-900 dark:text-slate-100">{{ $selectedItemDetail['target'] }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 dark:text-slate-500 block text-[10px]">REALISASI</span>
                            <span class="font-bold text-gray-900 dark:text-slate-100">{{ $selectedItemDetail['actual'] }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 dark:text-slate-500 block text-[10px]">CAPAIAN</span>
                            <span class="font-bold text-[#DC2626] dark:text-rose-400">{{ $selectedItemDetail['achievement'] }}</span>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-bold text-gray-700 dark:text-slate-200 text-[11px] mb-1">Kausalitas &amp; Dampak:</h4>
                        <p class="text-gray-600 dark:text-slate-300 text-[11px] leading-relaxed mb-1">
                            <strong>Upstream:</strong> {{ $selectedItemDetail['upstream'] }}
                        </p>
                        <p class="text-gray-600 dark:text-slate-300 text-[11px] leading-relaxed">
                            <strong>Downstream:</strong> {{ $selectedItemDetail['downstream'] }}
                        </p>
                    </div>

                    <div class="p-3 bg-green-50/70 dark:bg-emerald-950/30 border border-green-200/60 dark:border-emerald-800/50 rounded-xl">
                        <span class="font-bold text-[#166534] dark:text-emerald-400 block mb-0.5 text-[11px]">Audit Keterhubungan SSOT:</span>
                        <p class="text-gray-600 dark:text-slate-300 text-[11px] leading-relaxed">
                            {{ $selectedItemDetail['description'] }}
                        </p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="pt-4 mt-4 border-t border-gray-100 dark:border-[#1F2026] flex items-center justify-end gap-2">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 text-xs font-semibold text-gray-700 dark:text-slate-300 transition-colors">
                        Tutup
                    </button>
                    <a href="{{ route('bsc-wiring') }}" class="px-4 py-2 rounded-lg bg-[#166534] hover:bg-[#14532D] text-white text-xs font-bold">
                        Simulasikan di Wiring &gt;
                    </a>
                </div>
            </div>
        </div>
    @endif

</div>
