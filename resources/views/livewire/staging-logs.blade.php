<div class="space-y-6">
    <!-- Header Banner -->
    <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-700 flex items-center justify-center text-xl shadow-xs">
                <i class="fas fa-clock-rotate-left"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded bg-cyan-100 text-cyan-700">AUDIT LOG</span>
                    <h2 class="text-base font-bold text-gray-900">Staging &amp; Audit Log Integrasi Hop 4</h2>
                </div>
                <p class="text-xs text-gray-500 mt-0.5">
                    Rekonsiliasi transaksi, verifikasi hash idempotency, dan audit trail data payload sebelum skoring piramida.
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('system-integration') }}" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-700 transition-colors">
                <i class="fas fa-network-wired mr-1.5 text-gray-400"></i> Pengaturan Gateway Inbound
            </a>
        </div>
    </div>

    <!-- FLASH MESSAGES -->
    @if(session()->has('message'))
        <div class="rounded-xl bg-cyan-50 border border-cyan-200 p-3.5 text-xs text-cyan-800 flex items-center gap-2">
            <i class="fas fa-info-circle text-cyan-600"></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- TELEMETRY & RECONCILIATION SUMMARY (4 CARDS) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="p-4 rounded-2xl bg-white border border-gray-200 shadow-xs">
            <span class="text-[10px] font-bold text-gray-400 block uppercase tracking-wider">Control Total Match</span>
            <span class="text-base font-extrabold text-gray-900 font-mono mt-1 block">{{ $reconciliationMetrics['control_total'] }}</span>
            <span class="text-[11px] text-[#166534] font-medium mt-1 flex items-center gap-1">
                <i class="fas fa-check-circle text-[10px]"></i> 100% Cocok SSOT
            </span>
        </div>
        <div class="p-4 rounded-2xl bg-white border border-gray-200 shadow-xs">
            <span class="text-[10px] font-bold text-gray-400 block uppercase tracking-wider">Integritas Hash (Idempotency)</span>
            <span class="text-base font-extrabold text-gray-900 font-mono mt-1 block">{{ $reconciliationMetrics['hash_integrity'] }}</span>
            <span class="text-[11px] text-cyan-700 font-medium mt-1 flex items-center gap-1">
                <i class="fas fa-shield-check text-[10px]"></i> Zero Collision
            </span>
        </div>
        <div class="p-4 rounded-2xl bg-white border border-gray-200 shadow-xs">
            <span class="text-[10px] font-bold text-gray-400 block uppercase tracking-wider">Kelengkapan Data Periode</span>
            <span class="text-base font-extrabold text-gray-900 font-mono mt-1 block">{{ $reconciliationMetrics['completeness'] }}</span>
            <span class="text-[11px] text-blue-700 font-medium mt-1 flex items-center gap-1">
                <i class="fas fa-layer-group text-[10px]"></i> 35 KPI Lengkap
            </span>
        </div>
        <div class="p-4 rounded-2xl bg-white border border-gray-200 shadow-xs">
            <span class="text-[10px] font-bold text-gray-400 block uppercase tracking-wider">Kesegaran Data (26 Jam)</span>
            <span class="text-base font-extrabold text-gray-900 font-mono mt-1 block">{{ $reconciliationMetrics['freshness'] }}</span>
            <span class="text-[11px] text-[#166534] font-medium mt-1 flex items-center gap-1">
                <i class="fas fa-bolt text-[10px]"></i> SLA Terpenuhi
            </span>
        </div>
    </div>

    <!-- MAIN 2 COLUMNS: SIMULASI & LOG TABLE -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- SIMULASI INBOUND (col-span-4) -->
        <div class="lg:col-span-4 bg-white rounded-3xl border border-gray-200 p-6 shadow-xs space-y-4">
            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                <i class="fas fa-paper-plane text-cyan-600"></i>
                <span>Simulasi Inbound API (Hop 3 &rarr; Hop 4)</span>
            </h3>

            <p class="text-xs text-gray-500 leading-relaxed">
                Mengirimkan skor objective baru secara otomatis dari HRIS/Finance ERP ke Hop 4 dengan <code>idempotency_key</code> unik.
            </p>

            <div class="space-y-3 text-xs">
                <div>
                    <label class="block font-bold text-gray-700 mb-1 text-[11px]">Pilih Departemen Pengirim</label>
                    <select wire:model="simulatedDept" class="w-full px-3 py-2 rounded-xl border border-gray-200 text-xs font-semibold text-gray-800 bg-white">
                        <option value="PROD">PROD - Produksi</option>
                        <option value="QC">QC - Quality Control</option>
                        <option value="FIN">FIN - Keuangan &amp; Akuntansi</option>
                        <option value="HRD">HRD - Human Resources</option>
                        <option value="MKT">MKT - Pemasaran</option>
                    </select>
                </div>

                <button wire:click="simulateInbound" class="w-full py-2.5 rounded-xl bg-cyan-700 hover:bg-cyan-800 text-white text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-1.5">
                    <i class="fas fa-satellite-dish text-xs"></i>
                    <span>Kirim Payload Simulasi</span>
                </button>
            </div>
        </div>

        <!-- RIWAYAT LOG TABLE (col-span-8) -->
        <div class="lg:col-span-8 bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-xs">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fas fa-list-check text-gray-400"></i>
                    <span>Riwayat Staging &amp; Audit Log</span>
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-gray-50/70 border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                            <th class="py-3 px-4">Periode</th>
                            <th class="py-3 px-4">Dept</th>
                            <th class="py-3 px-4">Idempotency Key</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Versi</th>
                            <th class="py-3 px-4">Pesan Log</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3.5 px-4 font-mono text-gray-600 text-[11px]">
                                    {{ $log->period }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2 py-0.5 rounded bg-gray-100 font-mono font-bold text-[10px] text-gray-700">
                                        {{ $log->dept_code }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-[11px] text-gray-600">
                                    {{ Str::limit($log->idempotency_key, 22) }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    @if($log->status === 'SCORED')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#DCFCE7] text-[#166534] font-bold text-[10px]">
                                            <i class="fas fa-check-double text-[9px]"></i> SCORED
                                        </span>
                                    @elseif($log->status === 'DELIVERED')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 font-bold text-[10px]">
                                            <i class="fas fa-inbox text-[9px]"></i> DELIVERED
                                        </span>
                                    @elseif($log->status === 'SUPERSEDED')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-600 font-bold text-[10px]">
                                            <i class="fas fa-history text-[9px]"></i> SUPERSEDED
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-red-100 text-red-700 font-bold text-[10px]">
                                            <i class="fas fa-triangle-exclamation text-[9px]"></i> ERROR
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center font-mono font-bold text-gray-800">
                                    v{{ $log->source_version }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-500 text-[11px]">
                                    {{ $log->message }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-400 py-8 italic">
                                    Belum ada riwayat staging log.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
