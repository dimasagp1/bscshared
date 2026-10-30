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

    <!-- Hero Header Banner Card -->
    <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 sm:p-6 shadow-xs flex flex-wrap items-center justify-between gap-4 transition-colors duration-200">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-[#DCFCE7] dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 border border-green-200/60 dark:border-emerald-800/50 flex items-center justify-center text-xl shadow-xs shrink-0">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">
                    Simulasi Murni CoA Sandbox (Tanpa Dampak Persisten)
                </h2>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                    Eksplorasi penyesuaian saldo akun & simulasi laba/rasio secara real-time
                </p>
            </div>
        </div>

        <div>
            <button wire:click="resetSimulation" type="button" 
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-gray-50 dark:hover:bg-slate-800 text-gray-700 dark:text-slate-300 text-xs font-semibold shadow-xs transition-colors cursor-pointer">
                <i class="fas fa-rotate-left text-xs text-gray-500 dark:text-slate-400"></i>
                <span>Reset Simulasi (Rollback)</span>
            </button>
        </div>
    </div>

    <!-- 3 Key Metric Cards (Grid 3 Columns) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Card 1: NPM Simulasi -->
        <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 shadow-xs transition-colors duration-200">
            <span class="text-xs font-bold text-gray-500 dark:text-slate-400 block">
                Net Profit Margin (NPM) Simulasi
            </span>
            <div class="font-mono font-black text-2xl sm:text-3xl text-gray-900 dark:text-white mt-1">
                {{ number_format($simNpm, 2) }}%
            </div>
            <div class="text-xs font-semibold mt-1 flex items-center gap-1 {{ $npmDiff >= 0 ? 'text-[#166534] dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                @if($npmDiff >= 0)
                    <i class="fas fa-arrow-up-right text-[10px]"></i>
                    <span>+{{ number_format($npmDiff, 2) }}% vs Base ({{ number_format($baseNpm, 2) }}%)</span>
                @else
                    <i class="fas fa-arrow-down-right text-[10px]"></i>
                    <span>{{ number_format($npmDiff, 2) }}% vs Base ({{ number_format($baseNpm, 2) }}%)</span>
                @endif
            </div>
        </div>

        <!-- Card 2: CR Simulasi -->
        <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 shadow-xs transition-colors duration-200">
            <span class="text-xs font-bold text-gray-500 dark:text-slate-400 block">
                Current Ratio (CR) Simulasi
            </span>
            <div class="font-mono font-black text-2xl sm:text-3xl text-gray-900 dark:text-white mt-1">
                {{ number_format($simCr, 2) }}x
            </div>
            <div class="text-xs font-semibold mt-1 flex items-center gap-1 {{ $crDiff >= 0 ? 'text-[#166534] dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                @if($crDiff >= 0)
                    <i class="fas fa-arrow-up-right text-[10px]"></i>
                    <span>+{{ number_format($crDiff, 2) }}x vs Base ({{ number_format($baseCr, 2) }}x)</span>
                @else
                    <i class="fas fa-arrow-down-right text-[10px]"></i>
                    <span>{{ number_format($crDiff, 2) }}x vs Base ({{ number_format($baseCr, 2) }}x)</span>
                @endif
            </div>
        </div>

        <!-- Card 3: Laba Bersih Operasional -->
        <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 shadow-xs transition-colors duration-200">
            <span class="text-xs font-bold text-gray-500 dark:text-slate-400 block">
                Laba Bersih Operasional
            </span>
            <div class="font-mono font-black text-2xl sm:text-3xl text-gray-900 dark:text-white mt-1">
                Rp {{ number_format(round($simNetProfit), 0, ',', '.') }} JT
            </div>
            <div class="inline-flex items-center gap-1.5 text-xs text-emerald-700 dark:text-emerald-400 font-medium mt-1">
                <i class="fas fa-shield-halved text-[11px]"></i>
                <span>Model Neraca & Rugi Laba Konsisten</span>
            </div>
        </div>
    </div>

    <!-- Sliders Adjustment Card: "PENYESUAIAN SANDBOX AKUN KUNCI (JUTA RUPIAH)" -->
    <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 sm:p-6 shadow-xs transition-colors duration-200">
        <div class="flex items-center justify-between gap-4 border-b border-gray-100 dark:border-slate-800 pb-4">
            <div class="flex items-center gap-2 text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">
                <i class="fas fa-sliders text-gray-400 dark:text-slate-500"></i>
                <span>PENYESUAIAN SANDBOX AKUN KUNCI (JUTA RUPIAH)</span>
            </div>
            <div class="text-xs text-gray-400 dark:text-slate-500 hidden sm:block">
                Geser slider untuk mengubah saldo akun
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-5">
            <!-- Slider 1: 1101 - Kas & Bank -->
            <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-800">
                <div class="flex items-center justify-between text-xs mb-2.5">
                    <span class="font-bold text-gray-800 dark:text-slate-200">1101 - Kas & Bank</span>
                    <span class="font-mono font-bold {{ $delta_1101 > 0 ? 'text-[#166534] dark:text-emerald-400' : ($delta_1101 < 0 ? 'text-rose-600 dark:text-rose-400' : 'text-[#166534] dark:text-emerald-400') }}">
                        {{ $delta_1101 >= 0 ? '+' : '' }}{{ number_format($delta_1101, 0, ',', '.') }} JT
                    </span>
                </div>
                <input type="range" wire:model.live="delta_1101" min="-2000" max="2000" step="50" 
                       class="w-full h-1.5 bg-gray-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer accent-[#166534] dark:accent-emerald-500">
            </div>

            <!-- Slider 2: 1102 - Piutang Usaha -->
            <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-800">
                <div class="flex items-center justify-between text-xs mb-2.5">
                    <span class="font-bold text-gray-800 dark:text-slate-200">1102 - Piutang Usaha</span>
                    <span class="font-mono font-bold {{ $delta_1102 > 0 ? 'text-[#166534] dark:text-emerald-400' : ($delta_1102 < 0 ? 'text-rose-600 dark:text-rose-400' : 'text-[#166534] dark:text-emerald-400') }}">
                        {{ $delta_1102 >= 0 ? '+' : '' }}{{ number_format($delta_1102, 0, ',', '.') }} JT
                    </span>
                </div>
                <input type="range" wire:model.live="delta_1102" min="-2000" max="2000" step="50" 
                       class="w-full h-1.5 bg-gray-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer accent-[#166534] dark:accent-emerald-500">
            </div>

            <!-- Slider 3: 4101 - Penjualan Produk -->
            <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-800">
                <div class="flex items-center justify-between text-xs mb-2.5">
                    <span class="font-bold text-gray-800 dark:text-slate-200">4101 - Penjualan Produk</span>
                    <span class="font-mono font-bold {{ $delta_4101 > 0 ? 'text-[#166534] dark:text-emerald-400' : ($delta_4101 < 0 ? 'text-rose-600 dark:text-rose-400' : 'text-[#166534] dark:text-emerald-400') }}">
                        {{ $delta_4101 >= 0 ? '+' : '' }}{{ number_format($delta_4101, 0, ',', '.') }} JT
                    </span>
                </div>
                <input type="range" wire:model.live="delta_4101" min="-300" max="500" step="10" 
                       class="w-full h-1.5 bg-gray-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer accent-[#166534] dark:accent-emerald-500">
            </div>
        </div>
    </div>

    <!-- Comparison Table Card: "PERBANDINGAN SALDO AKUN AKTUAL VS SIMULASI" -->
    <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 overflow-hidden shadow-xs transition-colors duration-200">
        <!-- Table Header Bar -->
        <div class="p-5 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2 text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">
                <i class="fas fa-link text-gray-400 dark:text-slate-500"></i>
                <span>PERBANDINGAN SALDO AKUN AKTUAL VS SIMULASI</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/70 dark:bg-slate-900/60 border-b border-gray-100 dark:border-slate-800 text-[10px] uppercase tracking-wider text-gray-500 dark:text-slate-400 font-bold">
                        <th class="py-3.5 px-5">KODE AKUN</th>
                        <th class="py-3.5 px-4">NAMA AKUN</th>
                        <th class="py-3.5 px-4">GRUP POS</th>
                        <th class="py-3.5 px-4 text-right">SALDO AKTUAL (BASE)</th>
                        <th class="py-3.5 px-4 text-right">SALDO SIMULASI</th>
                        <th class="py-3.5 px-5 text-right">SELISIH (Δ)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800/80 text-xs">
                    @foreach($tableData as $row)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/40 transition-colors">
                            <!-- Kode Akun -->
                            <td class="py-3.5 px-5 font-mono font-bold text-[#166534] dark:text-emerald-400">
                                {{ $row['code'] }}
                            </td>

                            <!-- Nama Akun -->
                            <td class="py-3.5 px-4 font-bold text-gray-900 dark:text-white">
                                {{ $row['name'] }}
                            </td>

                            <!-- Grup Pos -->
                            <td class="py-3.5 px-4 text-gray-600 dark:text-slate-400">
                                {{ $row['group'] }}
                            </td>

                            <!-- Saldo Aktual (Base) -->
                            <td class="py-3.5 px-4 text-right font-mono text-gray-700 dark:text-slate-300 whitespace-nowrap">
                                Rp {{ number_format($row['base'], 2, ',', '.') }} JT
                            </td>

                            <!-- Saldo Simulasi -->
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-gray-900 dark:text-white whitespace-nowrap">
                                Rp {{ number_format($row['simulated'], 2, ',', '.') }} JT
                            </td>

                            <!-- Selisih (Delta) -->
                            <td class="py-3.5 px-5 text-right font-mono whitespace-nowrap {{ $row['delta'] > 0 ? 'text-[#166534] dark:text-emerald-400 font-bold' : ($row['delta'] < 0 ? 'text-rose-600 dark:text-rose-400 font-bold' : 'text-gray-400 dark:text-slate-500') }}">
                                @if($row['delta'] == 0)
                                    0
                                @elseif($row['delta'] > 0)
                                    +Rp {{ number_format($row['delta'], 2, ',', '.') }} JT
                                @else
                                    -Rp {{ number_format(abs($row['delta']), 2, ',', '.') }} JT
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

