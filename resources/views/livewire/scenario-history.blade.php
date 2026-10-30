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
    @if(session()->has('error'))
        <div class="rounded-2xl bg-red-50 dark:bg-rose-950/40 border border-red-200 dark:border-rose-800/50 p-4 text-xs text-red-800 dark:text-rose-300 flex items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-exclamation-triangle text-red-600 dark:text-rose-400 text-sm"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-600 dark:text-rose-400 hover:text-red-800 text-xs cursor-pointer">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Card 1: Header Sesi Simulasi & Undo/Redo History -->
    <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 sm:p-6 shadow-xs flex flex-wrap items-center justify-between gap-4 transition-colors duration-200">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-[#DCFCE7] dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 border border-green-200/60 dark:border-emerald-800/50 flex items-center justify-center text-xl shadow-xs shrink-0">
                <i class="fas fa-clock-rotate-left"></i>
            </div>
            <div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">
                    Simulation Session & Undo/Redo History
                </h2>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                    Dukungan Undo/Redo hingga 50 langkah, Ekspor & Impor JSON skenario
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <!-- Counter Langkah -->
            <div class="px-3 py-1.5 rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50/70 dark:bg-slate-800/60 text-xs font-mono font-semibold text-gray-600 dark:text-slate-300">
                Langkah: {{ $currentStepIndex }}/{{ $totalSteps }}
            </div>

            <!-- Button Undo -->
            <button wire:click="undo" type="button" 
                    class="w-9 h-9 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-gray-50 dark:hover:bg-slate-800 text-gray-700 dark:text-slate-300 flex items-center justify-center transition-colors shadow-xs cursor-pointer {{ $currentStepIndex <= 0 ? 'opacity-40 cursor-not-allowed' : '' }}" 
                    {{ $currentStepIndex <= 0 ? 'disabled' : '' }} title="Undo (Langkah Sebelumnya)">
                <i class="fas fa-rotate-left text-xs"></i>
            </button>

            <!-- Button Redo -->
            <button wire:click="redo" type="button" 
                    class="w-9 h-9 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-gray-50 dark:hover:bg-slate-800 text-gray-700 dark:text-slate-300 flex items-center justify-center transition-colors shadow-xs cursor-pointer {{ $currentStepIndex >= $totalSteps ? 'opacity-40 cursor-not-allowed' : '' }}" 
                    {{ $currentStepIndex >= $totalSteps ? 'disabled' : '' }} title="Redo (Langkah Berikutnya)">
                <i class="fas fa-rotate-right text-xs"></i>
            </button>

            <!-- Button Export JSON -->
            <button wire:click="openExportModal" type="button" 
                    class="w-9 h-9 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-gray-50 dark:hover:bg-slate-800 text-gray-700 dark:text-slate-300 flex items-center justify-center transition-colors shadow-xs cursor-pointer" 
                    title="Ekspor Skenario JSON">
                <i class="fas fa-download text-xs"></i>
            </button>

            <!-- Button Import JSON -->
            <button wire:click="openImportModal" type="button" 
                    class="w-9 h-9 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-gray-50 dark:hover:bg-slate-800 text-gray-700 dark:text-slate-300 flex items-center justify-center transition-colors shadow-xs cursor-pointer" 
                    title="Impor Skenario JSON">
                <i class="fas fa-upload text-xs"></i>
            </button>
        </div>
    </div>

    <!-- Card 2: Form Penyimpanan Skenario Baru -->
    <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 sm:p-6 shadow-xs flex flex-wrap items-center gap-3 transition-colors duration-200">
        <input type="text" wire:model="scenarioName" wire:keydown.enter="saveScenario" 
               placeholder="Nama skenario (mis. Kenaikan Target Revenue 5%)" 
               class="flex-1 min-w-[240px] px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600 transition-colors">

        <button wire:click="saveScenario" type="button" 
                class="px-4 py-2.5 rounded-xl bg-[#166534] hover:bg-[#14532D] active:bg-[#0f3d20] text-white text-xs font-bold shadow-xs transition-colors inline-flex items-center gap-2 cursor-pointer">
            <i class="fas fa-floppy-disk text-xs"></i>
            <span>Simpan Skenario</span>
        </button>

        <button wire:click="resetForm" type="button" 
                class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-gray-50 dark:hover:bg-slate-800 text-gray-700 dark:text-slate-300 text-xs font-semibold shadow-xs transition-colors inline-flex items-center gap-1.5 cursor-pointer">
            <i class="fas fa-rotate-left text-xs"></i>
            <span>Reset</span>
        </button>
    </div>

    <!-- Card 3: Daftar Skenario Tersimpan -->
    <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 sm:p-6 shadow-xs space-y-4 transition-colors duration-200">
        <h3 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">
            DAFTAR SKENARIO TERSIMPAN
        </h3>

        <div class="space-y-3">
            @forelse($savedScenarios as $sc)
                <div class="p-4 rounded-2xl bg-gray-50/70 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-800 flex items-center justify-between gap-4 transition-colors">
                    <div class="flex items-center gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-800/50 flex items-center justify-center text-sm shrink-0">
                            <i class="far fa-file-lines"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-xs uppercase tracking-wide text-gray-900 dark:text-white">
                                {{ $sc['name'] }}
                            </h4>
                            <div class="text-[11px] font-mono text-gray-400 dark:text-slate-500 mt-0.5">
                                {{ $sc['created_at'] }} · langkah simulasi: {{ $sc['steps_count'] }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button wire:click="loadScenario('{{ $sc['id'] }}')" type="button" 
                                class="px-3.5 py-1.5 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-200 text-xs font-semibold shadow-xs transition-colors cursor-pointer">
                            Muat
                        </button>

                        <button wire:click="deleteScenario('{{ $sc['id'] }}')" type="button" 
                                class="w-8 h-8 rounded-xl text-gray-400 hover:text-red-600 dark:hover:text-rose-400 flex items-center justify-center transition-colors cursor-pointer" 
                                title="Hapus Skenario">
                            <i class="far fa-trash-can text-xs"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-400 dark:text-slate-500 italic text-xs">
                    Belum ada skenario tersimpan. Buat skenario baru menggunakan formulir di atas.
                </div>
            @endforelse
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL 1: EKSPOR SKENARIO JSON                                             -->
    <!-- ========================================================================= -->
    @if($showExportModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-slate-900/60 dark:bg-slate-950/80 backdrop-blur-xs transition-opacity" wire:click="closeExportModal"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-white dark:bg-[#0F172A] text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl border border-gray-200 dark:border-slate-800">
                    <!-- Modal Header -->
                    <div class="p-6 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-400 flex items-center justify-center text-base border border-indigo-200/60 dark:border-indigo-800/50">
                                <i class="fas fa-download"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                    Ekspor Skenario JSON
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                                    Salin atau unduh berkas konfigurasi skenario
                                </p>
                            </div>
                        </div>
                        <button wire:click="closeExportModal" class="w-8 h-8 rounded-full bg-gray-100 dark:bg-slate-800 text-gray-500 hover:text-gray-800 dark:text-slate-400 dark:hover:text-white flex items-center justify-center transition-colors">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 space-y-4 text-xs">
                        <textarea readonly rows="12" class="w-full p-4 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800 font-mono text-[11px] text-gray-800 dark:text-slate-200 focus:outline-none select-all">{{ $exportJsonContent }}</textarea>
                    </div>

                    <!-- Modal Footer -->
                    <div class="p-4 bg-gray-50 dark:bg-slate-900/60 border-t border-gray-100 dark:border-slate-800 flex justify-end gap-2">
                        <button wire:click="closeExportModal" class="px-4 py-2 rounded-xl bg-gray-200 dark:bg-slate-800 hover:bg-gray-300 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-200 text-xs font-bold transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- MODAL 2: IMPOR SKENARIO JSON                                              -->
    <!-- ========================================================================= -->
    @if($showImportModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-slate-900/60 dark:bg-slate-950/80 backdrop-blur-xs transition-opacity" wire:click="closeImportModal"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-white dark:bg-[#0F172A] text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl border border-gray-200 dark:border-slate-800">
                    <!-- Modal Header -->
                    <div class="p-6 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-[#DCFCE7] dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 flex items-center justify-center text-base border border-green-200/60 dark:border-emerald-800/50">
                                <i class="fas fa-upload"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                    Impor Skenario JSON
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                                    Tempelkan struktur payload JSON skenario ke kotak di bawah
                                </p>
                            </div>
                        </div>
                        <button wire:click="closeImportModal" class="w-8 h-8 rounded-full bg-gray-100 dark:bg-slate-800 text-gray-500 hover:text-gray-800 dark:text-slate-400 dark:hover:text-white flex items-center justify-center transition-colors">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 space-y-4 text-xs">
                        <textarea wire:model="importJsonContent" rows="10" placeholder='{"name": "TARGET KHUSUS", "steps_count": 0, "payload": {...}}' class="w-full p-4 rounded-2xl bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 font-mono text-[11px] text-gray-800 dark:text-slate-200 focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-green-600"></textarea>
                    </div>

                    <!-- Modal Footer -->
                    <div class="p-4 bg-gray-50 dark:bg-slate-900/60 border-t border-gray-100 dark:border-slate-800 flex justify-end gap-2">
                        <button wire:click="closeImportModal" class="px-4 py-2 rounded-xl bg-gray-200 dark:bg-slate-800 hover:bg-gray-300 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-200 text-xs font-bold transition-colors">
                            Batal
                        </button>
                        <button wire:click="importJson" class="px-4 py-2 rounded-xl bg-[#166534] hover:bg-[#14532D] text-white text-xs font-bold transition-colors">
                            Proses Impor
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

