<div class="space-y-6">
    <!-- FLASH MESSAGES -->
    @if(session()->has('message'))
        <div class="rounded-2xl bg-green-50 dark:bg-emerald-950/40 border border-green-200 dark:border-emerald-800/50 p-4 text-xs text-green-800 dark:text-emerald-300 flex items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-check-circle text-green-600 dark:text-emerald-400 text-sm"></i>
                <span class="font-medium">{{ session('message') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-600 dark:text-emerald-400 hover:text-green-800 text-xs cursor-pointer">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Card 1: Hero Header Card -->
    <div class="bg-white dark:bg-[#121214] rounded-3xl border border-gray-200 dark:border-[#1F2026] p-5 sm:p-6 shadow-xs flex flex-wrap items-center justify-between gap-4 transition-colors duration-200">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 border border-amber-200/60 dark:border-amber-800/50 flex items-center justify-center text-xl shadow-xs shrink-0">
                <i class="fas fa-bolt"></i>
            </div>
            <div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">
                    Analisis What-If & Simulation Sandbox
                </h2>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                    Menguji dampak simulasi perubahan KPI terhadap pos Laporan Keuangan & Rasio
                </p>
            </div>
        </div>

        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 border border-amber-200/80 dark:border-amber-800/50 shadow-xs">
                <i class="fas fa-triangle-exclamation text-[11px]"></i>
                <span>Simulasi Murni — Bebas Memenjara Database</span>
            </span>
        </div>
    </div>

    <!-- Card 2: Form Kontrol Parameter Realisasi KPI -->
    <div class="bg-white dark:bg-[#121214] rounded-3xl border border-gray-200 dark:border-[#1F2026] p-5 sm:p-6 shadow-xs space-y-4 transition-colors duration-200">
        <h3 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">
            KONTROL PARAMETER REALISASI KPI
        </h3>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
            <!-- Dropdown KPI Pendorong Target (Col 5) -->
            <div class="lg:col-span-5 space-y-1.5">
                <label class="text-xs font-medium text-gray-600 dark:text-slate-400 block">
                    Pilih KPI Pendorong Target
                </label>
                <select wire:model.live="selectedKpi" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-gray-900 dark:text-white font-bold focus:outline-none focus:ring-1 focus:ring-green-600 cursor-pointer">
                    <option value="FAT-01">FAT-01 (Rasio penagihan invoice (collection ratio))</option>
                    <option value="FAT-02">FAT-02 (Rasio pembayaran tepat termin (vendor))</option>
                    <option value="OPS-01">OPS-01 (Pemenuhan service level line produksi)</option>
                    <option value="HC-01">HC-01 (Efisiensi rasio biaya tenaga kerja terhadap omset)</option>
                </select>
                <div class="text-[11px] font-mono text-gray-400 dark:text-slate-500 pt-0.5">
                    Target: {{ $currentKpi['target'] }} · Polaritas: {{ $currentKpi['polarity'] }} · {{ $currentKpi['dept'] }}
                </div>
            </div>

            <!-- Slider Realisasi KPI (Col 4) -->
            <div class="lg:col-span-4 space-y-1.5">
                <div class="flex items-center justify-between text-xs">
                    <span class="font-medium text-gray-700 dark:text-slate-300">Simulasi Realisasi KPI:</span>
                    <span class="font-bold text-xs px-2 py-0.5 rounded-md bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 border border-amber-300 dark:border-amber-700/60">
                        {{ $currentKpi['target_badge'] }}
                    </span>
                </div>
                <input type="range" wire:model.live="simulatedKpiValue" min="0" max="120" step="0.5" 
                       class="w-full h-1.5 bg-gray-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer accent-[#166534] dark:accent-emerald-500">
                <div class="text-[11px] font-mono text-gray-400 dark:text-slate-500">
                    Aktual simulasi: {{ number_format($simulatedKpiValue, 1, ',', '.') }}
                </div>
            </div>

            <!-- Tombol Hitung Transmisi (Col 3) -->
            <div class="lg:col-span-3 flex items-center justify-start lg:justify-end pt-1">
                <button wire:click="calculateTransmission" type="button" 
                        class="px-5 py-2.5 rounded-xl bg-[#166534] hover:bg-[#14532D] active:bg-[#0f3d20] text-white text-xs font-bold shadow-xs transition-colors inline-flex items-center gap-2 cursor-pointer whitespace-nowrap">
                    <i class="fas fa-play text-[10px]"></i>
                    <span>Hitung Transmisi</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Card 3: Hasil Simulasi & Transmisi (4 Tab Interaktif) -->
    <div class="bg-white dark:bg-[#121214] rounded-3xl border border-gray-200 dark:border-[#1F2026] p-5 sm:p-6 shadow-xs space-y-5 transition-colors duration-200">
        <!-- 4 Tab Bar -->
        <div class="flex items-center gap-6 border-b border-gray-200 dark:border-[#1F2026] overflow-x-auto text-xs">
            <button wire:click="setTab('diagram')" type="button" 
                    class="pb-3 font-semibold transition-colors whitespace-nowrap cursor-pointer flex items-center gap-1.5 {{ $activeTab === 'diagram' ? 'border-b-2 border-[#166534] dark:border-emerald-500 text-[#166534] dark:text-emerald-400 font-bold' : 'text-gray-500 hover:text-gray-800 dark:text-slate-400 dark:hover:text-white' }}">
                <i class="fas fa-chart-line text-[11px]"></i>
                <span>Alur Dampak Transmisi (Objective &rarr; COA &rarr; Rasio)</span>
            </button>

            <button wire:click="setTab('table')" type="button" 
                    class="pb-3 font-semibold transition-colors whitespace-nowrap cursor-pointer flex items-center gap-1.5 {{ $activeTab === 'table' ? 'border-b-2 border-[#166534] dark:border-emerald-500 text-[#166534] dark:text-emerald-400 font-bold' : 'text-gray-500 hover:text-gray-800 dark:text-slate-400 dark:hover:text-white' }}">
                <i class="fas fa-table-list text-[11px]"></i>
                <span>Tabel Perubahan (&Delta;)</span>
            </button>

            <button wire:click="setTab('journal')" type="button" 
                    class="pb-3 font-semibold transition-colors whitespace-nowrap cursor-pointer flex items-center gap-1.5 {{ $activeTab === 'journal' ? 'border-b-2 border-[#166534] dark:border-emerald-500 text-[#166534] dark:text-emerald-400 font-bold' : 'text-gray-500 hover:text-gray-800 dark:text-slate-400 dark:hover:text-white' }}">
                <i class="far fa-file-lines text-[11px]"></i>
                <span>Log Jurnal Transmisi LK</span>
            </button>

            <button wire:click="setTab('ledger')" type="button" 
                    class="pb-3 font-semibold transition-colors whitespace-nowrap cursor-pointer flex items-center gap-1.5 {{ $activeTab === 'ledger' ? 'border-b-2 border-[#166534] dark:border-emerald-500 text-[#166534] dark:text-emerald-400 font-bold' : 'text-gray-500 hover:text-gray-800 dark:text-slate-400 dark:hover:text-white' }}">
                <i class="fas fa-book text-[11px]"></i>
                <span>Persisten Ledger (Admin CoA)</span>
            </button>
        </div>

        <!-- Tab 1: Alur Dampak Transmisi (Objective -> COA -> Rasio) -->
        @if($activeTab === 'diagram')
            @if(!$isCalculated)
                <!-- Empty State matching reference screenshot -->
                <div class="border border-gray-200/80 dark:border-[#1F2026] rounded-2xl p-12 text-center flex flex-col items-center justify-center space-y-2.5">
                    <div class="w-12 h-12 rounded-full bg-gray-50 dark:bg-slate-900 text-gray-400 dark:text-slate-500 flex items-center justify-center text-xl mb-1">
                        <i class="fas fa-code-branch"></i>
                    </div>
                    <h4 class="text-xs font-bold text-gray-800 dark:text-slate-200">
                        Pilih KPI dan klik tombol &quot;Hitung Transmisi&quot; di atas.
                    </h4>
                    <p class="text-[11px] text-gray-400 dark:text-slate-500 max-w-md">
                        Diagram alur 3-Hop (Sasaran Mutu &rarr; Pos COA &rarr; Rasio Keuangan) akan otomatis terpetakan secara interaktif.
                    </p>
                </div>
            @else
                <!-- Active 3-Hop Transmission Flow Diagram -->
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-stretch">
                        <!-- Hop 1: Sasaran Mutu Departemen -->
                        <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-slate-900/60 border border-gray-200 dark:border-[#1F2026] space-y-2">
                            <span class="text-[10px] uppercase font-bold text-[#166534] dark:text-emerald-400 tracking-wider block">
                                HOP 1: SASARAN MUTU DEPARTEMEN
                            </span>
                            <div class="font-mono font-bold text-sm text-gray-900 dark:text-white">
                                {{ $currentKpi['code'] }}
                            </div>
                            <div class="text-xs text-gray-700 dark:text-slate-300 font-medium">
                                {{ $currentKpi['name'] }}
                            </div>
                            <div class="pt-2 border-t border-gray-200/60 dark:border-[#1F2026] text-[11px] space-y-1">
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-slate-400">Target Resmi:</span>
                                    <span class="font-mono font-bold text-gray-900 dark:text-white">{{ $currentKpi['target'] }}{{ $currentKpi['unit'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-slate-400">Simulasi Realisasi:</span>
                                    <span class="font-mono font-bold text-amber-600 dark:text-amber-400">{{ number_format($simulatedKpiValue, 1) }}{{ $currentKpi['unit'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Hop 2: Pos Laporan Keuangan (CoA) -->
                        <div class="p-4 rounded-2xl bg-indigo-50/50 dark:bg-indigo-950/30 border border-indigo-200/80 dark:border-indigo-900/50 space-y-2">
                            <span class="text-[10px] uppercase font-bold text-indigo-700 dark:text-indigo-400 tracking-wider block">
                                HOP 2: POS LAPORAN KEUANGAN (COA)
                            </span>
                            <div class="space-y-2 text-xs">
                                @foreach($currentKpi['hop2_coa'] as $coa)
                                    <div class="p-2.5 rounded-xl bg-white dark:bg-slate-900 border border-indigo-100 dark:border-indigo-900/40">
                                        <div class="font-mono font-bold text-indigo-900 dark:text-indigo-300 text-[11px]">
                                            {{ $coa['code'] }} - {{ $coa['name'] }}
                                        </div>
                                        <div class="text-[11px] font-semibold text-rose-600 dark:text-rose-400 mt-0.5">
                                            {{ $coa['effect'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Hop 3: Rasio Finansial SSOT Terdampak -->
                        <div class="p-4 rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/30 border border-emerald-200/80 dark:border-emerald-900/50 space-y-2">
                            <span class="text-[10px] uppercase font-bold text-[#166534] dark:text-emerald-400 tracking-wider block">
                                HOP 3: PERGESERAN RASIO FINANSIAL
                            </span>
                            <div class="space-y-2 text-xs">
                                @foreach($currentKpi['hop3_ratios'] as $ratio)
                                    <div class="p-2.5 rounded-xl bg-white dark:bg-slate-900 border border-emerald-100 dark:border-emerald-900/40 flex items-center justify-between gap-2">
                                        <div>
                                            <div class="font-bold text-gray-900 dark:text-white text-[11px]">
                                                {{ $ratio['code'] }} ({{ $ratio['name'] }})
                                            </div>
                                            <div class="text-[10px] font-mono text-gray-500 dark:text-slate-400">
                                                Base: {{ $ratio['baseline'] }} &rarr; Sim: {{ $ratio['simulated'] }}
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $ratio['status'] === 'Tercapai' ? 'bg-[#DCFCE7] text-[#166534]' : 'bg-[#FEF9C3] text-[#854D0E]' }}">
                                                {{ $ratio['impact'] }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <!-- Tab 2: Tabel Perubahan (Delta) -->
        @if($activeTab === 'table')
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-gray-50/70 dark:bg-slate-900/60 border-b border-gray-100 dark:border-[#1F2026] text-[10px] uppercase tracking-wider text-gray-500 dark:text-slate-400 font-bold">
                            <th class="py-3 px-4">Pos / Indikator</th>
                            <th class="py-3 px-4">Klasifikasi</th>
                            <th class="py-3 px-4 text-right">Nilai Baseline</th>
                            <th class="py-3 px-4 text-right">Nilai Simulasi</th>
                            <th class="py-3 px-4 text-right">Selisih (&Delta;)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-800/80">
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/40">
                            <td class="py-3 px-4 font-bold text-gray-900 dark:text-white">{{ $currentKpi['code'] }} - {{ $currentKpi['name'] }}</td>
                            <td class="py-3 px-4 text-gray-500 dark:text-slate-400">Sasaran Mutu (KPI)</td>
                            <td class="py-3 px-4 text-right font-mono">{{ $currentKpi['target'] }}{{ $currentKpi['unit'] }}</td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-amber-600 dark:text-amber-400">{{ number_format($simulatedKpiValue, 1) }}{{ $currentKpi['unit'] }}</td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-rose-600">-{{ number_format($currentKpi['target'] - $simulatedKpiValue, 1) }}{{ $currentKpi['unit'] }}</td>
                        </tr>
                        @foreach($currentKpi['hop3_ratios'] as $r)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/40">
                                <td class="py-3 px-4 font-bold text-gray-900 dark:text-white">{{ $r['code'] }} - {{ $r['name'] }}</td>
                                <td class="py-3 px-4 text-gray-500 dark:text-slate-400">Rasio Finansial SSOT</td>
                                <td class="py-3 px-4 text-right font-mono">{{ $r['baseline'] }}</td>
                                <td class="py-3 px-4 text-right font-mono font-bold text-gray-900 dark:text-white">{{ $r['simulated'] }}</td>
                                <td class="py-3 px-4 text-right font-mono font-bold text-amber-600">{{ $r['impact'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Tab 3: Log Jurnal Transmisi LK -->
        @if($activeTab === 'journal')
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-gray-50/70 dark:bg-slate-900/60 border-b border-gray-100 dark:border-[#1F2026] text-[10px] uppercase tracking-wider text-gray-500 dark:text-slate-400 font-bold">
                            <th class="py-3 px-4">Nama Akun CoA</th>
                            <th class="py-3 px-4 text-right">Debet</th>
                            <th class="py-3 px-4 text-right">Kredit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-800/80">
                        @foreach($currentKpi['journal'] as $j)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/40">
                                <td class="py-3 px-4 font-bold text-gray-900 dark:text-white font-mono">{{ $j['account'] }}</td>
                                <td class="py-3 px-4 text-right font-mono text-gray-800 dark:text-slate-200">{{ $j['debet'] }}</td>
                                <td class="py-3 px-4 text-right font-mono text-gray-800 dark:text-slate-200">{{ $j['kredit'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Tab 4: Persisten Ledger (Admin CoA) -->
        @if($activeTab === 'ledger')
            <div class="p-4 rounded-2xl bg-amber-50/60 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-900/50 text-xs space-y-2">
                <div class="font-bold text-amber-900 dark:text-amber-300 flex items-center gap-1.5">
                    <i class="fas fa-shield-halved"></i>
                    <span>Status Isolasi Sandbox (Non-Persisten)</span>
                </div>
                <p class="text-amber-800 dark:text-amber-400 leading-relaxed text-[11px]">
                    Seluruh perhitungan pada modul <strong>Uji Dampak Transmisi (What-If Sandbox)</strong> berjalan murni di memori (in-memory simulation). Tidak ada mutasi atau penulisan jurnal ke dalam database produksi Odoo ERP maupun tabel buku besar aktif perusahaan.
                </p>
            </div>
        @endif
    </div>
</div>

