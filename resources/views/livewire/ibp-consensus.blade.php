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

    <!-- Top Workflow Stepper Hero Card -->
    <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 sm:p-6 shadow-xs space-y-4 transition-colors duration-200">
        <!-- Top Row: Badge, Title, Simulation Status, and Full View Toggle -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3 flex-wrap">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/50">
                    PERENCANAAN
                </span>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">
                    Simulasi IBP &rarr; BSC
                </h2>
                <div class="flex items-center gap-2">
                    @if(!$isTransmitted)
                        <span class="inline-flex items-center gap-1.5 text-xs text-amber-600 dark:text-amber-400 font-medium">
                            <span class="w-2 h-2 rounded-full bg-amber-500 inline-block animate-pulse"></span>
                            <span>Simulasi — belum dikirim ke BSC</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-xs text-[#166534] dark:text-emerald-400 font-bold">
                            <span class="w-2 h-2 rounded-full bg-[#166534] dark:bg-emerald-400 inline-block"></span>
                            <span>✓ Terkirim ke BSC — Target Revenue Aktif (Rp 59.200 JT)</span>
                        </span>
                    @endif
                </div>
            </div>

            <div>
                <button wire:click="toggleShowAllSteps" type="button" 
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-gray-50 dark:hover:bg-slate-800 text-gray-700 dark:text-slate-300 text-xs font-semibold shadow-xs transition-colors cursor-pointer">
                    <i class="far {{ $showAllSteps ? 'fa-list-check' : 'fa-eye' }} text-gray-400 dark:text-slate-500 text-xs"></i>
                    <span>{{ $showAllSteps ? 'Tampilan Bertahap (Step by Step)' : 'Tampilkan Semua Langkah (Full View)' }}</span>
                </button>
            </div>
        </div>

        <!-- Description Paragraph -->
        <p class="text-xs text-gray-500 dark:text-slate-400 leading-relaxed max-w-4xl">
            Simulasi siklus <strong>Integrated Business Planning</strong> bulanan. Konsensus demand yang lolos batasan kapasitas dikirim sebagai target revenue BSC — seluruh target rasio dan sasaran mutu ikut terkaskade lewat mesin yang sudah ada. Arah baliknya: aktual dan gap dari BSC menjadi masukan siklus IBP bulan berikutnya.
        </p>

        <!-- Stepper Navigation Pills (5 IBP Steps) -->
        <div class="flex items-center gap-2 flex-wrap pt-1">
            @php
                $steps = [
                    1 => 'Product Review',
                    2 => 'Demand Review',
                    3 => 'Supply Review',
                    4 => 'Rekonsiliasi Finansial',
                    5 => 'Management Business Review',
                ];
            @endphp

            @foreach($steps as $stepNum => $stepLabel)
                @php
                    $isActive = $currentStep === $stepNum;
                @endphp
                <button wire:click="setStep({{ $stepNum }})" type="button" 
                        class="inline-flex items-center px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shadow-xs cursor-pointer border {{ $isActive ? 'bg-[#166534] text-white border-[#166534]' : 'bg-white dark:bg-slate-900 border-gray-200 dark:border-slate-700 text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-800' }}">
                    <span class="w-4 h-4 rounded-full text-[10px] inline-flex items-center justify-center mr-1.5 {{ $isActive ? 'bg-white text-[#166534]' : 'bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-slate-400' }}">
                        {{ $stepNum }}
                    </span>
                    <span>{{ $stepLabel }}</span>
                </button>
            @endforeach
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- STEP 1: PRODUCT REVIEW — PORTOFOLIO SKU & PIPELINE LAUNCH PRODUK BARU     -->
    <!-- ========================================================================= -->
    @if($showAllSteps || $currentStep === 1)
        <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 sm:p-6 shadow-xs space-y-4 transition-colors duration-200">
            <!-- Step Header -->
            <div class="flex items-center justify-between gap-4 border-b border-gray-100 dark:border-slate-800 pb-3 flex-wrap">
                <div class="flex items-center gap-2.5">
                    <div class="w-6 h-6 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 flex items-center justify-center text-xs">
                        <i class="fas fa-box-archive"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">
                        1 - PRODUCT REVIEW — PORTOFOLIO SKU & PIPELINE LAUNCH PRODUK BARU
                    </h3>
                </div>
                <div>
                    <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                        3 NEW SKU PIPELINE
                    </span>
                </div>
            </div>

            <!-- Description -->
            <p class="text-xs text-gray-500 dark:text-slate-400 leading-relaxed">
                Evaluasi siklus hidup produk herbal/farmasi, jadwal peluncuran produk baru (NPD), dan rasionalisasi SKU non-produktif (Phase-Out) sebelum masuk ke review permintaan.
            </p>

            <!-- 3 SKU Product Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-1">
                @foreach($skus as $sku)
                    <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-800 flex flex-col justify-between space-y-3">
                        <!-- Top Row: Name & Launch Quarter -->
                        <div class="flex items-start justify-between gap-2">
                            <h4 class="font-bold text-xs text-gray-900 dark:text-white">
                                {{ $sku['name'] }}
                            </h4>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold border shrink-0 {{ $sku['launch_badge_color'] === 'green' ? 'bg-emerald-50 dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 border-green-200 dark:border-emerald-800/50' : ($sku['launch_badge_color'] === 'blue' ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-800/50' : 'bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-800/50') }}">
                                {{ $sku['launch_quarter'] }}
                            </span>
                        </div>

                        <!-- Category -->
                        <div class="text-[11px] text-gray-500 dark:text-slate-400">
                            {{ $sku['category'] }}
                        </div>

                        <!-- Bottom Row: Target Est & Status -->
                        <div class="flex items-center justify-between text-xs pt-2 border-t border-gray-200/60 dark:border-slate-800">
                            <span class="font-mono text-gray-700 dark:text-slate-300">
                                Target Est: <strong class="text-gray-900 dark:text-white">{{ $sku['target_est'] }}</strong>
                            </span>
                            <span class="font-bold {{ $sku['status_color'] === 'green' ? 'text-[#166534] dark:text-emerald-400' : ($sku['status_color'] === 'blue' ? 'text-blue-700 dark:text-blue-400' : 'text-amber-700 dark:text-amber-400') }}">
                                {{ $sku['status_label'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- STEP 2: DEMAND REVIEW — KONSENSUS PERAMALAN PERMINTAAN PASAR              -->
    <!-- ========================================================================= -->
    @if($showAllSteps || $currentStep === 2)
        <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 sm:p-6 shadow-xs space-y-4 transition-colors duration-200">
            <!-- Step Header -->
            <div class="flex items-center justify-between gap-4 border-b border-gray-100 dark:border-slate-800 pb-3 flex-wrap">
                <div class="flex items-center gap-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">
                        2 - DEMAND REVIEW — KONSENSUS PERAMALAN PERMINTAAN PASAR
                    </h3>
                </div>
                <div>
                    <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800/50">
                        UNCONSTRAINED DEMAND: Rp 62.500 JT
                    </span>
                </div>
            </div>

            <!-- Description -->
            <p class="text-xs text-gray-500 dark:text-slate-400 leading-relaxed">
                Konsolidasi proyeksi permintaan unconstrained dari Marketing, Sales Distributor, E-Commerce, dan Rumah Sakit sebelum dibatasi kapasitas pasokan.
            </p>

            <!-- Demand Channels Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-gray-50/70 dark:bg-slate-900/60 border-b border-gray-100 dark:border-slate-800 text-[10px] uppercase tracking-wider text-gray-500 dark:text-slate-400 font-bold">
                            <th class="py-3 px-4">Saluran Distribusi (Channel)</th>
                            <th class="py-3 px-4 text-right">Volume Proyeksi</th>
                            <th class="py-3 px-4 text-center">Porsi (%)</th>
                            <th class="py-3 px-4 text-center">Pertumbuhan</th>
                            <th class="py-3 px-4 text-center">Status Validasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-800/80">
                        @foreach($demandChannels as $dc)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/40">
                                <td class="py-3 px-4 font-bold text-gray-900 dark:text-white">{{ $dc['channel'] }}</td>
                                <td class="py-3 px-4 text-right font-mono font-bold text-gray-800 dark:text-slate-200">{{ $dc['volume'] }}</td>
                                <td class="py-3 px-4 text-center font-mono text-gray-600 dark:text-slate-400">{{ $dc['share'] }}</td>
                                <td class="py-3 px-4 text-center font-semibold text-[#166534] dark:text-emerald-400">{{ $dc['growth'] }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-50 dark:bg-emerald-950/50 text-[#166534] dark:text-emerald-400 border border-green-200/80 dark:border-emerald-800/50">
                                        {{ $dc['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- STEP 3: SUPPLY REVIEW — KAPASITAS PABRIK & BATASAN PASOKAN                -->
    <!-- ========================================================================= -->
    @if($showAllSteps || $currentStep === 3)
        <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 sm:p-6 shadow-xs space-y-4 transition-colors duration-200">
            <!-- Step Header -->
            <div class="flex items-center justify-between gap-4 border-b border-gray-100 dark:border-slate-800 pb-3 flex-wrap">
                <div class="flex items-center gap-2.5">
                    <div class="w-6 h-6 rounded-lg bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xs">
                        <i class="fas fa-industry"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">
                        3 - SUPPLY REVIEW — KAPASITAS PABRIK & BATASAN PASOKAN
                    </h3>
                </div>
                <div>
                    <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50">
                        CAPACITY UTILIZATION: {{ $supplyMetrics['utilization'] }}
                    </span>
                </div>
            </div>

            <!-- Description -->
            <p class="text-xs text-gray-500 dark:text-slate-400 leading-relaxed">
                Uji kelayakan pasokan pabrik farmasi, ketersediaan bahan baku simplisia herbal, utilisasi mesin ekstraksi, dan batasan kapasitas kemasan.
            </p>

            <!-- Supply Metrics Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-800">
                    <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase block mb-1">Batas Output Maksimal</span>
                    <span class="font-mono font-bold text-base text-gray-900 dark:text-white">{{ $supplyMetrics['max_capacity'] }}</span>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-800">
                    <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase block mb-1">OTD Bahan Baku Simplisia</span>
                    <span class="font-mono font-bold text-base text-[#166534] dark:text-emerald-400">{{ $supplyMetrics['raw_material_otd'] }}</span>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-800">
                    <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase block mb-1">Identifikasi Bottleneck</span>
                    <span class="font-bold text-xs text-amber-700 dark:text-amber-400">{{ $supplyMetrics['bottleneck'] }}</span>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-800">
                    <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase block mb-1">Rencana Lembur Pabrik</span>
                    <span class="font-bold text-xs text-gray-900 dark:text-white">{{ $supplyMetrics['overtime_planned'] }}</span>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- STEP 4: REKONSILIASI FINANSIAL — GAP ANALYSIS IBP TERHADAP BSC            -->
    <!-- ========================================================================= -->
    @if($showAllSteps || $currentStep === 4)
        <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 sm:p-6 shadow-xs space-y-4 transition-colors duration-200">
            <!-- Step Header -->
            <div class="flex items-center justify-between gap-4 border-b border-gray-100 dark:border-slate-800 pb-3 flex-wrap">
                <div class="flex items-center gap-2.5">
                    <div class="w-6 h-6 rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xs">
                        <i class="fas fa-scale-balanced"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">
                        4 - REKONSILIASI FINANSIAL — GAP ANALYSIS IBP TERHADAP BSC
                    </h3>
                </div>
                <div>
                    <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800/50">
                        PROJECTED REVENUE: {{ $financialReconciliation['ibp_consensus_target'] }}
                    </span>
                </div>
            </div>

            <!-- Description -->
            <p class="text-xs text-gray-500 dark:text-slate-400 leading-relaxed">
                Penyelarasan nilai konsensus operasional (Supply & Demand) dengan target finansial Apex Revenue BSC dan marjin laba korporasi.
            </p>

            <!-- Reconciliation Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-800">
                    <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase block mb-1">Target Apex BSC Saat Ini</span>
                    <span class="font-mono font-bold text-sm text-gray-900 dark:text-white">{{ $financialReconciliation['bsc_current_target'] }}</span>
                </div>
                <div class="p-4 rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/30 border border-emerald-200/80 dark:border-emerald-800/50">
                    <span class="text-[10px] font-bold text-emerald-700 dark:text-emerald-400 uppercase block mb-1">Target Konsensus IBP</span>
                    <span class="font-mono font-bold text-sm text-[#166534] dark:text-emerald-300">{{ $financialReconciliation['ibp_consensus_target'] }}</span>
                    <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold block mt-0.5">{{ $financialReconciliation['variance_uplift'] }}</span>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-800">
                    <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase block mb-1">Proyeksi Gross Profit Margin</span>
                    <span class="font-mono font-bold text-sm text-[#166534] dark:text-emerald-400">{{ $financialReconciliation['projected_gpm'] }}</span>
                    <span class="text-[10px] text-gray-500 dark:text-slate-400 block mt-0.5">Target BSC: {{ $financialReconciliation['target_gpm'] }}</span>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-800">
                    <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase block mb-1">Proyeksi Net Profit</span>
                    <span class="font-mono font-bold text-sm text-gray-900 dark:text-white">{{ $financialReconciliation['projected_net_profit'] }}</span>
                    <span class="text-[10px] text-gray-500 dark:text-slate-400 block mt-0.5">NPM: {{ $financialReconciliation['projected_npm'] }}</span>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- STEP 5: MANAGEMENT BUSINESS REVIEW — KEPUTUSAN EKSEKUTIF & TRANSMISI BSC -->
    <!-- ========================================================================= -->
    @if($showAllSteps || $currentStep === 5)
        <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 sm:p-6 shadow-xs space-y-5 transition-colors duration-200">
            <!-- Step Header -->
            <div class="flex items-center justify-between gap-4 border-b border-gray-100 dark:border-slate-800 pb-3 flex-wrap">
                <div class="flex items-center gap-2.5">
                    <div class="w-6 h-6 rounded-lg bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xs">
                        <i class="fas fa-users-viewfinder"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">
                        5 - MANAGEMENT BUSINESS REVIEW (MBR) — KEPUTUSAN EKSEKUTIF & TRANSMISI BSC
                    </h3>
                </div>
                <div>
                    <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-400 border border-purple-200 dark:border-purple-800/50">
                        STATUS: SIAP TRANSMISI
                    </span>
                </div>
            </div>

            <!-- Executive Approval Status -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($executives as $ex)
                    <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-800">
                        <div class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase mb-1">{{ $ex['role'] }}</div>
                        <div class="font-bold text-xs text-gray-900 dark:text-white mb-2">{{ $ex['name'] }}</div>
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="font-bold text-[#166534] dark:text-emerald-400 flex items-center gap-1">
                                <i class="fas fa-check-circle text-[10px]"></i>
                                <span>{{ $ex['status'] }}</span>
                            </span>
                            <span class="text-gray-400 dark:text-slate-500 font-mono">{{ $ex['time'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Action Transmit Card -->
            <div class="p-5 rounded-2xl bg-emerald-50/60 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <div class="font-bold text-sm text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-bolt text-[#166534] dark:text-emerald-400"></i>
                        <span>Kaskade Target Konsensus ke Mesin Skoring BSC</span>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-slate-400 mt-1">
                        Target Konsensus sebesar <strong>Rp 59.200 JT</strong> akan menggantikan baseline Level 1 Revenue dan mengalirkan target baru ke 19 rasio finansial serta 64 sasaran mutu departemen.
                    </p>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    @if($isTransmitted)
                        <button wire:click="resetTransmission" type="button" 
                                class="px-3 py-2 rounded-xl border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-gray-50 dark:hover:bg-slate-800 text-gray-700 dark:text-slate-300 text-xs font-semibold shadow-xs transition-colors cursor-pointer">
                            <span>Batal Transmisi (Draft)</span>
                        </button>
                    @endif
                    <button wire:click="transmitToBsc" type="button" 
                            class="px-5 py-2.5 rounded-xl bg-[#166534] hover:bg-[#14532D] active:bg-[#0f3d20] text-white text-xs font-bold shadow-xs transition-all flex items-center gap-2 cursor-pointer">
                        <i class="fas fa-paper-plane text-xs"></i>
                        <span>{{ $isTransmitted ? 'Perbarui Transmisi ke BSC' : 'Kirim Target Konsensus IBP ke BSC Hop 4' }}</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

