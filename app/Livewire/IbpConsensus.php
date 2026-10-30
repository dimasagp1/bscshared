<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use App\Models\Period;

class IbpConsensus extends Component
{
    #[Url(as: 'period')]
    public $selectedPeriod = '2026-10';

    #[Url(as: 'step')]
    public $currentStep = 1;

    #[Url(as: 'full')]
    public $showAllSteps = false;

    public $isTransmitted = false;

    public function mount()
    {
        $this->selectedPeriod = request()->query('period') ?: session('bsc_period', '2026-10');
        if (request()->query('step')) {
            $this->currentStep = (int) request()->query('step');
        }
        if (request()->query('full')) {
            $this->showAllSteps = (bool) request()->query('full');
        }
    }

    #[On('periodChanged')]
    public function onPeriodChanged($period)
    {
        if ($period) {
            $this->selectedPeriod = $period;
            session(['bsc_period' => $period]);
        }
    }

    public function setStep($step)
    {
        $this->currentStep = (int) $step;
    }

    public function toggleShowAllSteps()
    {
        $this->showAllSteps = !$this->showAllSteps;
    }

    public function transmitToBsc()
    {
        $this->isTransmitted = true;
        session()->flash('message', 'Target Konsensus IBP sebesar Rp 59.200 JT Berhasil Ditransmisikan ke BSC Hop 4! Nilai baru telah mengalir ke 5 kelompok rasio dan sasaran mutu departemen.');
    }

    public function resetTransmission()
    {
        $this->isTransmitted = false;
        session()->flash('message', 'Status transmisi IBP di-reset kembali ke mode simulasi (draft).');
    }

    public function render()
    {
        // 1. Data Step 1: Product Review
        $skus = [
            [
                'name' => 'Herbalmmune Forte 60s',
                'category' => 'Suplemen Imunomodulator Herbal',
                'launch_quarter' => 'Q2 2026 LAUNCH',
                'launch_badge_color' => 'green',
                'target_est' => 'Rp 4.200 jt',
                'status_label' => 'BPOM Approved ✓',
                'status_color' => 'green',
            ],
            [
                'name' => 'Curcuma Hepato Guard',
                'category' => 'Ekstrak Temulawak & Perlindungan Liver',
                'launch_quarter' => 'Q3 2026 LAUNCH',
                'launch_badge_color' => 'blue',
                'target_est' => 'Rp 3.500 jt',
                'status_label' => 'Pilot Batch ⚙',
                'status_color' => 'blue',
            ],
            [
                'name' => 'Bio-Diabeta Extract',
                'category' => 'Formulasi Daun Insulin & Pare',
                'launch_quarter' => 'Q4 2026 LAUNCH',
                'launch_badge_color' => 'amber',
                'target_est' => 'Rp 2.800 jt',
                'status_label' => 'Uji Stabilitas ⚖',
                'status_color' => 'amber',
            ],
        ];

        // 2. Data Step 2: Demand Review Channels
        $demandChannels = [
            [
                'channel' => 'Distributor Besar Farmasi (PBF)',
                'volume' => 'Rp 34.200 JT',
                'share' => '54.7%',
                'growth' => '+5.2% YoY',
                'status' => 'Tervalidasi Kontrak',
            ],
            [
                'channel' => 'Jaringan Apotek & Retail Modern',
                'volume' => 'Rp 16.800 JT',
                'share' => '26.9%',
                'growth' => '+8.1% YoY',
                'status' => 'Program Promo Berjalan',
            ],
            [
                'channel' => 'E-Commerce & Direct-to-Consumer (D2C)',
                'volume' => 'Rp 7.500 JT',
                'share' => '12.0%',
                'growth' => '+14.0% YoY',
                'status' => 'Pertumbuhan Eksponensial',
            ],
            [
                'channel' => 'Institusi Rumah Sakit & Klinik',
                'volume' => 'Rp 4.000 JT',
                'share' => '6.4%',
                'growth' => 'Stabil',
                'status' => 'Tender Pengadaan',
            ],
        ];

        // 3. Data Step 3: Supply Review
        $supplyMetrics = [
            'utilization' => '94.2%',
            'max_capacity' => 'Rp 60.000 JT',
            'raw_material_otd' => '98.4%',
            'bottleneck' => 'Line Pengemasan Strip & Blister',
            'overtime_planned' => '24 Jam / Minggu',
        ];

        // 4. Data Step 4: Rekonsiliasi Finansial
        $financialReconciliation = [
            'bsc_current_target' => 'Rp 58.484,69 JT',
            'ibp_consensus_target' => 'Rp 59.200,00 JT',
            'variance_uplift' => '+Rp 715,31 JT (+1.2%)',
            'projected_gpm' => '31.5%',
            'target_gpm' => '30.0%',
            'projected_net_profit' => 'Rp 17.500 JT',
            'projected_npm' => '29.5%',
        ];

        // 5. Data Step 5: Management Business Review
        $executives = [
            ['role' => 'Direktur Utama (CEO)', 'name' => 'Dr. H. Bambang S.', 'status' => 'Disetujui (Approved)', 'time' => '28 Okt 2026, 09:30'],
            ['role' => 'Direktur Keuangan (CFO)', 'name' => 'Farhan Hidayat, SE, Ak.', 'status' => 'Disetujui (Approved)', 'time' => '28 Okt 2026, 10:15'],
            ['role' => 'Direktur Operasional (COO)', 'name' => 'Ir. Maya Rahayu', 'status' => 'Disetujui (Approved)', 'time' => '28 Okt 2026, 11:00'],
        ];

        return view('livewire.ibp-consensus', [
            'skus' => $skus,
            'demandChannels' => $demandChannels,
            'supplyMetrics' => $supplyMetrics,
            'financialReconciliation' => $financialReconciliation,
            'executives' => $executives,
        ])->layout('layouts.app', ['title' => 'Konsensus IBP']);
    }
}

