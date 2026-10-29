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

    <!-- TOP COUNTERS & ACTIONS ROW (EXACT REPRODUCTION OF MOCKUP) -->
    <div class="flex flex-wrap items-center justify-between gap-3 bg-white p-4 rounded-2xl border border-gray-200 shadow-xs">
        
        <!-- Left Summary Counter Badges -->
        <div class="flex items-center gap-2">
            <!-- Total KPI -->
            <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold border border-gray-200">
                <i class="fas fa-chart-pie text-gray-500 text-[11px]"></i>
                <span>Total KPI: <strong>{{ $totalKpis }}</strong></span>
            </div>

            <!-- Perlu Perhatian (<100%) -->
            <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#FEF3C7] text-[#B45309] text-xs font-semibold border border-amber-200">
                <i class="fas fa-triangle-exclamation text-amber-600 text-[11px]"></i>
                <span>Perlu Perhatian (&lt;100%): <strong>{{ $issueKpis }}</strong></span>
            </div>

            <!-- Tercapai (100%) -->
            <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#DCFCE7] text-[#15803D] text-xs font-semibold border border-green-200">
                <i class="fas fa-circle-check text-green-600 text-[11px]"></i>
                <span>Tercapai (100%): <strong>{{ $successKpis }}</strong></span>
            </div>
        </div>

        <!-- Right Quick Action Buttons -->
        <div class="flex items-center gap-2">
            <!-- Mode Fokus Toggle Button -->
            <button type="button" 
                    wire:click="toggleFocusMode"
                    class="flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold transition-all shadow-xs {{ $focusMode ? 'bg-[#166534] text-white hover:bg-[#14532D]' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                <i class="far fa-eye text-xs"></i>
                <span>Mode Fokus: {{ $focusMode ? 'Sembunyikan KPI 100%' : 'Tampilkan Semua KPI' }}</span>
            </button>

            <!-- Tutup / Buka Semua Unit Accordion Button -->
            <button type="button" 
                    wire:click="toggleAllAccordions"
                    class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-xs font-medium text-gray-700 transition-colors">
                {{ count($openAccordions) > 0 ? 'Tutup Semua Unit' : 'Buka Semua Unit' }}
            </button>

            <!-- Reset Filter Button -->
            <button type="button" 
                    wire:click="resetFilter"
                    class="px-2.5 py-1.5 rounded-lg border border-amber-200 bg-amber-50 hover:bg-amber-100 text-xs font-medium text-amber-800 transition-colors"
                    title="Reset Filter Karyawan">
                <i class="fas fa-bolt mr-1 text-amber-600"></i> Reset Filter
            </button>

            <!-- Download Button -->
            <button type="button" 
                    wire:click="exportReport"
                    class="px-2.5 py-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-xs font-medium text-gray-700 transition-colors"
                    title="Unduh Laporan Departemen">
                <i class="fas fa-download mr-1 text-gray-500"></i> Unduh
            </button>
        </div>
    </div>

    <!-- LIST KARTU AKORDEON DEPARTEMEN (9 DEPARTEMEN OPERASIONAL) -->
    <div class="space-y-4">
        @foreach($departmentsMeta as $deptCode => $dept)
            @php
                $isOpen = in_array($deptCode, $openAccordions);
                $isIssue = $dept['has_issues'];
                $isRevealed = in_array($deptCode, $showHiddenKpis);
            @endphp

            <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden transition-all duration-150">
                
                <!-- HEADER AKORDEON KARTU DEPARTEMEN -->
                <div wire:click="toggleAccordion('{{ $deptCode }}')" 
                     class="px-5 py-4 flex items-center justify-between cursor-pointer hover:bg-gray-50/50 transition-colors select-none">
                    
                    <div class="flex items-center gap-3.5">
                        <!-- Squircle Icon Dept -->
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs shrink-0 {{ $isIssue ? 'bg-rose-50 text-[#DC2626] border border-rose-100' : 'bg-green-50 text-[#166534] border border-green-100' }}">
                            <i class="fas {{ $dept['icon'] }}"></i>
                        </div>

                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-gray-900">{{ $dept['name'] }}</h3>
                                <!-- Status Badge PIC -->
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold {{ $isIssue ? 'bg-rose-50 text-[#DC2626] border border-rose-200' : 'bg-green-50 text-[#166534] border border-green-200' }}">
                                    {{ $dept['pic_badge'] }}
                                </span>
                            </div>
                            <p class="text-[11px] text-gray-500 mt-0.5">{{ $dept['perspective'] }}</p>
                        </div>
                    </div>

                    <!-- Right Score & Accordion Arrow -->
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <span class="text-base font-extrabold block leading-tight {{ $isIssue ? 'text-[#DC2626]' : 'text-[#166534]' }}">
                                {{ number_format($dept['score'], 2) }}%
                            </span>
                            <span class="text-[10px] text-gray-400 font-mono">Skor Unit: <strong class="text-gray-600">({{ $dept['weight'] }})</strong></span>
                        </div>

                        <!-- Status Pill Tag -->
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $isIssue ? 'bg-rose-50 text-[#DC2626] border border-rose-200' : 'bg-green-50 text-[#166534] border border-green-200' }}">
                            {{ $dept['status'] }}
                        </span>

                        <!-- Accordion Chevron Arrow -->
                        <div class="w-6 h-6 rounded-full bg-gray-50 flex items-center justify-center text-gray-400">
                            <i class="fas text-xs transition-transform duration-200" :class="{{ $isOpen ? "'fa-chevron-up'" : "'fa-chevron-down'" }}"></i>
                        </div>
                    </div>
                </div>

                <!-- BODY AKORDEON: JIKA DIBUKA -->
                @if($isOpen)
                    <div class="border-t border-gray-100 bg-white">
                        
                        <!-- KONDISI A: JIKA DEPARTEMEN MEMILIKI KPI BERMASALAH (EXPANDED KPI TABLE) -->
                        @if($isIssue && count($dept['items']) > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse text-xs">
                                    <thead>
                                        <tr class="bg-gray-50/75 border-b border-gray-100 text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                                            <th class="py-2.5 px-5">KODE &amp; NAMA KPI</th>
                                            <th class="py-2.5 px-4">JEMBATAN ALUR</th>
                                            <th class="py-2.5 px-3 text-center">BOBOT</th>
                                            <th class="py-2.5 px-3 text-center">TARGET</th>
                                            <th class="py-2.5 px-4 text-center">REALISASI AKTUAL</th>
                                            <th class="py-2.5 px-4 text-center w-36">PENCAPAIAN</th>
                                            <th class="py-2.5 px-4 text-right">STATUS &amp; TRACE</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($dept['items'] as $item)
                                            <tr class="hover:bg-gray-50/60 transition-colors">
                                                <!-- Kode & Nama KPI -->
                                                <td class="py-3 px-5">
                                                    <div class="flex items-start gap-2">
                                                        <span class="px-1.5 py-0.5 rounded bg-green-50 text-green-700 border border-green-200 font-mono font-bold text-[10px] shrink-0 mt-0.5">
                                                            {{ $item['code'] }}
                                                        </span>
                                                        <div>
                                                            <span class="font-bold text-gray-900 block leading-snug">{{ $item['name'] }}</span>
                                                            <span class="text-[10px] text-gray-400 block mt-0.5">{{ $item['subtext'] }}</span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- Jembatan Alur -->
                                                <td class="py-3 px-4">
                                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                                        {{ $item['bridge'] }}
                                                    </span>
                                                </td>

                                                <!-- Bobot -->
                                                <td class="py-3 px-3 text-center font-semibold text-gray-700">
                                                    {{ $item['weight'] }}
                                                </td>

                                                <!-- Target -->
                                                <td class="py-3 px-3 text-center font-mono font-medium text-gray-800">
                                                    {{ $item['target'] }}
                                                </td>

                                                <!-- Realisasi Aktual -->
                                                <td class="py-3 px-4 text-center">
                                                    <div class="inline-flex flex-col items-center">
                                                        <div class="flex items-center gap-1 font-mono font-bold text-gray-900">
                                                            <span>{{ $item['actual'] }}</span>
                                                            <span class="text-[9px] px-1 rounded bg-green-100 text-green-800 font-bold">
                                                                {{ $item['actual_badge'] }}
                                                            </span>
                                                        </div>
                                                        <span class="text-[9px] text-gray-400">{{ $item['actual_note'] }}</span>
                                                    </div>
                                                </td>

                                                <!-- Pencapaian Progress Bar -->
                                                <td class="py-3 px-4 text-center">
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                                                            <div class="h-full rounded-full {{ $item['achievement'] >= 80 ? 'bg-amber-500' : 'bg-red-500' }}" 
                                                                 style="width: {{ min(100, $item['achievement']) }}%;"></div>
                                                        </div>
                                                        <span class="text-xs font-mono font-bold shrink-0 {{ $item['achievement'] >= 80 ? 'text-amber-700' : 'text-red-700' }}">
                                                            {{ number_format($item['achievement'], 1) }}%
                                                        </span>
                                                    </div>
                                                </td>

                                                <!-- Status & Trace Button -->
                                                <td class="py-3 px-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-[#DC2626] border border-rose-200">
                                                            {{ $item['status'] }}
                                                        </span>
                                                        <button type="button" 
                                                                wire:click="openTraceModal('{{ $item['code'] }}')"
                                                                class="px-2 py-1 rounded-md border border-green-600/30 text-[#166534] hover:bg-green-50 text-[10px] font-bold flex items-center gap-1 transition-colors">
                                                            <i class="fas fa-bolt text-[9px]"></i>
                                                            <span>Trace</span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Footer Akordeon: Opsi Menampilkan KPI 100% yang Disembunyikan -->
                            <div class="p-3 bg-gray-50/70 border-t border-gray-100 flex items-center justify-between text-xs">
                                <span class="text-gray-500 text-[11px] flex items-center gap-1.5">
                                    <i class="far fa-eye-slash text-gray-400"></i>
                                    <span>{{ $dept['hidden_count'] }} KPI Tercapai (100%) disembunyikan dalam Mode Fokus</span>
                                </span>
                                <button type="button" 
                                        wire:click="toggleShowHiddenKpis('{{ $deptCode }}')"
                                        class="px-3 py-1 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-[11px] font-semibold text-gray-700 transition-colors">
                                    {{ $isRevealed ? 'Sembunyikan Kembali' : 'Tampilkan ' . $dept['hidden_count'] . ' KPI 100% ▼' }}
                                </button>
                            </div>

                        <!-- KONDISI B: JIKA SELURUH KPI DI DEPARTEMEN TELAH TERCAPAI 100% (COLLAPSED SUMMARY STATE) -->
                        @else
                            <div class="p-6 text-center bg-green-50/20">
                                <div class="w-10 h-10 rounded-full bg-[#DCFCE7] text-[#166534] flex items-center justify-center mx-auto mb-2.5 text-base shadow-xs">
                                    <i class="fas fa-circle-check"></i>
                                </div>
                                <h4 class="text-xs font-bold text-gray-900 mb-0.5">
                                    Semua {{ $dept['hidden_count'] }} Sasaran Mutu pada Departemen ini Telah Tercapai (100%)
                                </h4>
                                <p class="text-[11px] text-gray-500 mb-3">
                                    Tidak ada KPI bermasalah (&lt;100%). Seluruh target operasional berjalan optimal.
                                </p>
                                <button type="button" 
                                        class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-xs font-semibold text-gray-700 shadow-xs transition-colors">
                                    Tampilkan Rincian {{ $dept['hidden_count'] }} KPI Tercapai ▼
                                </button>
                            </div>
                        @endif

                    </div>
                @endif

            </div>
        @endforeach
    </div>

    <!-- STICKY BOTTOM BAR AUDIT REAL-TIME ODOO ERP & HRIS SSOT -->
    <div class="rounded-xl bg-[#F0FDF4] border border-[#BBF7D0] p-3.5 flex flex-wrap items-center justify-between gap-3 text-xs shadow-xs">
        <div class="flex items-center gap-2.5 text-gray-700">
            <i class="fas fa-shield-halved text-[#10B981] text-sm"></i>
            <span>
                Seluruh data Realisasi Aktual dan Skor Sasaran Mutu disinkronkan otomatis dari <strong>HRIS System &amp; Odoo ERP SSOT</strong> — terlindungi dengan verifikasi audit kriptografis.
            </span>
        </div>

        <div class="flex items-center gap-2">
            <span class="px-2.5 py-1 rounded-full bg-white text-[#166534] border border-green-200 text-[10px] font-bold font-mono">
                ✓ READ ONLY - HRIS SSOT
            </span>
            <button type="button" 
                    wire:click="validateAll"
                    class="px-3.5 py-1 rounded-full bg-[#166534] hover:bg-[#14532D] text-white text-[11px] font-bold shadow-xs transition-colors">
                VALIDASI ULANG SEMUA
            </button>
        </div>
    </div>

    <!-- TRACE AUDIT MODAL -->
    @if($traceModalKpi)
        <div class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm animate-in fade-in duration-150"
             wire:click.self="closeTraceModal">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-gray-100 text-left">
                <div class="flex items-start justify-between pb-3 border-b border-gray-100 mb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-green-50 text-[#166534] flex items-center justify-center text-xs">
                            <i class="fas fa-bolt"></i>
                        </span>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Jejak Audit Kausalitas SSOT</h3>
                            <span class="text-xs font-mono text-gray-400">{{ $traceModalKpi['code'] }}</span>
                        </div>
                    </div>
                    <button type="button" wire:click="closeTraceModal" class="text-gray-400 hover:text-gray-600 p-1">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                <div class="space-y-2.5 text-xs">
                    <p class="font-bold text-gray-800">{{ $traceModalKpi['name'] }}</p>
                    <div class="p-3 bg-gray-50 rounded-xl space-y-1.5 font-mono text-[11px]">
                        <div><span class="text-gray-400">Jembatan Alur:</span> <strong class="text-blue-700">{{ $traceModalKpi['bridge'] }}</strong></div>
                        <div><span class="text-gray-400">Dokumen Sumber:</span> <strong class="text-gray-900">{{ $traceModalKpi['source_doc'] }}</strong></div>
                        <div><span class="text-gray-400">Audit Hash:</span> <span class="text-gray-500">{{ $traceModalKpi['hash'] }}</span></div>
                    </div>
                </div>

                <div class="pt-4 mt-4 border-t border-gray-100 text-right">
                    <button type="button" wire:click="closeTraceModal" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-700">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
