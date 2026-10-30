<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use App\Models\Period;

class CoaSimulation extends Component
{
    #[Url(as: 'period')]
    public $selectedPeriod = '2026-10';

    // Sandbox Adjustment Sliders (in Juta Rupiah)
    public $delta_1101 = 0; // Kas & Bank Utama
    public $delta_1102 = 0; // Piutang Usaha
    public $delta_4101 = 0; // Penjualan Produk

    public function mount()
    {
        $this->selectedPeriod = request()->query('period') ?: session('bsc_period', '2026-10');
    }

    #[On('periodChanged')]
    public function onPeriodChanged($period)
    {
        if ($period) {
            $this->selectedPeriod = $period;
            session(['bsc_period' => $period]);
        }
    }

    public function resetSimulation()
    {
        $this->delta_1101 = 0;
        $this->delta_1102 = 0;
        $this->delta_4101 = 0;

        session()->flash('message', 'Simulasi CoA berhasil di-rollback ke saldo aktual (Base SSOT).');
    }

    public function render()
    {
        // 1. Master Baseline 9 CoA Accounts
        $accounts = [
            [
                'code' => '1101',
                'name' => 'Kas & Bank Utama',
                'group' => 'Aktiva Lancar',
                'base' => 6394.57,
                'delta' => (float) $this->delta_1101,
            ],
            [
                'code' => '1102',
                'name' => 'Piutang Usaha (Distributor & Apotek)',
                'group' => 'Aktiva Lancar',
                'base' => 5072.60,
                'delta' => (float) $this->delta_1102,
            ],
            [
                'code' => '1103',
                'name' => 'Persediaan Bahan Baku & Barang Jadi',
                'group' => 'Aktiva Lancar',
                'base' => 7349.47,
                'delta' => 0.0,
            ],
            [
                'code' => '1201',
                'name' => 'Aset Tetap Pabrik & Mesin',
                'group' => 'Aktiva Tidak Lancar',
                'base' => 8765.69,
                'delta' => 0.0,
            ],
            [
                'code' => '2101',
                'name' => 'Utang Usaha & Pemasok Bahan',
                'group' => 'Kewajiban Lancar',
                'base' => 5492.51,
                'delta' => 0.0,
            ],
            [
                'code' => '3101',
                'name' => 'Modal Saham & Laba Ditahan',
                'group' => 'Ekuitas',
                'base' => 22821.82,
                'delta' => 0.0,
            ],
            [
                'code' => '4101',
                'name' => 'Penjualan Produk Herbal & Farmasi',
                'group' => 'Pendapatan Operasional',
                'base' => 553.53,
                'delta' => (float) $this->delta_4101,
            ],
            [
                'code' => '5101',
                'name' => 'Harga Pokok Penjualan (HPP)',
                'group' => 'Beban Pokok',
                'base' => 371.33,
                'delta' => 0.0,
            ],
            [
                'code' => '6101',
                'name' => 'Beban Operasional & Distribusi',
                'group' => 'Beban Usaha',
                'base' => 1.55,
                'delta' => 0.0,
            ],
        ];

        // Format and calculate simulation values
        $tableData = [];
        foreach ($accounts as $acc) {
            $simulated = $acc['base'] + $acc['delta'];
            $tableData[] = [
                'code' => $acc['code'],
                'name' => $acc['name'],
                'group' => $acc['group'],
                'base' => $acc['base'],
                'simulated' => $simulated,
                'delta' => $acc['delta'],
            ];
        }

        // 2. Financial Metrics Calculations
        // Base Net Profit: 553.53 - 371.33 - 1.55 = 180.65 (displayed as Rp 181 JT)
        $basePenjualan = 553.53;
        $hpp = 371.33;
        $opex = 1.55;

        $baseNetProfit = $basePenjualan - $hpp - $opex;
        $baseNpm = $basePenjualan > 0 ? ($baseNetProfit / $basePenjualan) * 100 : 0;

        $simPenjualan = $basePenjualan + (float)$this->delta_4101;
        $simNetProfit = $simPenjualan - $hpp - $opex;
        $simNpm = $simPenjualan > 0 ? ($simNetProfit / $simPenjualan) * 100 : 0;
        $npmDiff = $simNpm - $baseNpm;

        // Current Ratio: Current Assets / Current Liabilities (Utang 2101: 5492.51)
        $kewajibanLancar = 5492.51;
        $baseAktivaLancar = 6394.57 + 5072.60 + 7349.47;
        $baseCr = $kewajibanLancar > 0 ? $baseAktivaLancar / $kewajibanLancar : 0;

        $simAktivaLancar = (6394.57 + (float)$this->delta_1101) + (5072.60 + (float)$this->delta_1102) + 7349.47;
        $simCr = $kewajibanLancar > 0 ? $simAktivaLancar / $kewajibanLancar : 0;
        $crDiff = $simCr - $baseCr;

        return view('livewire.coa-simulation', [
            'tableData' => $tableData,
            'baseNpm' => $baseNpm,
            'simNpm' => $simNpm,
            'npmDiff' => $npmDiff,
            'baseCr' => $baseCr,
            'simCr' => $simCr,
            'crDiff' => $crDiff,
            'simNetProfit' => $simNetProfit,
            'selectedPeriod' => $this->selectedPeriod,
        ])->layout('layouts.app', ['title' => 'Simulasi CoA']);
    }
}

