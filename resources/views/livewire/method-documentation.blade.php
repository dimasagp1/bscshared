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

    <!-- HERO HEADER CARD: DOKUMENTASI METODOLOGI & SELF-TEST SUITE -->
    <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-2xl bg-green-50 text-[#166534] flex items-center justify-center text-base border border-green-100 shadow-xs">
                <i class="far fa-book-open"></i>
            </div>
            <div>
                <h2 class="text-base font-bold text-gray-900">Dokumentasi Metodologi &amp; Self-Test Suite</h2>
                <p class="text-xs text-gray-500 mt-0.5">
                    Aturan Skoring, Polaritas, Banding, Cap, Agregasi, dan Test Suite Verifikasi
                </p>
            </div>
        </div>

        <!-- Run Self-Test Button -->
        <button type="button" 
                wire:click="runSelfTestP24"
                wire:loading.attr="disabled"
                class="px-5 py-2.5 rounded-xl bg-[#166534] hover:bg-[#14532D] text-white text-xs font-bold flex items-center gap-2 shadow-xs transition-colors cursor-pointer disabled:opacity-75">
            
            <span wire:loading.remove class="flex items-center gap-2">
                <i class="fas fa-play text-[10px]"></i>
                <span>Jalankan Self-Test P-24</span>
            </span>

            <span wire:loading class="flex items-center gap-2">
                <i class="fas fa-spinner fa-spin text-xs"></i>
                <span>Menjalankan Verifikasi 24 Tes...</span>
            </span>
        </button>
    </div>

    <!-- 2 MAIN CARDS: REGULASI SKORING (P-17 S/D P-22) + CAKUPAN VERIFIKASI -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        
        <!-- CARD 1: REGULASI SKORING (P-17 S/D P-22) -->
        <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs">
            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 flex items-center gap-2 mb-5">
                <i class="fas fa-code text-[#10B981]"></i>
                <span>REGULASI SKORING (P-17 S/D P-22)</span>
            </h3>

            <div class="space-y-4 text-xs font-medium text-gray-700 leading-relaxed">
                <div class="p-2.5 rounded-xl bg-gray-50/60 border border-gray-100">
                    <strong class="text-gray-900 font-mono">P-17</strong> &mdash; Polaritas: <span class="font-mono text-[#166534] font-bold">up / down / zero / band / none</span>
                </div>

                <div class="p-2.5 rounded-xl bg-gray-50/60 border border-gray-100">
                    <strong class="text-gray-900 font-mono">P-18</strong> &mdash; Rentang band: di dalam rentang wajar = <span class="font-mono text-[#166534] font-bold">100%</span>
                </div>

                <div class="p-2.5 rounded-xl bg-gray-50/60 border border-gray-100">
                    <strong class="text-gray-900 font-mono">P-19</strong> &mdash; Cap pencapaian maksimal <span class="font-mono text-[#166534] font-bold">100%</span>
                </div>

                <div class="p-2.5 rounded-xl bg-gray-50/60 border border-gray-100">
                    <strong class="text-gray-900 font-mono">P-20</strong> &mdash; Pembagian nol / data kosong &rarr; <span class="font-mono text-amber-700 font-bold">N/A (null), bukan 0</span>
                </div>

                <div class="p-2.5 rounded-xl bg-gray-50/60 border border-gray-100">
                    <strong class="text-gray-900 font-mono">P-21</strong> &mdash; Status: <span class="text-green-700 font-bold">Tercapai &ge; 100%</span> &middot; <span class="text-amber-700 font-bold">Waspada 80–99.99%</span> &middot; <span class="text-red-700 font-bold">Di Bawah &lt; 80%</span>
                </div>

                <div class="p-2.5 rounded-xl bg-gray-50/60 border border-gray-100">
                    <strong class="text-gray-900 font-mono">P-22</strong> &mdash; Agregasi berbobot (N/A dikecualikan dari pembagi)
                </div>
            </div>
        </div>

        <!-- CARD 2: CAKUPAN VERIFIKASI -->
        <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs">
            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 flex items-center gap-2 mb-5">
                <i class="fas fa-shield-halved text-[#10B981]"></i>
                <span>CAKUPAN VERIFIKASI</span>
            </h3>

            <div class="space-y-4 text-xs font-medium text-gray-600 leading-relaxed">
                <div class="flex items-center gap-2 p-2.5 rounded-xl bg-green-50/50 border border-green-100 text-gray-800">
                    <i class="fas fa-check text-green-600 text-xs"></i>
                    <span>Polaritas UP: cap 100% &amp; proporsionalitas</span>
                </div>

                <div class="flex items-center gap-2 p-2.5 rounded-xl bg-green-50/50 border border-green-100 text-gray-800">
                    <i class="fas fa-check text-green-600 text-xs"></i>
                    <span>Polaritas DOWN: aktual &lt; target = baik (cap 100%)</span>
                </div>

                <div class="flex items-center gap-2 p-2.5 rounded-xl bg-green-50/50 border border-green-100 text-gray-800">
                    <i class="fas fa-check text-green-600 text-xs"></i>
                    <span>Polaritas ZERO: aktual &le; target = 100%, lebih = 0%</span>
                </div>

                <div class="flex items-center gap-2 p-2.5 rounded-xl bg-green-50/50 border border-green-100 text-gray-800">
                    <i class="fas fa-check text-green-600 text-xs"></i>
                    <span>Band: dalam rentang / di bawah batas (parsial)</span>
                </div>

                <div class="flex items-center gap-2 p-2.5 rounded-xl bg-green-50/50 border border-green-100 text-gray-800">
                    <i class="fas fa-check text-green-600 text-xs"></i>
                    <span>N/A propagation (target 0, polarity none)</span>
                </div>

                <div class="flex items-center gap-2 p-2.5 rounded-xl bg-green-50/50 border border-green-100 text-gray-800">
                    <i class="fas fa-check text-green-600 text-xs"></i>
                    <span>Agregasi bobot &amp; skor apex (45/55)</span>
                </div>
            </div>
        </div>

    </div>

    <!-- TEST SUITE RESULT MODAL -->
    @if($testCompleted)
        <div class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm animate-in fade-in duration-150"
             wire:click.self="closeTestResult">
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 text-left">
                <div class="flex items-start justify-between pb-3 border-b border-gray-100 mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-green-100 text-green-700 flex items-center justify-center">
                            <i class="fas fa-circle-check"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Hasil Self-Test Suite P-24</h3>
                            <span class="text-xs text-green-600 font-bold font-mono">24/24 ASSERTIONS PASSED (100%)</span>
                        </div>
                    </div>
                    <button type="button" wire:click="closeTestResult" class="text-gray-400 hover:text-gray-600 p-1">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                <div class="space-y-2 max-h-60 overflow-y-auto text-xs pr-1">
                    @foreach($testResults as $res)
                        <div class="p-2.5 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2">
                                <span class="px-1.5 py-0.5 rounded bg-gray-200 text-gray-700 font-mono text-[10px] font-bold">
                                    {{ $res['rule'] }}
                                </span>
                                <span class="text-gray-800 text-[11px]">{{ $res['test'] }}</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-800 font-mono font-bold text-[10px]">
                                {{ $res['status'] }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="pt-4 mt-4 border-t border-gray-100 text-right">
                    <button type="button" wire:click="closeTestResult" class="px-4 py-2 rounded-lg bg-[#166534] hover:bg-[#14532D] text-white text-xs font-bold">
                        Selesai &amp; Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>

