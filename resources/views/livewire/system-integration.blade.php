<div class="space-y-6">
    <!-- Header Banner -->
    <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center text-xl shadow-xs">
                <i class="fas fa-network-wired"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded bg-indigo-100 text-indigo-700">GATEWAY INBOUND</span>
                    <h2 class="text-base font-bold text-gray-900">Integrasi Sistem &amp; Gateway Inbound (Hop 4)</h2>
                </div>
                <p class="text-xs text-gray-500 mt-0.5">
                    Konsolidasi data transaksi lintas ERP Odoo (Finance) &amp; HRIS Mutu ke dalam Single Source of Truth (SSOT).
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('staging-logs') }}" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-700 transition-colors">
                <i class="fas fa-clock-rotate-left mr-1.5 text-gray-400"></i> Audit &amp; Staging Logs
            </a>
        </div>
    </div>

    <!-- FLASH MESSAGES -->
    @if(session()->has('message'))
        <div class="rounded-xl bg-green-50 border border-green-200 p-3.5 text-xs text-green-800 flex items-center gap-2">
            <i class="fas fa-check-circle text-green-600"></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- PIPELINE INTEGRASI 4-HOP BANNER -->
    <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs">
        <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
            <i class="fas fa-diagram-project text-[#166534]"></i>
            <span>Rantai Integrasi 4-Hop Enterprise Herbatech</span>
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
            <!-- Hop 1 -->
            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-200 text-center">
                <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded bg-gray-200 text-gray-700">Hop 1</span>
                <h4 class="font-bold text-xs text-gray-900 mt-2 flex items-center justify-center gap-1.5">
                    <i class="fas fa-database text-blue-600"></i> Odoo ERP
                </h4>
                <p class="text-[11px] text-gray-500 mt-1">Pencatatan Transaksi &amp; CoA</p>
                <div class="mt-2.5">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#DCFCE7] text-[#166534] text-[10px] font-bold">
                        <i class="fas fa-link text-[8px]"></i> Connected
                    </span>
                </div>
            </div>

            <!-- Hop 2 -->
            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-200 text-center">
                <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded bg-gray-200 text-gray-700">Hop 2</span>
                <h4 class="font-bold text-xs text-gray-900 mt-2 flex items-center justify-center gap-1.5">
                    <i class="fas fa-calculator text-amber-600"></i> Finance Monitoring
                </h4>
                <p class="text-[11px] text-gray-500 mt-1">Hitung &amp; Setujui Rasio</p>
                <div class="mt-2.5">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#DCFCE7] text-[#166534] text-[10px] font-bold">
                        <i class="fas fa-link text-[8px]"></i> Connected
                    </span>
                </div>
            </div>

            <!-- Hop 3 -->
            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-200 text-center">
                <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded bg-gray-200 text-gray-700">Hop 3</span>
                <h4 class="font-bold text-xs text-gray-900 mt-2 flex items-center justify-center gap-1.5">
                    <i class="fas fa-user-check text-purple-600"></i> HRIS Mutu
                </h4>
                <p class="text-[11px] text-gray-500 mt-1">Audit 35 Sasaran Mutu</p>
                <div class="mt-2.5">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#DCFCE7] text-[#166534] text-[10px] font-bold">
                        <i class="fas fa-link text-[8px]"></i> Connected
                    </span>
                </div>
            </div>

            <!-- Hop 4 -->
            <div class="p-4 rounded-2xl bg-[#DCFCE7] border border-green-300 text-center shadow-xs">
                <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded bg-[#166534] text-white">Hop 4 (Tujuan)</span>
                <h4 class="font-bold text-xs text-[#166534] mt-2 flex items-center justify-center gap-1.5">
                    <i class="fas fa-chart-line"></i> Super Apps BSC
                </h4>
                <p class="text-[11px] text-[#166534]/80 mt-1">Konsolidasi &amp; Lineage Score</p>
                <div class="mt-2.5">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-white text-[#166534] text-[10px] font-bold border border-green-200 shadow-xs">
                        <i class="fas fa-circle-check text-[9px] text-[#166534]"></i> Active SSOT
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- WADAH PENERIMAAN DATA FINANCE ERP -->
    <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs space-y-5">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div>
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fas fa-file-invoice-dollar text-[#166534]"></i>
                    <span>Wadah Penerimaan Data Finance ERP (Odoo CoA Receiver &amp; Financial Staging)</span>
                </h3>
            </div>
            <span class="px-2.5 py-0.5 rounded-full bg-[#DCFCE7] text-[#166534] text-[10px] font-bold">
                Status Endpoint: ONLINE
            </span>
        </div>

        <!-- 4 Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-200/60">
                <span class="text-[10px] font-mono font-bold text-blue-700 block uppercase">4101 · Penjualan</span>
                <span class="text-base font-extrabold text-blue-900 font-mono">Rp {{ number_format($salesPayload) }} JT</span>
                <p class="text-[10px] text-blue-600 mt-0.5">Pendapatan Operasional</p>
            </div>
            <div class="p-4 rounded-2xl bg-red-50/60 border border-red-200/60">
                <span class="text-[10px] font-mono font-bold text-red-700 block uppercase">5101 · HPP</span>
                <span class="text-base font-extrabold text-red-900 font-mono">Rp {{ number_format($hppPayload) }} JT</span>
                <p class="text-[10px] text-red-600 mt-0.5">Beban Pokok Penjualan</p>
            </div>
            <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-200/60">
                <span class="text-[10px] font-mono font-bold text-amber-700 block uppercase">6101 · Beban Opex</span>
                <span class="text-base font-extrabold text-amber-900 font-mono">Rp {{ number_format($opexPayload) }} JT</span>
                <p class="text-[10px] text-amber-600 mt-0.5">Beban Operasional &amp; Distribusi</p>
            </div>
            <div class="p-4 rounded-2xl bg-[#DCFCE7]/70 border border-green-300">
                <span class="text-[10px] font-mono font-bold text-[#166534] block uppercase">Laba Bersih Operasional</span>
                <span class="text-base font-extrabold text-[#166534] font-mono">Rp {{ number_format($netProfitCalculated) }} JT</span>
                <p class="text-[10px] text-green-700 mt-0.5">Penjualan - HPP - Opex</p>
            </div>
        </div>

        <!-- Form Simulasi Receiver Data Finance -->
        <form wire:submit.prevent="processFinancePayload" class="p-5 rounded-2xl bg-gray-50/80 border border-gray-200 space-y-4 text-xs">
            <h4 class="font-bold text-gray-800 text-[11px] flex items-center gap-1.5">
                <i class="fas fa-edit text-[#166534]"></i> Form Pembaruan Saldo Transaksi CoA Finance
            </h4>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div>
                    <label class="block font-bold text-gray-700 mb-1 text-[11px]">Periode Laporan</label>
                    <input type="text" wire:model="financePeriod" class="w-full px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-mono font-bold">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-1 text-[11px]">4101 · Penjualan (JT)</label>
                    <input type="number" step="100" wire:model="salesPayload" class="w-full px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-mono font-bold text-blue-700">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-1 text-[11px]">5101 · HPP (JT)</label>
                    <input type="number" step="100" wire:model="hppPayload" class="w-full px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-mono font-bold text-red-700">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-1 text-[11px]">6101 · Beban Operasional (JT)</label>
                    <input type="number" step="100" wire:model="opexPayload" class="w-full px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-mono font-bold text-amber-700">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div>
                    <label class="block font-bold text-gray-700 mb-1 text-[11px]">1101 · Kas &amp; Bank (JT)</label>
                    <input type="number" step="100" wire:model="kasPayload" class="w-full px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-mono">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-1 text-[11px]">1201 · Piutang Usaha (JT)</label>
                    <input type="number" step="100" wire:model="piutangPayload" class="w-full px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-mono">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-1 text-[11px]">1301 · Persediaan (JT)</label>
                    <input type="number" step="100" wire:model="persediaanPayload" class="w-full px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-mono">
                </div>
                <div>
                    <label class="block font-bold text-gray-700 mb-1 text-[11px]">2101 · Hutang Usaha (JT)</label>
                    <input type="number" step="100" wire:model="hutangPayload" class="w-full px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-mono">
                </div>
            </div>

            <div class="text-right pt-2">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#166534] hover:bg-[#14532D] text-white text-xs font-bold transition-all shadow-xs inline-flex items-center gap-1.5">
                    <i class="fas fa-arrows-rotate text-xs"></i>
                    <span>Terima &amp; Sinkronkan Data Finance ERP</span>
                </button>
            </div>
        </form>
    </div>

    <!-- API CONFIGURATION & SIMULATORS (2 COLUMNS) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- API Inbound Settings -->
        <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs space-y-4">
            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                <i class="fas fa-key text-gray-400"></i>
                <span>Pengaturan API Gateway Inbound</span>
            </h3>

            <div class="space-y-3 text-xs">
                <div>
                    <label class="block font-bold text-gray-700 mb-1 text-[11px]">Endpoint Inbound (POST):</label>
                    <div class="flex items-center gap-2">
                        <input type="text" class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-xs font-mono" value="{{ $inboundEndpoint }}" readonly>
                        <button type="button" onclick="navigator.clipboard.writeText('{{ $inboundEndpoint }}')" class="px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-bold text-gray-700 shrink-0">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1 text-[11px]">Secret API Key (Header `X-BSC-API-KEY`):</label>
                    <div class="flex items-center gap-2">
                        <input type="text" class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-xs font-mono" value="{{ $apiKey }}" readonly>
                        <button wire:click="generateApiKey" class="px-3 py-2 rounded-xl bg-amber-100 hover:bg-amber-200 text-amber-800 text-xs font-bold shrink-0">
                            <i class="fas fa-arrows-rotate mr-1"></i> Baru
                        </button>
                    </div>
                </div>

                <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-200 text-[11px] text-gray-600 leading-relaxed">
                    <i class="fas fa-shield-halved text-[#166534] mr-1"></i>
                    Semua payload masuk diwajibkan menyertakan header <code>X-BSC-API-KEY</code> dan parameter <code>idempotency_key</code> untuk mencegah duplikasi.
                </div>
            </div>
        </div>

        <!-- Simulator Payload Inbound HRIS -->
        <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs space-y-4">
            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                <i class="fas fa-vial text-gray-400"></i>
                <span>Simulator Pengiriman Payload HRIS / Unit</span>
            </h3>

            <form wire:submit.prevent="processManualPayload" class="space-y-3 text-xs">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1 text-[11px]">Dept Pengirim</label>
                        <input type="text" wire:model="deptPayload" class="w-full px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-mono uppercase" placeholder="PROD / QC / HRD">
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 mb-1 text-[11px]">Kode KPI Acuan</label>
                        <input type="text" wire:model="kpiCodePayload" class="w-full px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-mono uppercase" placeholder="FAT-01">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1 text-[11px]">Target Disepakati</label>
                        <input type="number" step="0.01" wire:model="targetPayload" class="w-full px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-mono">
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 mb-1 text-[11px]">Realisasi Aktual</label>
                        <input type="number" step="0.01" wire:model="actualPayload" class="w-full px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-mono">
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 rounded-xl bg-[#166534] hover:bg-[#14532D] text-white text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-1.5">
                    <i class="fas fa-paper-plane text-xs"></i>
                    <span>Kirim Uji Coba Payload Inbound</span>
                </button>
            </form>
        </div>
    </div>
</div>
