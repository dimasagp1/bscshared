<div class="space-y-6">
    <!-- Header Banner -->
    <div class="bg-white dark:bg-[#121214] rounded-3xl border border-gray-200 dark:border-[#1F2026] p-6 shadow-xs flex flex-wrap items-center justify-between gap-4 transition-colors duration-200">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-[#18181A] border border-transparent dark:border-[#242328] text-gray-800 dark:text-slate-200 flex items-center justify-center text-xl shadow-xs">
                <i class="fas fa-users-gear"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300">SUPER ADMIN</span>
                    <h2 class="text-base font-bold text-gray-900 dark:text-white">Manajemen Pengguna &amp; Akses Hak</h2>
                </div>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                    Kelola otorisasi RBAC (Role-Based Access Control) 6 Peran &amp; 13 Menu Sistem Super Apps Herbatech Innopharma.
                </p>
            </div>
        </div>

        <button wire:click="openCreate" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#166534] hover:bg-[#14532D] text-white text-xs font-bold transition-all shadow-xs">
            <i class="fas fa-plus text-xs"></i>
            <span>Tambah Pengguna</span>
        </button>
    </div>

    <!-- FLASH MESSAGES -->
    @if(session()->has('message'))
        <div class="rounded-xl bg-green-50 dark:bg-emerald-950/40 border border-green-200 dark:border-emerald-800/50 p-3.5 text-xs text-green-800 dark:text-emerald-300 flex items-center gap-2">
            <i class="fas fa-check-circle text-green-600 dark:text-emerald-400"></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="rounded-xl bg-red-50 dark:bg-rose-950/40 border border-red-200 dark:border-rose-800/50 p-3.5 text-xs text-red-800 dark:text-rose-300 flex items-center gap-2">
            <i class="fas fa-exclamation-triangle text-red-600 dark:text-rose-400"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- MAIN TABLE CARD -->
    <div class="bg-white dark:bg-[#121214] rounded-3xl border border-gray-200 dark:border-[#1F2026] overflow-hidden shadow-xs transition-colors duration-200">
        <!-- Filter Bar -->
        <div class="p-5 border-b border-gray-100 dark:border-[#1F2026] flex flex-wrap items-center justify-between gap-3">
            <div class="relative w-72">
                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-slate-500 text-xs"></i>
                <input type="text" wire:model.live="search" placeholder="Cari nama atau email..." 
                       class="w-full pl-9 pr-3 py-1.5 rounded-xl border border-gray-200 dark:border-[#242328] text-xs focus:outline-none focus:ring-1 focus:ring-green-600 bg-gray-50/50 dark:bg-[#18181A] text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500">
            </div>

            <div class="flex items-center gap-2.5">
                <!-- Filter Role -->
                <select wire:model.live="filterRole" class="px-3 py-1.5 rounded-xl border border-gray-200 dark:border-[#242328] text-xs font-semibold text-gray-700 dark:text-slate-200 bg-white dark:bg-[#18181A] hover:bg-gray-50 dark:hover:bg-[#242328] focus:outline-none">
                    <option value="">Semua Peran (Role)</option>
                    @foreach($roles as $r)
                        <option value="{{ $r }}">{{ $r }}</option>
                    @endforeach
                </select>

                <!-- Filter Status -->
                <select wire:model.live="filterStatus" class="px-3 py-1.5 rounded-xl border border-gray-200 dark:border-[#242328] text-xs font-semibold text-gray-700 dark:text-slate-200 bg-white dark:bg-[#18181A] hover:bg-gray-50 dark:hover:bg-[#242328] focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
        </div>

        <!-- Table View -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-gray-50/70 dark:bg-[#1A1A1C] border-b border-gray-100 dark:border-[#242328] text-[11px] font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                        <th class="py-3 px-4 w-12">#</th>
                        <th class="py-3 px-4">Nama Lengkap</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Role RBAC</th>
                        <th class="py-3 px-4">Dept</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-[#1F2026]">
                    @forelse($users as $u)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-[#1A1A1C] transition-colors">
                            <td class="py-3.5 px-4 font-mono text-gray-400 dark:text-slate-500 text-[11px]">
                                {{ $loop->iteration + ($users->currentPage()-1)*$users->perPage() }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-gray-900 dark:text-slate-100">
                                {{ $u->name }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-gray-600 dark:text-slate-400">
                                {{ $u->email }}
                            </td>
                            <td class="py-3.5 px-4">
                                @foreach($u->roles as $rl)
                                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold 
                                        @if($rl->name=='Super Admin') bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800/50
                                        @elseif($rl->name=='Admin FAT') bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800/50
                                        @elseif($rl->name=='Admin HRIS') bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800/50
                                        @elseif($rl->name=='Kepala Departemen') bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/50
                                        @else bg-gray-100 dark:bg-[#18181A] text-gray-700 dark:text-slate-300 border border-gray-200 dark:border-[#242328] @endif">
                                        {{ $rl->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="py-3.5 px-4 font-mono text-gray-600 dark:text-slate-400">
                                {{ $u->dept_code ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($u->is_active)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#DCFCE7] dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 border border-green-200 dark:border-emerald-800/50 font-bold text-[10px]">
                                        <i class="fas fa-check-circle text-[9px]"></i> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#FEE2E2] dark:bg-rose-950/60 text-[#991B1B] dark:text-rose-300 border border-red-200 dark:border-rose-800/50 font-bold text-[10px]">
                                        <i class="fas fa-times-circle text-[9px]"></i> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center gap-1">
                                    <button wire:click="openEdit({{ $u->id }})" class="p-1.5 rounded-lg text-gray-500 dark:text-slate-400 hover:text-[#166534] dark:hover:text-emerald-400 hover:bg-green-50 dark:hover:bg-emerald-950/40 transition-colors" title="Ubah">
                                        <i class="fas fa-pen text-xs"></i>
                                    </button>
                                    <button wire:click="toggleActive({{ $u->id }})" class="p-1.5 rounded-lg text-gray-500 dark:text-slate-400 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-950/40 transition-colors" title="{{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas {{ $u->is_active ? 'fa-user-slash' : 'fa-user-check' }} text-xs"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $u->id }})" class="p-1.5 rounded-lg text-gray-500 dark:text-slate-400 hover:text-red-600 dark:hover:text-rose-400 hover:bg-red-50 dark:hover:bg-rose-950/40 transition-colors" title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-400 dark:text-slate-500 py-8 italic">Tidak ada pengguna ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-[#1F2026]">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- Security Note -->
    <div class="p-4 rounded-2xl bg-gray-50 dark:bg-[#18181A] border border-gray-200 dark:border-[#242328] flex items-start gap-3 text-xs text-gray-600 dark:text-slate-400 transition-colors duration-200">
        <i class="fas fa-shield-halved text-[#166534] dark:text-emerald-400 text-base shrink-0 mt-0.5"></i>
        <div>
            <h4 class="font-bold text-gray-900 dark:text-slate-100">Kebijakan Perlindungan Super Admin</h4>
            <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5 leading-relaxed">
                Super Admin terakhir tidak dapat dihapus atau dinonaktifkan untuk mencegah lock-out sistem. Penonaktifan bersifat soft-disable (menutup akses login tanpa merusak jejak audit staging).
            </p>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm animate-in fade-in duration-150"
             wire:click.self="closeModal">
            <div class="bg-white dark:bg-[#18181A] rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 dark:border-[#242328] text-left">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-[#242328] mb-4">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">
                        {{ $isEdit ? 'Ubah Pengguna' : 'Tambah Pengguna Baru' }}
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 p-1">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                <div class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold text-gray-700 dark:text-slate-300 mb-1">Nama *</label>
                        <input type="text" wire:model="name" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-[#242328] bg-white dark:bg-[#121214] text-gray-900 dark:text-slate-100 focus:outline-none focus:ring-1 focus:ring-green-600">
                        @error('name') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 dark:text-slate-300 mb-1">Email *</label>
                        <input type="email" wire:model="email" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-[#242328] bg-white dark:bg-[#121214] text-gray-900 dark:text-slate-100 focus:outline-none focus:ring-1 focus:ring-green-600">
                        @error('email') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 dark:text-slate-300 mb-1">Password {{ $isEdit ? '(kosongkan jika tidak diubah)' : '*' }}</label>
                        <input type="password" wire:model="password" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-[#242328] bg-white dark:bg-[#121214] text-gray-900 dark:text-slate-100 focus:outline-none focus:ring-1 focus:ring-green-600">
                        @error('password') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-gray-700 dark:text-slate-300 mb-1">Role *</label>
                            <select wire:model="role" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-[#242328] bg-white dark:bg-[#121214] text-gray-900 dark:text-slate-100 focus:outline-none focus:ring-1 focus:ring-green-600">
                                @foreach($roles as $r)
                                    <option value="{{ $r }}">{{ $r }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-gray-700 dark:text-slate-300 mb-1">Kode Dept</label>
                            <input type="text" wire:model="dept_code" placeholder="OPS, FIN, HRD..." class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-[#242328] bg-white dark:bg-[#121214] text-gray-900 dark:text-slate-100 focus:outline-none focus:ring-1 focus:ring-green-600 font-mono">
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <input type="checkbox" id="isActiveSwitch" wire:model="is_active" class="w-4 h-4 rounded text-[#166534] accent-[#166534]">
                        <label for="isActiveSwitch" class="font-bold text-gray-700 dark:text-slate-300 cursor-pointer">
                            Pengguna Aktif (Dapat Login ke Sistem)
                        </label>
                    </div>
                </div>

                <div class="pt-4 mt-6 border-t border-gray-100 dark:border-[#242328] flex items-center justify-end gap-2">
                    <button wire:click="closeModal" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-[#242328] hover:bg-gray-200 dark:hover:bg-slate-700 text-xs font-semibold text-gray-700 dark:text-slate-300">
                        Batal
                    </button>
                    <button wire:click="saveUser" class="px-4 py-2 rounded-xl bg-[#166534] hover:bg-[#14532D] text-white text-xs font-bold">
                        {{ $isEdit ? 'Perbarui Pengguna' : 'Simpan Pengguna' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm animate-in fade-in duration-150"
             wire:click.self="closeModal">
            <div class="bg-white dark:bg-[#18181A] rounded-3xl max-w-sm w-full p-6 shadow-2xl border border-gray-100 dark:border-[#242328] text-center">
                <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-rose-950/60 text-red-600 dark:text-rose-400 flex items-center justify-center mx-auto mb-3 text-lg">
                    <i class="fas fa-trash"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1">Konfirmasi Hapus</h3>
                <p class="text-xs text-gray-500 dark:text-slate-400 mb-5">
                    Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex items-center justify-center gap-2">
                    <button wire:click="cancelDelete" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-[#242328] hover:bg-gray-200 dark:hover:bg-slate-700 text-xs font-semibold text-gray-700 dark:text-slate-300">
                        Batal
                    </button>
                    <button wire:click="deleteUser" class="px-4 py-2 rounded-xl bg-[#DC2626] hover:bg-red-700 text-white text-xs font-bold">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
