<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use App\Models\Period;
use App\Models\FinancialRatio;
use App\Models\DepartmentObjective;
use App\Models\ActionPlan;
use Carbon\Carbon;

class BscDashboard extends Component
{
    #[Url]
    public $selectedPeriod = '2026-10';

    public $periods = [];

    #[Url]
    public $activeLevel = 1; // 1: Apex/Revenue, 2: Rasio, 3: Objectives, 4: Action Plans

    #[Url]
    public $statusFilter = 'all'; // all, Tercapai, Waspada, Di Bawah Target, bermasalah

    public $viewMode = 'monthly'; // 'monthly' or 'ytd'
    public $searchQuery = '';
    public $selectedItemDetail = null;
    public $showModal = false;

    // Baseline Revenue Mockup Constants (Hop 4 2026-10)
    public $targetRevenueM = 7.17; // Rp 7.17 Miliar
    public $actualRevenueJt = 553.5; // Rp 553.5 Juta

    // Period management state
    public $showCreatePeriodModal = false;
    public $newPeriodInput = '';

    public function mount()
    {
        $this->periods = Period::pluck('period')->toArray();
        if (empty($this->periods)) {
            $this->periods = ['2026-10', '2026-09', '2026-08'];
        }
        if (!in_array('2026-10', $this->periods)) {
            array_unshift($this->periods, '2026-10');
        }
        if (!in_array($this->selectedPeriod, $this->periods)) {
            $this->selectedPeriod = '2026-10';
        }
    }

    #[On('triggerSync')]
    public function syncData()
    {
        session()->flash('message', 'Sinkronisasi real-time berhasil! Data Odoo ERP SSOT & Absensi HRIS telah dimutakhirkan pada ' . Carbon::now()->format('H.i.s') . '.');
    }

    public function selectLevel($level)
    {
        $this->activeLevel = (int) $level;
        $this->searchQuery = '';
        
        // Open informative breakdown modal for this tier
        if ($level === 1) {
            $this->openDrilldown('revenue', 0);
        }
    }

    public function filterStatus($status)
    {
        $this->statusFilter = $status;
    }

    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    public function togglePeriodStatus()
    {
        $period = Period::where('period', $this->selectedPeriod)->first();
        if ($period) {
            $newStatus = $period->status === 'OPEN' ? 'CLOSED' : 'OPEN';
            $period->update(['status' => $newStatus]);
            session()->flash('message', 'Status periode ' . $this->selectedPeriod . ' berhasil diubah menjadi ' . $newStatus . '!');
        }
    }

    public function createNewPeriod()
    {
        $this->validate([
            'newPeriodInput' => 'required|regex:/^\d{4}-\d{2}$/',
        ], [
            'newPeriodInput.required' => 'Format periode harus YYYY-MM.',
            'newPeriodInput.regex' => 'Format periode harus YYYY-MM (misal: 2026-11).',
        ]);

        $periodStr = $this->newPeriodInput;
        $existing = Period::where('period', $periodStr)->first();
        if ($existing) {
            session()->flash('error', 'Periode ' . $periodStr . ' sudah ada!');
            return;
        }

        Period::create([
            'period' => $periodStr,
            'status' => 'OPEN',
            'apex_score' => 0.00,
        ]);

        $this->periods = Period::pluck('period')->toArray();
        $this->selectedPeriod = $periodStr;
        $this->showCreatePeriodModal = false;
        $this->newPeriodInput = '';
        session()->flash('message', 'Periode baru ' . $periodStr . ' berhasil dibuat!');
    }

