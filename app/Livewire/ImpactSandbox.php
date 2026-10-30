<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use App\Models\Period;

class ImpactSandbox extends Component
{
    #[Url(as: 'period')]
    public $selectedPeriod = '2026-10';

    #[Url(as: 'kpi')]
    public $selectedKpi = 'FAT-01';

    public $simulatedKpiValue = 88.2;
    public $activeTab = 'diagram'; // diagram, table, journal, ledger
    public $isCalculated = false;

    public function mount()
    {
        $this->selectedPeriod = request()->query('period') ?: session('bsc_period', '2026-10');
        if (request()->query('kpi')) {
            $this->selectedKpi = request()->query('kpi');
        }
        $this->syncKpiDefaults();
    }

    #[On('periodChanged')]
    public function onPeriodChanged($period)
    {
        if ($period) {
            $this->selectedPeriod = $period;
            session(['bsc_period' => $period]);
        }
    }

    public function updatedSelectedKpi()
    {
        $this->syncKpiDefaults();
        $this->isCalculated = false;
    }

    protected function syncKpiDefaults()
    {
        $kpiMap = [
            'FAT-01' => 88.2,
            'FAT-02' => 78.5,
            'OPS-01' => 92.0,
            'HC-01' => 9.5,
            'SCM-01' => 4.5,
            'QLT-04' => 2.4,
        ];
        $this->simulatedKpiValue = $kpiMap[$this->selectedKpi] ?? 85.0;
    }

    public function calculateTransmission()
    {
        $this->isCalculated = true;
        session()->flash('message', "Kalkulasi transmisi 3-hop untuk {$this->selectedKpi} berhasil dihitung! Dampak ke pos CoA dan Rasio Keuangan telah terpetakan.");
    }

