<div class="bg-white border-b border-gray-200 px-6 py-2.5 flex flex-wrap items-center justify-between gap-3 text-xs relative {{ $showManageModal ? 'z-[60]' : 'z-10' }}">
    
    <!-- LEFT CONTROLS: PERIODIC MONITOR BADGE, TAHUN DROPDOWN, BULAN DROPDOWN, 12 MONTH PILLS -->
    <div class="flex flex-wrap items-center gap-2">
        <!-- Badge Periodic Monitor -->
        <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-[#DCFCE7] text-[#166534] font-bold text-[11px] shrink-0">
            <i class="far fa-calendar text-[11px]"></i>
            <span>PERIODIC MONITOR</span>
        </span>

        <!-- Dropdown Tahun -->
        <div class="relative" x-data="{ openYear: false }">
            <button type="button" 
                    @click="openYear = !openYear" 
                    @click.outside="openYear = false"
                    class="px-2.5 py-1 rounded-lg border border-gray-200 font-semibold text-gray-800 flex items-center gap-1 cursor-pointer bg-white hover:bg-gray-50 transition-colors">
                <span>Tahun: <strong>{{ $selectedYear }}</strong></span>
                <i class="fas fa-chevron-down text-[9px] text-gray-400 ml-0.5"></i>
            </button>

            <!-- Dropdown Menu Tahun -->
            <div x-show="openYear" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute left-0 mt-1 w-32 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-30">
                @foreach($availableYears as $yr)
                    <button type="button" 
                            wire:click="setYear('{{ $yr }}')" 
                            @click="openYear = false"
                            class="w-full text-left px-3 py-1.5 text-xs hover:bg-gray-50 flex items-center justify-between {{ $selectedYear == $yr ? 'font-bold text-[#166534] bg-green-50/50' : 'text-gray-700' }}">
                        <span>{{ $yr }}</span>
                        @if($selectedYear == $yr)
                            <i class="fas fa-check text-[10px] text-[#166534]"></i>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Dropdown Bulan Aktif -->
        <div class="relative" x-data="{ openMonth: false }">
            <button type="button" 
                    @click="openMonth = !openMonth" 
                    @click.outside="openMonth = false"
                    class="px-2.5 py-1 rounded-lg border border-gray-200 font-semibold text-gray-800 flex items-center gap-1.5 cursor-pointer bg-white hover:bg-gray-50 transition-colors">
                <span>Bulan: <strong>{{ $currentMonthName }} ({{ $selectedMonth }})</strong></span>
                <span class="w-2 h-2 rounded-full bg-green-500 shrink-0"></span>
                <i class="fas fa-chevron-down text-[9px] text-gray-400"></i>
            </button>

            <!-- Dropdown Menu Bulan -->
            <div x-show="openMonth" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute left-0 mt-1 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-30 max-h-64 overflow-y-auto">
                @foreach($months as $num => $m)
                    <button type="button" 
                            wire:click="setMonth('{{ $num }}')" 
                            @click="openMonth = false"
                            class="w-full text-left px-3 py-1.5 text-xs hover:bg-gray-50 flex items-center justify-between {{ $selectedMonth === $num ? 'font-bold text-[#166534] bg-green-50/50' : 'text-gray-700' }}">
                        <span>{{ $num }} - {{ $m['name'] }}</span>
                        @if($selectedMonth === $num)
                            <span class="w-2 h-2 rounded-full bg-[#166534]"></span>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Timeline 12 Bulan Quick-Pills (Jan • Feb • ... Okt Nov Des) -->
        <div class="flex items-center gap-1 ml-1 text-gray-600 font-medium">
            @foreach($months as $num => $m)
                @if($selectedMonth === $num)
                    <!-- Active Month Pill -->
                    <button type="button" 
                            wire:click="setMonth('{{ $num }}')" 
                            class="px-2.5 py-0.5 rounded bg-[#166534] text-white font-bold shadow-xs cursor-pointer text-xs transition-all">
                        {{ $m['short'] }}
                    </button>
                @else
                    <!-- Inactive Month Pill -->
                    <button type="button" 
                            wire:click="setMonth('{{ $num }}')" 
                            class="px-1.5 py-0.5 rounded cursor-pointer hover:bg-gray-100 hover:text-gray-900 text-gray-600 font-medium text-xs transition-colors">
                        {{ $m['short'] }}{{ $m['has_dot'] ? ' •' : '' }}
                    </button>
                @endif
            @endforeach
        </div>
    </div>

    <!-- RIGHT CONTROLS: PER BULAN VS AKUMULATIF (YTD), TAHUN LALU, COMPARE, KELOLA -->
    <div class="flex items-center gap-3">
        <!-- Segmented Toggle: Per Bulan vs Akumulatif (YTD) -->
        <div class="flex items-center bg-gray-100 p-0.5 rounded-lg border border-gray-200 text-[11px] font-semibold">
            <button type="button" 
                    wire:click="setViewMode('monthly')"
                    class="px-2.5 py-1 rounded-md transition-all flex items-center gap-1.5 {{ $viewMode === 'monthly' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                <i class="far fa-calendar text-[11px]"></i>
                <span>Per Bulan</span>
            </button>
            <button type="button" 
                    wire:click="setViewMode('ytd')"
                    class="px-2.5 py-1 rounded-md transition-all flex items-center gap-1.5 {{ $viewMode === 'ytd' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                <i class="fas fa-chart-line text-[11px]"></i>
                <span>Akumulatif (YTD)</span>
            </button>
        </div>

        <!-- Prior Year, Compare, and Kelola Actions -->
        <div class="flex items-center gap-1 text-[11px]">
            <!-- Reference Tahun Lalu -->
            <span class="px-2 py-1 rounded border border-gray-200 bg-gray-50 text-gray-700 font-mono">
                <i class="far fa-clock mr-1 text-gray-400"></i> Tahun Lalu: <strong>{{ $priorYearPeriod }}</strong>
            </span>

            <!-- Swap / Compare Button -->
            <button type="button" 
                    wire:click="swapPriorYear"
                    class="px-2 py-1 rounded border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 transition-colors" 
                    title="Ganti ke Tahun Lalu ({{ $priorYearPeriod }}) untuk Komparasi">
                <i class="fas fa-arrow-right-arrow-left text-[10px]"></i>
            </button>

            <!-- + Kelola Modal Button -->
            <button type="button" 
                    wire:click="openManageModal"
                    class="px-2.5 py-1 rounded border border-gray-200 bg-white hover:bg-gray-50 font-bold text-gray-800 transition-colors" 
                    title="Kelola Daftar Periode & Status">
                + Kelola
            </button>
        </div>
    </div>

    <!-- MODAL POPUP KELOLA PERIODE -->
    @if($showManageModal)
        <div class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm animate-in fade-in duration-150"
             wire:click.self="closeManageModal">
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 text-left relative z-10 animate-in zoom-in-95 duration-150">
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-[#DCFCE7] text-[#166534] flex items-center justify-center text-sm">
                            <i class="far fa-calendar-check"></i>
                        </div>
                        <h3 class="text-base font-bold text-gray-900">Kelola Periode Pelaporan</h3>
                    </div>
                    <button type="button" wire:click="closeManageModal" class="text-gray-400 hover:text-gray-600 p-1">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                @if(session()->has('period_msg'))
                    <div class="mb-4 p-2.5 rounded-xl bg-green-50 border border-green-200 text-xs text-green-800 flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-600"></i>
                        <span>{{ session('period_msg') }}</span>
                    </div>
                @endif

                <!-- Form Tambah Periode Baru -->
                <form wire:submit.prevent="createPeriod" class="p-4 rounded-2xl bg-gray-50 border border-gray-200 mb-4">
                    <h4 class="text-xs font-bold text-gray-800 mb-2">Buka Periode Pelaporan Baru</h4>
                    <div class="flex items-center gap-2">
                        <input type="text" 
                               wire:model="newPeriodInput" 
                               placeholder="Format: YYYY-MM (misal: 2026-11)" 
                               class="flex-1 px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-mono font-bold focus:outline-none focus:ring-1 focus:ring-green-600 bg-white">
                        <button type="submit" class="px-4 py-1.5 rounded-xl bg-[#166534] hover:bg-[#14532D] text-white text-xs font-bold shrink-0">
                            + Tambah Periode
                        </button>
                    </div>
                    @error('newPeriodInput')
                        <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span>
                    @enderror
                </form>

                <!-- Daftar Periode Tersimpan -->
                <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Status Periode Terdaftar:</h4>
                <div class="max-h-56 overflow-y-auto rounded-2xl border border-gray-100 divide-y divide-gray-100">
                    @forelse($allPeriods as $p)
                        <div class="p-3 flex items-center justify-between hover:bg-gray-50/60 transition-colors">
                            <div class="flex items-center gap-2.5">
                                <span class="font-mono font-bold text-xs text-gray-900">{{ $p->period }}</span>
                                @if($p->period === $selectedPeriod)
                                    <span class="px-2 py-0.5 rounded-full bg-[#DCFCE7] text-[#166534] text-[10px] font-bold">Sedang Aktif</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $p->status === 'OPEN' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $p->status }}
                                </span>
                                <button type="button" 
                                        wire:click="toggleStatus('{{ $p->period }}')" 
                                        class="px-2 py-1 rounded-lg text-[10px] font-semibold border border-gray-200 hover:bg-gray-100 transition-colors">
                                    {{ $p->status === 'OPEN' ? 'Kunci (Close)' : 'Buka (Open)' }}
                                </button>
                                @if($p->period !== $selectedPeriod)
                                    <button type="button" 
                                            wire:click="selectPeriod('{{ $p->period }}')" 
                                            class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-[#166534] text-white hover:bg-[#14532D] transition-colors">
                                        Pilih
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-400 text-xs italic">Belum ada periode tersimpan.</div>
                    @endforelse
                </div>

                <div class="pt-4 mt-4 border-t border-gray-100 flex justify-end">
                    <button type="button" wire:click="closeManageModal" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-700">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

