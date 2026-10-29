<div class="space-y-6">
    <!-- Header Banner -->
    <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-[#FEE2E2] text-[#DC2626] flex items-center justify-center text-xl shadow-xs">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded bg-red-100 text-red-700">LEVEL 4</span>
                    <h2 class="text-base font-bold text-gray-900">Program Kerja &amp; Action Plan</h2>
                </div>
                <p class="text-xs text-gray-500 mt-0.5">
                    Tindak lanjut inisiatif perbaikan terukur untuk KPI yang berstatus Waspada atau Di Bawah Target.
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('department-objectives') }}" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-700 transition-colors">
                <i class="fas fa-bullseye text-[#166534] mr-1.5"></i> Lihat Sasaran Mutu
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

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- FORM TAMBAH PROGRAM KERJA (col-span-4) -->
        <div class="lg:col-span-4 bg-white rounded-3xl border border-gray-200 p-6 shadow-xs">
            <div class="flex items-center gap-2 pb-3 mb-4 border-b border-gray-100">
                <i class="fas fa-plus-circle text-[#DC2626]"></i>
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">
                    Tambah Inisiatif Perbaikan
                </h3>
            </div>

            <form wire:submit.prevent="createPlan" class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-gray-700 mb-1 text-[11px]">Judul Program Kerja</label>
                    <input type="text" wire:model="title" class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-red-500 text-xs" placeholder="Contoh: Kalibrasi Ulang Mesin Line 2">
                    @error('title') <span class="text-red-500 text-[10px] mt-0.5 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1 text-[11px]">Departemen Penanggung Jawab</label>
                    <input type="text" wire:model="ownerDept" class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-red-500 text-xs font-mono" placeholder="PROD / HRD / QC / FIN">
                    @error('ownerDept') <span class="text-red-500 text-[10px] mt-0.5 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1 text-[11px]">Terkait KPI (Opsional)</label>
                    <select wire:model="objectiveId" class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-red-500 text-xs bg-white">
                        <option value="">-- Pilih Sasaran Mutu --</option>
                        @foreach($offTargetObjectives as $offObj)
                            <option value="{{ $offObj->id }}">[{{ $offObj->dept_code }}] {{ $offObj->kpi_code }} - {{ Str::limit($offObj->kpi_name, 28) }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full py-2.5 rounded-xl bg-[#DC2626] hover:bg-[#B91C1C] text-white text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-1.5">
                    <i class="fas fa-save text-xs"></i>
                    <span>Simpan Program Kerja</span>
                </button>
            </form>
        </div>

        <!-- TABEL PROGRAM KERJA (col-span-8) -->
        <div class="lg:col-span-8 bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-xs">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fas fa-list-ol text-gray-400"></i>
                    <span>Progress Inisiatif &amp; Tindak Lanjut KPI</span>
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-gray-50/70 border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                            <th class="py-3 px-4">Dept</th>
                            <th class="py-3 px-4">Judul Inisiatif / Program Kerja</th>
                            <th class="py-3 px-4">Progress Fisik (%)</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($actionPlans as $plan)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3.5 px-4">
                                    <span class="px-2 py-0.5 rounded bg-gray-100 font-mono font-bold text-[10px] text-gray-700">
                                        {{ $plan->owner_dept }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <p class="font-bold text-gray-900 leading-snug">{{ $plan->title }}</p>
                                    @if($plan->objective)
                                        <span class="inline-flex items-center gap-1 text-[11px] text-gray-500 font-mono mt-0.5">
                                            <i class="fas fa-link text-gray-400 text-[9px]"></i>
                                            KPI: {{ $plan->objective->kpi_code }}
                                        </span>
                                    @endif
                                </td>

                                @if($editingPlanId === $plan->id)
                                    <td colspan="2" class="py-3.5 px-4">
                                        <div class="flex items-center gap-2">
                                            <input type="range" min="0" max="100" wire:model="editProgress" class="w-full accent-[#166534]">
                                            <span class="font-bold font-mono text-[#166534] min-w-[45px] text-xs">{{ $editProgress }}%</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <div class="inline-flex items-center gap-1">
                                            <button wire:click="updateProgress" class="px-2.5 py-1 rounded-lg bg-[#166534] hover:bg-[#14532D] text-white text-[11px] font-bold" title="Simpan">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button wire:click="cancelEdit" class="px-2.5 py-1 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 text-[11px]" title="Batal">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                @else
                                    <td class="py-3.5 px-4 min-w-[140px]">
                                        <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden mb-1">
                                            <div class="h-1.5 rounded-full {{ $plan->progress_pct >= 100 ? 'bg-[#10B981]' : ($plan->progress_pct >= 50 ? 'bg-amber-400' : 'bg-red-500') }}" 
                                                 style="width: {{ $plan->progress_pct }}%"></div>
                                        </div>
                                        <span class="font-mono font-bold text-[11px] text-gray-700">{{ $plan->progress_pct }}% Selesai</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        @if($plan->status === 'Completed')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#DCFCE7] text-[#166534] border border-green-200 font-bold text-[11px]">
                                                <i class="fas fa-check-circle text-[10px]"></i> Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200 font-bold text-[11px]">
                                                <i class="fas fa-arrows-rotate text-[10px] animate-spin"></i> On Progress
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <button wire:click="editProgressModal({{ $plan->id }})" class="px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-red-50 text-gray-700 hover:text-red-600 border border-gray-200 text-[11px] font-semibold transition-colors">
                                            <i class="fas fa-sliders mr-1 text-[10px]"></i> Progres
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-400 py-8 italic">
                                    Belum ada program kerja yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
