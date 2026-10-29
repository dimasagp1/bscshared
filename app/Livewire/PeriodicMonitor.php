<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use App\Models\Period;

class PeriodicMonitor extends Component
{
    #[Url(as: 'period')]
    public $selectedPeriod = '2026-10';

    #[Url(as: 'mode')]
    public $viewMode = 'monthly'; // 'monthly' or 'ytd'

    public $selectedYear = '2026';
    public $selectedMonth = '10';

    public $availableYears = ['2024', '2025', '2026', '2027'];

    public $months = [
        '01' => ['short' => 'Jan', 'name' => 'Januari', 'has_dot' => true],
        '02' => ['short' => 'Feb', 'name' => 'Februari', 'has_dot' => true],
        '03' => ['short' => 'Mar', 'name' => 'Maret', 'has_dot' => true],
        '04' => ['short' => 'Apr', 'name' => 'April', 'has_dot' => true],
        '05' => ['short' => 'Mei', 'name' => 'Mei', 'has_dot' => true],
        '06' => ['short' => 'Jun', 'name' => 'Juni', 'has_dot' => true],
        '07' => ['short' => 'Jul', 'name' => 'Juli', 'has_dot' => true],
        '08' => ['short' => 'Agu', 'name' => 'Agustus', 'has_dot' => true],
        '09' => ['short' => 'Sep', 'name' => 'September', 'has_dot' => true],
        '10' => ['short' => 'Okt', 'name' => 'Oktober', 'has_dot' => false],
        '11' => ['short' => 'Nov', 'name' => 'November', 'has_dot' => false],
        '12' => ['short' => 'Des', 'name' => 'Desember', 'has_dot' => false],
    ];

    public $showManageModal = false;
    public $newPeriodInput = '';

    public function mount()
    {
        $period = request()->query('period') ?: session('bsc_period', '2026-10');
        $mode = request()->query('mode') ?: session('bsc_mode', 'monthly');

        $this->parseAndSetPeriod($period);
        $this->viewMode = in_array($mode, ['monthly', 'ytd']) ? $mode : 'monthly';
        session(['bsc_period' => $this->selectedPeriod, 'bsc_mode' => $this->viewMode]);
    }

    public function parseAndSetPeriod($period)
    {
        if (preg_match('/^(\d{4})-(\d{2})$/', $period, $matches)) {
            $this->selectedYear = $matches[1];
            $this->selectedMonth = $matches[2];
            $this->selectedPeriod = $period;
        } else {
            $this->selectedYear = '2026';
            $this->selectedMonth = '10';
            $this->selectedPeriod = '2026-10';
        }
    }

    public function setYear($year)
    {
        $this->selectedYear = (string) $year;
        $this->updatePeriodAndDispatch();
    }

    public function setMonth($month)
    {
        $this->selectedMonth = str_pad((string) $month, 2, '0', STR_PAD_LEFT);
        $this->updatePeriodAndDispatch();
    }

    public function setViewMode($mode)
    {
        if (in_array($mode, ['monthly', 'ytd'])) {
            $this->viewMode = $mode;
            session(['bsc_mode' => $this->viewMode]);
            $this->dispatch('viewModeChanged', mode: $this->viewMode);
            $this->updateBrowserUrl();
        }
    }

    public function swapPriorYear()
    {
        $priorYear = (string) (((int) $this->selectedYear) === 2025 ? 2026 : ((int) $this->selectedYear - 1));
        $this->selectedYear = $priorYear;
        $this->updatePeriodAndDispatch();
    }

    protected function updatePeriodAndDispatch()
    {
        $this->selectedPeriod = $this->selectedYear . '-' . $this->selectedMonth;
        session(['bsc_period' => $this->selectedPeriod]);

        // Dispatch event to page components
        $this->dispatch('periodChanged', period: $this->selectedPeriod);
        $this->updateBrowserUrl();
    }

    protected function updateBrowserUrl()
    {
        $this->js("
            const url = new URL(window.location);
            url.searchParams.set('period', '{$this->selectedPeriod}');
            url.searchParams.set('mode', '{$this->viewMode}');
            window.history.pushState({}, '', url);
        ");
    }

    #[On('periodChanged')]
    public function syncPeriodFromExternal($period)
    {
        if ($period && $period !== $this->selectedPeriod) {
            $this->parseAndSetPeriod($period);
            session(['bsc_period' => $this->selectedPeriod]);
        }
    }

    #[On('viewModeChanged')]
    public function syncModeFromExternal($mode)
    {
        if ($mode && $mode !== $this->viewMode) {
            $this->viewMode = $mode;
            session(['bsc_mode' => $this->viewMode]);
        }
    }

    // Modal Period Management
    public function openManageModal()
    {
        $this->showManageModal = true;
    }

    public function closeManageModal()
    {
        $this->showManageModal = false;
        $this->newPeriodInput = '';
    }

    public function toggleStatus($periodStr)
    {
        $period = Period::where('period', $periodStr)->first();
        if ($period) {
            $newStatus = $period->status === 'OPEN' ? 'CLOSED' : 'OPEN';
            $period->update(['status' => $newStatus]);
            session()->flash('period_msg', "Status periode $periodStr diubah menjadi $newStatus.");
        }
    }

    public function createPeriod()
    {
        $this->validate([
            'newPeriodInput' => 'required|regex:/^\d{4}-\d{2}$/',
        ], [
            'newPeriodInput.required' => 'Format periode harus diisi.',
            'newPeriodInput.regex' => 'Format harus YYYY-MM (contoh: 2026-11).',
        ]);

        Period::firstOrCreate(
            ['period' => $this->newPeriodInput],
            ['status' => 'OPEN', 'apex_score' => 0.0]
        );

        $this->parseAndSetPeriod($this->newPeriodInput);
        $this->updatePeriodAndDispatch();
        $this->closeManageModal();
        session()->flash('period_msg', "Periode {$this->newPeriodInput} berhasil ditambahkan dan diaktifkan.");
    }

    public function render()
    {
        $priorYear = (int) $this->selectedYear - 1;
        $priorYearPeriod = $priorYear . '-' . $this->selectedMonth;
        $currentMonthName = $this->months[$this->selectedMonth]['name'] ?? 'Bulan ' . $this->selectedMonth;
        $allPeriods = Period::orderBy('period', 'desc')->get();

        return view('livewire.periodic-monitor', [
            'priorYearPeriod' => $priorYearPeriod,
            'currentMonthName' => $currentMonthName,
            'allPeriods' => $allPeriods,
        ]);
    }
}
