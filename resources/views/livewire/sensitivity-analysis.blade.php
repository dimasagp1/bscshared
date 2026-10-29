<div class="space-y-5">

    <!-- FLASH MESSAGES -->
    @if(session()->has('message'))
        <div class="rounded-xl bg-green-50 border border-green-200 p-3.5 text-xs text-green-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-check-circle text-green-600"></i>
                <span>{{ session('message') }}</span>
            </div>
            <button type="button" class="text-green-600 hover:text-green-800" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- HERO HEADER CARD: KALIBRASI MARGIN SAFETY & STRESS TEST -->
    <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-2xl bg-green-50 text-[#166534] flex items-center justify-center text-base border border-green-100 shadow-xs">
                <i class="fas fa-wave-square"></i>
            </div>
            <div>
                <h2 class="text-base font-bold text-gray-900">Kalibrasi Margin Safety &amp; Stress Test</h2>
                <p class="text-xs text-gray-500 mt-0.5">
                    Mengukur daya tahan rasio keuangan terhadap pengetatan target dan gejolak ekonomi
                </p>
            </div>
        </div>

        <!-- Reset Button -->
        <button type="button" 
                wire:click="resetCalibration"
                class="px-3.5 py-2 rounded-xl border border-gray-200 hover:bg-gray-50 text-xs font-semibold text-gray-700 flex items-center gap-1.5 shadow-xs transition-colors">
            <i class="fas fa-arrows-rotate text-gray-400 text-xs"></i>
            <span>Reset Kalibrasi</span>
        </button>
    </div>

    <!-- 2 SUB-CARDS: SLIDER PENGETATAN + SKENARIO STRESS-TEST -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        
        <!-- SUB-CARD 1: PENGETATAN AMBANG BATAS (TIGHTENING) -->
        <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-700 flex items-center gap-2">
                        <i class="fas fa-sliders text-[#10B981]"></i>
                        <span>PENGETATAN AMBANG BATAS (TIGHTENING)</span>
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full bg-[#DCFCE7] text-[#166534] text-[10px] font-bold border border-green-200">
                        +{{ $tighteningPct }}% Lebih Ketat
                    </span>
                </div>
                <p class="text-[11px] text-gray-500 mb-4">
                    Menaikkan standar ambang batas minimum untuk menguji batas aman ketahanan modal dan laba.
                </p>
            </div>

            <div>
                <input type="range" 
                       wire:model.live="tighteningPct" 
                       min="0" 
                       max="40" 
                       step="5"
                       class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#166534]">
                <div class="flex items-center justify-between text-[10px] font-mono text-gray-400 mt-2">
                    <span>0% (Standar)</span>
                    <span>+20%</span>
                    <span>+40% (Ultra Konservatif)</span>
                </div>
            </div>
        </div>

        <!-- SUB-CARD 2: PILIH SKENARIO STRESS-TEST -->
        <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-700 flex items-center gap-2">
                        <i class="fas fa-fire text-amber-500"></i>
                        <span>PILIH SKENARIO STRESS-TEST</span>
                    </span>
                </div>
                <div class="grid grid-cols-3 gap-2.5 mb-3">
                    <!-- Baseline -->
                    <button type="button" 
                            wire:click="setScenario('baseline')"
                            class="p-2.5 rounded-xl border text-center transition-all {{ $scenario === 'baseline' ? 'bg-[#DCFCE7] border-green-300 text-[#166534] shadow-xs font-bold' : 'bg-gray-50/70 border-gray-200 text-gray-700 hover:bg-gray-100 font-medium' }}">
                        <i class="fas fa-circle-check block text-sm mb-1 text-green-600"></i>
                        <span class="text-xs block">Baseline Normal</span>
                    </button>

                    <!-- Moderate -->
                    <button type="button" 
                            wire:click="setScenario('moderate')"
                            class="p-2.5 rounded-xl border text-center transition-all {{ $scenario === 'moderate' ? 'bg-amber-50 border-amber-300 text-amber-800 shadow-xs font-bold' : 'bg-gray-50/70 border-gray-200 text-gray-700 hover:bg-gray-100 font-medium' }}">
                        <i class="fas fa-triangle-exclamation block text-sm mb-1 text-amber-500"></i>
                        <span class="text-xs block">Syok Moderat</span>
                    </button>

                    <!-- Severe -->
                    <button type="button" 
                            wire:click="setScenario('severe')"
                            class="p-2.5 rounded-xl border text-center transition-all {{ $scenario === 'severe' ? 'bg-red-50 border-red-300 text-red-800 shadow-xs font-bold' : 'bg-gray-50/70 border-gray-200 text-gray-700 hover:bg-gray-100 font-medium' }}">
                        <i class="fas fa-bolt block text-sm mb-1 text-red-500"></i>
                        <span class="text-xs block">Krisis Severe</span>
                    </button>
                </div>
            </div>

            <p class="text-[10px] text-gray-400 font-mono">
                Kondisi aktif: <strong class="text-gray-700 uppercase">{{ $scenario }}</strong>
            </p>
        </div>

    </div>

    <!-- 4 KPI STATS CARDS (KETAHANAN, SAFE, WASPADA, JATUH AMBANG) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Stat 1: Skor Ketahanan Korporat -->
        <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-medium text-gray-500 block mb-1">Skor Ketahanan Korporat</span>
                <span class="text-3xl font-extrabold text-gray-900 font-mono">{{ $resilienceScore }}%</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-base border border-amber-100">
                <i class="fas fa-gauge-high"></i>
            </div>
        </div>

        <!-- Stat 2: Zona Aman (Safe Buffer) -->
        <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-medium text-gray-500 block mb-1">Zona Aman (Safe Buffer)</span>
                <span class="text-3xl font-extrabold text-[#15803D] font-mono">{{ $safeCount }} Rasio</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-green-50 text-[#166534] flex items-center justify-center text-base border border-green-100">
                <i class="fas fa-shield-halved"></i>
            </div>
        </div>

        <!-- Stat 3: Zona Waspada (Tipis) -->
        <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-medium text-gray-500 block mb-1">Zona Waspada (Tipis)</span>
                <span class="text-3xl font-extrabold text-[#D97706] font-mono">{{ $warnCount }} Rasio</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-base border border-amber-100">
                <i class="fas fa-triangle-exclamation"></i>
            </div>
        </div>

        <!-- Stat 4: Jatuh di Bawah Ambang -->
        <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-medium text-gray-500 block mb-1">Jatuh di Bawah Ambang</span>
                <span class="text-3xl font-extrabold text-[#DC2626] font-mono">{{ $dangerCount }} Rasio</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-base border border-red-100">
                <i class="fas fa-arrow-trend-down"></i>
            </div>
        </div>

    </div>

    <!-- DATA TABLE: MATRIKS MARGIN SAFETY & SENSITIVITAS RASIO -->
    <div class="bg-white rounded-3xl border border-gray-200 shadow-xs overflow-hidden">
        
        <!-- Table Header -->
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-900 flex items-center gap-2">
                <i class="fas fa-table-cells text-[#10B981]"></i>
                <span>MATRIKS MARGIN SAFETY &amp; SENSITIVITAS RASIO</span>
            </h3>
            <span class="text-[11px] text-gray-400 font-medium">7 Rasio Keuangan Utama Dianalisis</span>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-gray-50/75 border-b border-gray-100 text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                        <th class="py-3 px-5">KODE &amp; NAMA RASIO</th>
                        <th class="py-3 px-4">KATEGORI</th>
                        <th class="py-3 px-4 text-center">AKTUAL / SHOCKED</th>
                        <th class="py-3 px-4 text-center">AMBANG BATAS EFEKTIF</th>
                        <th class="py-3 px-4 text-center">MARGIN SAFETY</th>
                        <th class="py-3 px-4 text-center">INDEKS SENSITIVITAS</th>
                        <th class="py-3 px-5 text-right">STATUS BUFFER</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($ratios as $r)
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <!-- Kode & Nama -->
                            <td class="py-3.5 px-5">
                                <span class="font-bold text-gray-900 block">{{ $r['name'] }}</span>
                                <span class="text-[10px] text-gray-400 font-mono">{{ $r['code'] }} &middot; Bobot {{ $r['weight'] }}</span>
                            </td>

                            <!-- Kategori -->
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-gray-100 text-gray-700">
                                    {{ $r['category'] }}
                                </span>
                            </td>

                            <!-- Aktual / Shocked -->
                            <td class="py-3.5 px-4 text-center font-mono font-bold text-gray-900">
                                {{ number_format($r['shocked_actual'], 2, ',', '.') }} {{ $r['unit'] }}
                            </td>

                            <!-- Ambang Batas Efektif -->
                            <td class="py-3.5 px-4 text-center font-mono font-semibold text-gray-600">
                                {{ number_format($r['effective_threshold'], 2, ',', '.') }} {{ $r['unit'] }}
                            </td>

                            <!-- Margin Safety -->
                            <td class="py-3.5 px-4 text-center font-mono font-bold text-green-700">
                                <span class="px-2 py-0.5 rounded bg-green-50 border border-green-200">
                                    {{ $r['margin'] }}
                                </span>
                            </td>

                            <!-- Indeks Sensitivitas -->
                            <td class="py-3.5 px-4 text-center font-mono font-bold text-green-800">
                                <span class="px-2 py-0.5 rounded bg-green-100/60">
                                    {{ $r['index'] }}
                                </span>
                            </td>

                            <!-- Status Buffer -->
                            <td class="py-3.5 px-5 text-right">
                                @if($r['status'] === 'AMAT AMAN')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#DCFCE7] text-[#166534] border border-green-200">
                                        <i class="fas fa-shield-halved text-[9px]"></i>
                                        <span>AMAT AMAN</span>
                                    </span>
                                @elseif($r['status'] === 'WASPADA')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <i class="fas fa-triangle-exclamation text-[9px]"></i>
                                        <span>WASPADA</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-200">
                                        <i class="fas fa-arrow-trend-down text-[9px]"></i>
                                        <span>JATUH AMBANG</span>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>

