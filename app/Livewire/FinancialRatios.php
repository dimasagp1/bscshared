<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use App\Models\FinancialRatio;
use App\Models\Period;

class FinancialRatios extends Component
{
    public $selectedCategory = '';

    #[Url(as: 'status')]
    public $selectedStatus = '';

    #[Url(as: 'period')]
    public $selectedPeriod = '2026-08';

    public $editingRatioId = null;
    public $editTarget = 0;
    public $editActual = 0;

    public function mount()
    {
        $this->selectedPeriod = request()->query('period') ?: session('bsc_period', '2026-10');
        if (request()->query('status')) {
            $this->selectedStatus = request()->query('status');
        }
    }

    #[On('periodChanged')]
    public function onPeriodChanged($period)
    {
        if ($period) {
            $this->selectedPeriod = $period;
        }
    }

    public function editRatio($id)
    {
        if (!auth()->user()?->can('manage ratios')) {
            session()->flash('error', 'Akses ditolak: peran Anda tidak berwenang mengelola rasio (butuh manage ratios / Admin FAT / Super Admin).');
            return;
        }
        $periodObj = Period::where('period', $this->selectedPeriod)->first();
        if ($periodObj && $periodObj->isClosed()) {
            session()->flash('error', 'Periode ' . $this->selectedPeriod . ' telah DITUTUP (CLOSED). Data tidak dapat diubah.');
            return;
        }

        $ratio = FinancialRatio::findOrFail($id);
        $this->editingRatioId = $ratio->id;
        $this->editTarget = $ratio->target;
        $this->editActual = $ratio->actual;
    }

    public function updateRatio()
    {
        if (!$this->editingRatioId) return;
        if (!auth()->user()?->can('manage ratios')) {
            session()->flash('error', 'Akses ditolak: peran Anda tidak berwenang mengelola rasio.');
            $this->editingRatioId = null;
            return;
        }

        $periodObj = Period::where('period', $this->selectedPeriod)->first();
        if ($periodObj && $periodObj->isClosed()) {
            session()->flash('error', 'Periode ' . $this->selectedPeriod . ' telah DITUTUP (CLOSED). Data tidak dapat diubah.');
            $this->editingRatioId = null;
            return;
        }

        $ratio = FinancialRatio::findOrFail($this->editingRatioId);
        $target = floatval($this->editTarget);
        $actual = floatval($this->editActual);

        // Simple percentage calculation
        $ach = $target > 0 ? round(($actual / $target) * 100, 2) : 100;
        if ($ach > 100) $ach = 100.00;
        
        $status = 'Waspada';
        if ($ach >= 100) {
            $status = 'Tercapai';
        } elseif ($ach < 80) {
            $status = 'Di Bawah Target';
        }

        $ratio->update([
            'target' => $target,
            'actual' => $actual,
            'achievement_pct' => $ach,
            'status' => $status,
        ]);

        $this->editingRatioId = null;
        session()->flash('message', 'Nilai rasio ' . $ratio->ratio_name . ' berhasil diperbarui!');
    }

    public function cancelEdit()
    {
        $this->editingRatioId = null;
    }

    public function render()
    {
        try {
            $periodObj = Period::where('period', $this->selectedPeriod)->first();
            $isClosed = $periodObj ? $periodObj->isClosed() : false;

            $query = FinancialRatio::where('period', $this->selectedPeriod);
            if ($this->selectedCategory) {
                $query->where('category', $this->selectedCategory);
            }
            if ($this->selectedStatus) {
                if ($this->selectedStatus === 'bermasalah') {
                    $query->whereIn('status', ['Waspada', 'Di Bawah Target', 'Off-Target']);
                } else {
                    $query->where('status', $this->selectedStatus);
                }
            }
            $ratios = $query->get();
            $categories = FinancialRatio::distinct()->pluck('category')->toArray();
            $periods = Period::pluck('period')->toArray();
        } catch (\Throwable $e) {
            $isClosed = false;
            $ratios = collect();
            $categories = ['Profitabilitas', 'Aktivitas', 'Produktivitas', 'Likuiditas', 'Solvabilitas'];
            $periods = ['2026-10', '2026-09', '2026-08', '2025-10'];
        }

        return view('livewire.financial-ratios', [
            'ratios' => $ratios,
            'categories' => $categories,
            'periods' => $periods,
            'isClosed' => $isClosed,
            'editingRatioId' => $this->editingRatioId,
            'editTarget' => $this->editTarget,
            'editActual' => $this->editActual,
            'selectedPeriod' => $this->selectedPeriod,
            'selectedCategory' => $this->selectedCategory,
            'selectedStatus' => $this->selectedStatus,
        ])->layout('layouts.app', ['title' => 'Rasio Keuangan']);
    }
}