    public function resetTransmission()
    {
        $this->isCalculated = false;
        $this->syncKpiDefaults();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $kpis = [
            'FAT-01' => [
                'code' => 'FAT-01',
                'name' => 'Rasio penagihan invoice (collection ratio)',
                'dept' => 'Finance, Accounting & Tax',
                'target' => 98,
                'polarity' => 'UP',
                'unit' => '%',
                'target_badge' => '98% Target',
                'hop2_coa' => [
                    ['code' => '1102', 'name' => 'Piutang Usaha (Distributor & Apotek)', 'effect' => 'Bertambah / Tertahan +Rp 450 JT', 'type' => 'negative'],
                    ['code' => '1101', 'name' => 'Kas & Bank Utama', 'effect' => 'Berkurang -Rp 450 JT (Cash Inflow Tertunda)', 'type' => 'negative'],
                ],
                'hop3_ratios' => [
                    ['code' => 'DSO', 'name' => 'Days Sales Outstanding', 'baseline' => '26.4 hari', 'simulated' => '34.2 hari', 'impact' => 'Memburuk (+7.8 hari)', 'status' => 'Waspada'],
                    ['code' => 'CASH_R', 'name' => 'Cash Ratio', 'baseline' => '116.4%', 'simulated' => '108.2%', 'impact' => 'Turun (-8.2%)', 'status' => 'Tercapai'],
                    ['code' => 'CR', 'name' => 'Current Ratio', 'baseline' => '3.43x', 'simulated' => '3.43x', 'impact' => 'Netral (0.0x)', 'status' => 'Tercapai'],
                ],
                'journal' => [
                    ['account' => '1102 - Piutang Usaha', 'debet' => 'Rp 450.000.000', 'kredit' => '-'],
                    ['account' => '1101 - Kas & Bank Utama', 'debet' => '-', 'kredit' => 'Rp 450.000.000'],
                ],
            ],
            'FAT-02' => [
                'code' => 'FAT-02',
                'name' => 'Rasio pembayaran tepat termin (vendor)',
                'dept' => 'Finance, Accounting & Tax',
                'target' => 95,
                'polarity' => 'UP',
                'unit' => '%',
                'target_badge' => '95% Target',
                'hop2_coa' => [
                    ['code' => '2101', 'name' => 'Utang Usaha & Pemasok Bahan', 'effect' => 'Bertambah +Rp 620 JT', 'type' => 'negative'],
                    ['code' => '1101', 'name' => 'Kas & Bank Utama', 'effect' => 'Bertahan Sementara +Rp 620 JT', 'type' => 'positive'],
                ],
                'hop3_ratios' => [
                    ['code' => 'DPO', 'name' => 'Days Payable Outstanding', 'baseline' => '15.4 hari', 'simulated' => '21.0 hari', 'impact' => 'Membaik (+5.6 hari)', 'status' => 'Waspada'],
                    ['code' => 'CR', 'name' => 'Current Ratio', 'baseline' => '3.43x', 'simulated' => '3.15x', 'impact' => 'Turun (-0.28x)', 'status' => 'Waspada'],
                ],
                'journal' => [
                    ['account' => '2101 - Utang Usaha', 'debet' => '-', 'kredit' => 'Rp 620.000.000'],
                    ['account' => '1101 - Kas & Bank Utama', 'debet' => 'Rp 620.000.000', 'kredit' => '-'],
                ],
            ],
            'OPS-01' => [
                'code' => 'OPS-01',
                'name' => 'Pemenuhan service level line produksi',
                'dept' => 'Operations Manager',
                'target' => 99,
                'polarity' => 'UP',
                'unit' => '%',
                'target_badge' => '99% Target',
                'hop2_coa' => [
                    ['code' => '1103', 'name' => 'Persediaan Bahan Baku & Barang Jadi', 'effect' => 'Akumulasi WIP Tertahan +Rp 380 JT', 'type' => 'negative'],
                    ['code' => '4101', 'name' => 'Penjualan Produk Herbal & Farmasi', 'effect' => 'Potensi Penjualan Tertunda -Rp 380 JT', 'type' => 'negative'],
                ],
                'hop3_ratios' => [
                    ['code' => 'ITO', 'name' => 'Inventory Turnover', 'baseline' => '6.00x', 'simulated' => '5.20x', 'impact' => 'Melambat (-0.80x)', 'status' => 'Tercapai'],
                    ['code' => 'DIO', 'name' => 'Days Inventory Outstanding', 'baseline' => '55.7 hari', 'simulated' => '64.5 hari', 'impact' => 'Meningkat (+8.8 hari)', 'status' => 'Tercapai'],
                ],
                'journal' => [
                    ['account' => '1103 - Persediaan Barang Jadi', 'debet' => 'Rp 380.000.000', 'kredit' => '-'],
                    ['account' => '4101 - Penjualan Produk', 'debet' => '-', 'kredit' => 'Rp 380.000.000'],
                ],
            ],
            'HC-01' => [
                'code' => 'HC-01',
                'name' => 'Efisiensi rasio biaya tenaga kerja terhadap omset',
                'dept' => 'Human Capital (HRD)',
                'target' => 8,
                'polarity' => 'DOWN',
                'unit' => '%',
                'target_badge' => '8% Target',
                'hop2_coa' => [
                    ['code' => '6101', 'name' => 'Beban Operasional & Upah Karyawan', 'effect' => 'Kenaikan Beban Lembur +Rp 120 JT', 'type' => 'negative'],
                ],
                'hop3_ratios' => [
                    ['code' => 'PROD_LABOR_COST', 'name' => 'Produktivitas per Biaya Tenaga Kerja', 'baseline' => '22.02x', 'simulated' => '19.40x', 'impact' => 'Turun (-2.62x)', 'status' => 'Waspada'],
                    ['code' => 'NPM', 'name' => 'Net Profit Margin', 'baseline' => '28.53%', 'simulated' => '27.80%', 'impact' => 'Turun (-0.73%)', 'status' => 'Tercapai'],
                ],
                'journal' => [
                    ['account' => '6101 - Beban Gaji & Lembur', 'debet' => 'Rp 120.000.000', 'kredit' => '-'],
                    ['account' => '1101 - Kas & Bank Utama', 'debet' => '-', 'kredit' => 'Rp 120.000.000'],
                ],
            ],
        ];

        $currentKpi = $kpis[$this->selectedKpi] ?? $kpis['FAT-01'];

        return view('livewire.impact-sandbox', [
            'kpis' => $kpis,
            'currentKpi' => $currentKpi,
            'selectedPeriod' => $this->selectedPeriod,
        ])->layout('layouts.app', ['title' => 'Uji Dampak Transmisi']);
    }
}

