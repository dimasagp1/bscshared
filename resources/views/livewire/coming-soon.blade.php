<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1><i class="fas fa-tools mr-2 text-muted"></i>{{ $menuTitle }}</h1><small class="text-muted">{{ $frCode }}</small></div>
                <div class="col-sm-6"><ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li><li class="breadcrumb-item active">{{ $menuTitle }}</li></ol></div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-secondary">
                <div class="card-body text-center py-5">
                    <div class="mb-3"><i class="fas fa-hourglass-half fa-3x text-muted"></i></div>
                    <h4 class="font-weight-bold">{{ $menuTitle }} — Segera Hadir</h4>
                    <p class="text-muted mx-auto" style="max-width:600px;">{{ $menuDesc }}</p>
                    <span class="badge badge-secondary">{{ $frCode }}</span>
                    <div class="mt-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-teal btn-sm" style="background:#17a2b8; border-color:#17a2b8; color:#fff;"><i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard</a>
                    </div>
                    @can('view dashboard')
                    <small class="text-muted d-block mt-3">Anda memiliki akses view untuk menu ini. Konten akan diganti saat FR terealisasi.</small>
                    @endcan
                </div>
            </div>
        </div>
    </section>
</div>