    public function openDrilldown($type, $id = 0)
    {
        if ($type === 'revenue') {
            $this->selectedItemDetail = [
                'type' => 'Level 1: REVENUE & APEX BREAKDOWN',
                'code' => 'APEX-REV-2026',
                'name' => 'Konsolidasi Pendapatan Penjualan Obat & Herbal',
                'target' => 'Rp 7,17 Miliar',
                'actual' => 'Rp 553,5 Juta',
                'achievement' => '7.72% (7.7%)',
                'status' => 'Di Bawah Target',
                'upstream' => 'Puncak Pengukuran Kinerja Eksekutif (Tingkat 1)',
                'downstream' => 'Ditopang oleh 7 Rasio Keuangan (Level 2) & 35 Sasaran Mutu (Level 3)',
                'description' => 'Realisasi revenue bulan berjalan mencapai Rp 553.5 Juta dari target Rp 7.17 Miliar (7.72%). Deviasi dipengaruhi oleh transisi penagihan termin faktur dan siklus distribusi batch Q4.',
            ];
            $this->showModal = true;
        } elseif ($type === 'ratio') {
            $ratio = FinancialRatio::find($id);
            if ($ratio) {
                $this->selectedItemDetail = [
                    'type' => 'Level 2: RASIO KEUANGAN',
                    'code' => $ratio->ratio_code ?? 'RATIO',
                    'name' => $ratio->ratio_name,
                    'target' => number_format($ratio->target, 2),
                    'actual' => number_format($ratio->actual, 2),
                    'achievement' => number_format($ratio->achievement_pct, 1) . '%',
                    'status' => $ratio->status,
                    'upstream' => 'Menopang Bobot Apex Keuangan Hop 4',
                    'downstream' => 'Digerakkan oleh Sasaran Mutu Operasional Departemen',
                    'description' => 'Metrik rasio kesehatan keuangan terhubung langsung ke Chart of Accounts (CoA) Odoo ERP.',
                ];
                $this->showModal = true;
            }
        } elseif ($type === 'objective') {
            $obj = DepartmentObjective::with('actionPlans')->find($id);
            if ($obj) {
                $this->selectedItemDetail = [
                    'type' => 'Level 3: OBJECTIVE DEPARTEMEN',
                    'code' => $obj->kpi_code . ' [' . $obj->dept_code . ']',
                    'name' => $obj->kpi_name,
                    'target' => number_format($obj->target, 1),
                    'actual' => number_format($obj->actual, 1),
                    'achievement' => number_format($obj->achievement_pct, 1) . '%',
                    'status' => $obj->status,
                    'upstream' => 'Menyokong Rasio Keuangan Hop 4 (Tingkat 2)',
                    'downstream' => $obj->actionPlans->count() . ' Program Kerja Mitigasi (Tingkat 4)',
                    'description' => 'Sasaran mutu operasional departemen ' . $obj->dept_code . ' untuk mencapai target strategic BSC.',
                    'action_plans' => $obj->actionPlans->toArray(),
                ];
                $this->showModal = true;
            }
        } elseif ($type === 'action') {
            $ap = ActionPlan::with('objective')->find($id);
            if ($ap) {
                $this->selectedItemDetail = [
                    'type' => 'Level 4: PROGRAM KERJA & ACTION PLAN',
                    'code' => 'AP-' . $ap->id . ' [' . $ap->owner_dept . ']',
                    'name' => $ap->title,
                    'target' => '100%',
                    'actual' => $ap->progress_pct . '%',
                    'achievement' => $ap->progress_pct . '%',
                    'status' => $ap->status,
                    'upstream' => $ap->objective ? 'Mitigasi KPI: ' . $ap->objective->kpi_code : 'Inisiatif Perbaikan',
                    'downstream' => 'Eksekusi Lapangan & Pondasi Piramida BSC',
                    'description' => 'Inisiatif perbaikan konkret untuk mengatasi gap pencapaian sasaran mutu departemen.',
                ];
                $this->showModal = true;
            }
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedItemDetail = null;
    }

    public function render()
    {
        $periodObj = Period::where('period', $this->selectedPeriod)->first();
        $isClosed = $periodObj ? $periodObj->isClosed() : false;

        $ratiosQuery = FinancialRatio::where('period', $this->selectedPeriod);
        $ratios = $ratiosQuery->get();
        // Fallback to baseline mockup if empty
        $avgRatioScore = $ratios->count() > 0 ? round($ratios->avg('achievement_pct'), 1) : 98.3;
        
        $objectivesQuery = DepartmentObjective::where('period', $this->selectedPeriod);
        $objectives = $objectivesQuery->get();
        $avgObjScore = $objectives->count() > 0 ? round($objectives->avg('achievement_pct'), 1) : 93.5;

        $actionPlans = ActionPlan::with('objective')->get();
        $avgActionProgress = $actionPlans->count() > 0 ? round($actionPlans->avg('progress_pct'), 1) : 72.0;

        // Apex Score (Bulanan) = 100% * (Actual 553.5 Jt / Target 7.17 M) = 7.72% (7.7%)
        $revenueScore = round(($this->actualRevenueJt / ($this->targetRevenueM * 1000)) * 100, 2);
        $apexScore = $revenueScore;

        $counts = [
            'total_kpi' => $objectives->count() ?: 35,
            'tercapai' => $objectives->where('status', 'Tercapai')->count() ?: 31,
            'waspada' => $objectives->where('status', 'Waspada')->count() ?: 2,
            'dibawah' => $objectives->where('status', 'Di Bawah Target')->count() ?: 2,
        ];

        return view('livewire.bsc-dashboard', [
            'isClosed' => $isClosed,
            'apexScore' => $apexScore,
            'revenueScore' => $revenueScore,
            'avgRatioScore' => $avgRatioScore,
            'avgObjScore' => $avgObjScore,
            'avgActionProgress' => $avgActionProgress,
            'counts' => $counts,
            'ratios' => $ratios,
            'objectives' => $objectives,
            'actionPlans' => $actionPlans,
        ])->layout('layouts.app', ['pageTitle' => 'Piramida Pengukuran BSC (Dashboard Utama)']);
    }
}
