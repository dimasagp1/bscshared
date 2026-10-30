<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use App\Models\FinancialRatio;
use App\Models\DepartmentObjective;
use App\Models\ActionPlan;
use App\Models\Period;

class BscWiring extends Component
{
    #[Url(as: 'period')]
    public $selectedPeriod = '2026-10';

    // Active presentation tab: 'macro' (Wiring Rasio Makro) or 'kpi35' (Wiring Sasaran Mutu 35 KPI)
    public $activeTab = 'macro';

    // Slider for Target Revenue: -50% to +50% (baseline Rp 96.000 JT)
    public $revenueSliderPercent = 0;
    public $baselineRevenue = 96000; // In million IDR (Rp 96.000 JT)

    // Steppers for 5 Driver Ratios: adjustments in % (-20% to +20%)
    public $stepperAdjustments = [
        'profitabilitas' => 0,
        'aktivitas' => 0,
        'produktivitas' => 0,
        'likuiditas' => 0,
        'solvabilitas' => 0,
    ];

    // Selected node for interactive highlighting (null, or driver key, or dept code, or 'target_revenue')
    public ?string $selectedNode = null;

    // Filters for Mode 2 (Wiring Sasaran Mutu)
    public $selectedUnit = 'all'; // 'all' or department code
    public $hanyaBergeser = false;

    public function mount()
    {
        $this->selectedPeriod = request()->query('period') ?: session('bsc_period', '2026-10');
        
        // Support query param for initial tab if provided
        $tab = request()->query('tab');
        if ($tab === 'flow' || $tab === 'macro') {
            $this->activeTab = 'macro';
        } elseif ($tab === 'cascade' || $tab === 'kpi35') {
            $this->activeTab = 'kpi35';
        }
    }

    #[On('periodChanged')]
    public function onPeriodChanged($period)
    {
        if ($period) {
            $this->selectedPeriod = $period;
        }
    }

    public function switchTab($tab)
    {
        // Support both naming schemes ('macro'/'flow', 'kpi35'/'cascade')
        if ($tab === 'flow' || $tab === 'macro') {
            $this->activeTab = 'macro';
        } else {
            $this->activeTab = 'kpi35';
        }
    }

    public function adjustDriver($driverKey, $delta)
    {
        if (array_key_exists($driverKey, $this->stepperAdjustments)) {
            $newVal = $this->stepperAdjustments[$driverKey] + $delta;
            // Clamp between -50% and +50%
            $this->stepperAdjustments[$driverKey] = max(-50, min(50, $newVal));
        }
    }

    public function selectNode(?string $nodeKey)
    {
        if ($this->selectedNode === $nodeKey) {
            $this->selectedNode = null;
        } else {
            $this->selectedNode = $nodeKey;
        }
    }

    public function resetHighlight()
    {
        $this->selectedNode = null;
    }

    public function resetSimulation()
    {
        $this->revenueSliderPercent = 0;
        $this->stepperAdjustments = [
            'profitabilitas' => 0,
            'aktivitas' => 0,
            'produktivitas' => 0,
            'likuiditas' => 0,
            'solvabilitas' => 0,
        ];
        $this->selectedNode = null;
        session()->flash('message', 'Simulasi berhasil di-reset ke baseline target awal (k 1,000).');
    }

    /**
     * SSOT Driver Definitions
     */
    protected function getDriverDefinitions(): array
    {
        return [
            'profitabilitas' => [
                'key' => 'profitabilitas',
                'name' => 'Profitabilitas',
                'color' => '#10B981',
                'border' => '#A7F3D0',
                'bg' => '#ECFDF5',
                'dark_bg' => '#064E3B',
                'dark_border' => '#047857',
                'elasticity' => 0.78,
                'connected_units_count' => 9,
                'connected_depts' => ['FAT', 'GA', 'HC', 'OPS', 'PRC', 'PRD', 'QLT', 'RND', 'SCM'],
                'has_stepper' => true,
                'description' => 'Driver utama profitabilitas menopang margin laba bersih, efisiensi biaya, dan ROI di seluruh 9 unit operasional.',
            ],
            'revenue' => [
                'key' => 'revenue',
                'name' => 'Revenue',
                'color' => '#166534',
                'border' => '#BBF7D0',
                'bg' => '#F0FDF4',
                'dark_bg' => '#14532D',
                'dark_border' => '#166534',
                'elasticity' => 1.00,
                'connected_units_count' => 4,
                'connected_depts' => ['FAT', 'HC', 'OPS', 'SCM'],
                'has_stepper' => false,
                'description' => 'Driver transmisi langsung dari pertumbuhan omset penjualan ke unit komersial dan operasional inti.',
            ],
            'aktivitas' => [
                'key' => 'aktivitas',
                'name' => 'Aktivitas',
                'color' => '#F59E0B',
                'border' => '#FDE68A',
                'bg' => '#FFFBEB',
                'dark_bg' => '#78350F',
                'dark_border' => '#B45309',
                'elasticity' => 0.88,
                'connected_units_count' => 4,
                'connected_depts' => ['FAT', 'GA', 'OPS', 'SCM'],
                'has_stepper' => true,
                'description' => 'Driver perputaran aset, rasio penagihan, siklus persediaan, dan utilitas fasilitas pabrik.',
            ],
            'produktivitas' => [
                'key' => 'produktivitas',
                'name' => 'Produktivitas',
                'color' => '#0284C7',
                'border' => '#BAE6FD',
                'bg' => '#F0F9FF',
                'dark_bg' => '#0C4A6E',
                'dark_border' => '#0369A1',
                'elasticity' => 0.93,
                'connected_units_count' => 4,
                'connected_depts' => ['HC', 'PRC', 'PRD', 'QLT'],
                'has_stepper' => true,
                'description' => 'Driver efisiensi tenaga kerja per karyawan, yield manufaktur, dan penurunan defect rate produk.',
            ],
            'likuiditas' => [
                'key' => 'likuiditas',
                'name' => 'Likuiditas',
                'color' => '#0D9488',
                'border' => '#99F6E4',
                'bg' => '#F0FDF4',
                'dark_bg' => '#134E4A',
                'dark_border' => '#0F766E',
                'elasticity' => 0.50,
                'connected_units_count' => 2,
                'connected_depts' => ['FAT', 'SCM'],
                'has_stepper' => true,
                'description' => 'Driver kecukupan kas lancar, modal kerja, dan pembayaran vendor tepat termin.',
            ],
            'solvabilitas' => [
                'key' => 'solvabilitas',
                'name' => 'Solvabilitas',
                'color' => '#8B5CF6',
                'border' => '#DDD6FE',
                'bg' => '#F5F3FF',
                'dark_bg' => '#4C1D95',
                'dark_border' => '#6D28D9',
                'elasticity' => 0.20,
                'connected_units_count' => 1,
                'connected_depts' => ['FAT'],
                'has_stepper' => true,
                'description' => 'Driver rasio solvabilitas modal jangka panjang dan kepatuhan anggaran korporat.',
            ],
        ];
    }

    /**
     * SSOT 9 Departments Metadata
     */
    protected function getDepartmentDefinitions(): array
    {
        return [
            'FAT' => [
                'code' => 'FAT',
                'name' => 'Finance, Accounting & Tax',
                'drivers' => ['profitabilitas', 'revenue', 'likuiditas', 'solvabilitas'],
                'dots' => ['#10B981', '#166534', '#0D9488', '#8B5CF6'],
            ],
            'GA' => [
                'code' => 'GA',
                'name' => 'General Affair & Legal',
                'drivers' => ['profitabilitas', 'aktivitas'],
                'dots' => ['#F59E0B', '#10B981'],
            ],
            'HC' => [
                'code' => 'HC',
                'name' => 'Human Capital (HRD)',
                'drivers' => ['profitabilitas', 'revenue', 'produktivitas'],
                'dots' => ['#0284C7', '#10B981'],
            ],
            'OPS' => [
                'code' => 'OPS',
                'name' => 'Operations Manager',
                'drivers' => ['profitabilitas', 'revenue', 'aktivitas'],
                'dots' => ['#F59E0B', '#10B981'],
            ],
            'PRC' => [
                'code' => 'PRC',
                'name' => 'Procurement & Purchasing',
                'drivers' => ['profitabilitas', 'produktivitas'],
                'dots' => ['#0284C7', '#10B981'],
            ],
            'PRD' => [
                'code' => 'PRD',
                'name' => 'Production & Engineering',
                'drivers' => ['profitabilitas', 'produktivitas'],
                'dots' => ['#0284C7', '#10B981'],
            ],
            'QLT' => [
                'code' => 'QLT',
                'name' => 'Quality Management',
                'drivers' => ['profitabilitas', 'produktivitas'],
                'dots' => ['#0284C7', '#10B981'],
            ],
            'RND' => [
                'code' => 'RND',
                'name' => 'Research & Development',
                'drivers' => ['profitabilitas'],
                'dots' => ['#10B981'],
            ],
            'SCM' => [
                'code' => 'SCM',
                'name' => 'Supply Chain Management',
                'drivers' => ['profitabilitas', 'revenue', 'aktivitas', 'likuiditas'],
                'dots' => ['#F59E0B', '#0D9488', '#10B981'],
            ],
        ];
    }

    /**
     * SSOT 35 Sasaran Mutu (KPI) matching mockups
     */
    protected function getRaw35Kpis(): array
    {
        return [
            // Finance, Accounting & Tax (5 sasaran)
            [
                'dept_code' => 'FAT',
                'code' => 'FAT-01',
                'name' => 'Rasio penagihan invoice (collection ratio)',
                'drivers' => ['likuiditas', 'aktivitas'],
                'elasticity' => 0.50,
                'is_locked' => false,
                'baseline_target' => 98.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'FAT',
                'code' => 'FAT-05',
                'name' => 'Rasio denda & sanksi pajak',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.70,
                'is_locked' => false,
                'baseline_target' => 0.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'FAT',
                'code' => 'FAT-04',
                'name' => 'Rasio HPP produk',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.00,
                'is_locked' => true,
                'baseline_target' => 67.7,
                'unit' => '%',
            ],
            [
                'dept_code' => 'FAT',
                'code' => 'FAT-03',
                'name' => 'Rasio pembayaran tepat termin (vendor)',
                'drivers' => ['aktivitas', 'likuiditas'],
                'elasticity' => 0.30,
                'is_locked' => false,
                'baseline_target' => 98.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'FAT',
                'code' => 'FAT-02',
                'name' => 'Kesesuaian realisasi budget perusahaan',
                'drivers' => ['profitabilitas', 'solvabilitas'],
                'elasticity' => 0.50,
                'is_locked' => false,
                'baseline_target' => 50.0,
                'unit' => '%',
            ],

            // General Affair & Legal (4 sasaran)
            [
                'dept_code' => 'GA',
                'code' => 'GA-04',
                'name' => 'Akurasi stock opname secara berkala aset perusahaan',
                'drivers' => ['aktivitas', 'profitabilitas'],
                'elasticity' => 0.00,
                'is_locked' => true,
                'baseline_target' => 0.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'GA-03',
                'dept_code' => 'GA',
                'code' => 'GA-03',
                'name' => 'Efektivitas Pengendalian Hama (Pest Control Program Effectiveness)',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.00,
                'is_locked' => true,
                'baseline_target' => 0.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'GA',
                'code' => 'GA-02',
                'name' => 'Pengendalian Persediaan Barang Umum & ATK (General Supplies Inventory Control)',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.30,
                'is_locked' => false,
                'baseline_target' => 0.25,
                'unit' => '%',
            ],
            [
                'dept_code' => 'GA',
                'code' => 'GA-01',
                'name' => 'Efektivitas Pemantauan Perawatan Aset Perusahaan (Preventive Maintenance Compliance)',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.20,
                'is_locked' => false,
                'baseline_target' => 0.55,
                'unit' => '%',
            ],

            // Human Capital (HRD) (3 sasaran)
            [
                'dept_code' => 'HC',
                'code' => 'HC-02',
                'name' => 'Peningkatan Produktivitas Karyawan (Revenue per Employee)',
                'drivers' => ['produktivitas'],
                'elasticity' => 0.70,
                'is_locked' => false,
                'baseline_target' => 10.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'HC',
                'code' => 'HC-03',
                'name' => 'Pengendalian Biaya Lembur (Overtime Cost Control)',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.30,
                'is_locked' => false,
                'baseline_target' => 0.1,
                'unit' => '%',
            ],
            [
                'dept_code' => 'HC',
                'code' => 'HC-01',
                'name' => 'Efisiensi Rasio Biaya Tenaga Kerja terhadap Pendapatan (Manpower Cost to Revenue Ratio)',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.70,
                'is_locked' => false,
                'baseline_target' => 8.0,
                'unit' => '%',
            ],

            // Operations Manager (5 sasaran)
            [
                'dept_code' => 'OPS',
                'code' => 'OPS-05',
                'name' => 'Kontribusi NPD terhadap total omset',
                'drivers' => ['profitabilitas'],
                'elasticity' => 1.00,
                'is_locked' => false,
                'baseline_target' => 15.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'OPS',
                'code' => 'OPS-04',
                'name' => 'Right First Time Implementation',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.00,
                'is_locked' => true,
                'baseline_target' => 0.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'OPS',
                'code' => 'OPS-03',
                'name' => 'Minimal cycle inventory turn over dari 4 x menjadi 5 x per tahun',
                'drivers' => ['aktivitas'],
                'elasticity' => 0.50,
                'is_locked' => false,
                'baseline_target' => 5.0,
                'unit' => 'Kali',
            ],
            [
                'dept_code' => 'OPS',
                'code' => 'OPS-01',
                'name' => 'Pemenuhan Service level - On-time delivery - In-full delivery - Damage-free delivery - Accurate documentation',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.50,
                'is_locked' => false,
                'baseline_target' => 90.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'OPS',
                'code' => 'OPS-02',
                'name' => 'Menjaga rasio produktivitas Labor & Overhead terhadap sales output per bulan',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.30,
                'is_locked' => false,
                'baseline_target' => 4.5,
                'unit' => '%',
            ],

            // Procurement & Purchasing (4 sasaran)
            [
                'dept_code' => 'PRC',
                'code' => 'PRC-04',
                'name' => 'Rasio pembelian Darurat',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.30,
                'is_locked' => false,
                'baseline_target' => 5.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'PRC',
                'code' => 'PRC-01',
                'name' => 'Ketepatan Pengadaan Material (waktu, spesifikasi dan jumlah)',
                'drivers' => ['profitabilitas', 'produktivitas'],
                'elasticity' => 0.00,
                'is_locked' => true,
                'baseline_target' => 0.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'PRC',
                'code' => 'PRC-02',
                'name' => 'Ketepatan Harga Beli Material',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.00,
                'is_locked' => true,
                'baseline_target' => 67.7,
                'unit' => '%',
            ],
            [
                'dept_code' => 'PRC',
                'code' => 'PRC-03',
                'name' => 'Efisiensi Harga Pengadaan Pendukung',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.00,
                'is_locked' => true,
                'baseline_target' => 0.51,
                'unit' => '%',
            ],

            // Production & Engineering (4 sasaran)
            [
                'dept_code' => 'PRD',
                'code' => 'PRD-03',
                'name' => 'Pencapaian standard yield produksi',
                'drivers' => ['produktivitas'],
                'elasticity' => 0.50,
                'is_locked' => false,
                'baseline_target' => 67.7,
                'unit' => '%',
            ],
            [
                'dept_code' => 'PRD',
                'code' => 'PRD-01',
                'name' => 'Pencapaian realisasi produksi sesuai planning dari PPIC',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.50,
                'is_locked' => false,
                'baseline_target' => 100.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'PRD',
                'code' => 'PRD-04',
                'name' => 'Implementasi Right First Time (RFT) di line produksi',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.50,
                'is_locked' => false,
                'baseline_target' => 0.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'PRD',
                'code' => 'PRD-02',
                'name' => 'Peningkatan productivity karyawan',
                'drivers' => ['produktivitas'],
                'elasticity' => 0.50,
                'is_locked' => false,
                'baseline_target' => 95.0,
                'unit' => '%',
            ],

            // Quality Management (4 sasaran)
            [
                'dept_code' => 'QLT',
                'code' => 'QLT-01',
                'name' => 'Right First Time In Process Control (Material test & In line process control)',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.00,
                'is_locked' => true,
                'baseline_target' => 0.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'QLT',
                'code' => 'QLT-02',
                'name' => 'Pemenuhan Product Compliance',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.00,
                'is_locked' => true,
                'baseline_target' => 0.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'QLT',
                'code' => 'QLT-04',
                'name' => 'Defect Rate Product',
                'drivers' => ['produktivitas'],
                'elasticity' => 0.30,
                'is_locked' => false,
                'baseline_target' => 1.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'QLT',
                'code' => 'QLT-03',
                'name' => 'Pemenuhan zero recall',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.00,
                'is_locked' => true,
                'baseline_target' => 0.0,
                'unit' => '%',
            ],

            // Research & Development (3 sasaran)
            [
                'dept_code' => 'RND',
                'code' => 'RND-01',
                'name' => 'Time-to-market produk baru',
                'drivers' => ['profitabilitas'],
                'elasticity' => 1.00,
                'is_locked' => false,
                'baseline_target' => 15.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'RND',
                'code' => 'RND-02',
                'name' => 'First-pass development test rate',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.50,
                'is_locked' => false,
                'baseline_target' => 0.1,
                'unit' => '%',
            ],
            [
                'dept_code' => 'RND',
                'code' => 'RND-03',
                'name' => 'Memastikan RFT NPD Launched',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.00,
                'is_locked' => true,
                'baseline_target' => 0.0,
                'unit' => '%',
            ],

            // Supply Chain Management (3 sasaran)
            [
                'dept_code' => 'SCM',
                'code' => 'SC-03',
                'name' => 'Akurasi stock opname secara berkala',
                'drivers' => ['aktivitas', 'likuiditas'],
                'elasticity' => 0.50,
                'is_locked' => false,
                'baseline_target' => 0.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'SCM',
                'code' => 'SC-02',
                'name' => 'Rasio kerusakan material selama penyimpanan',
                'drivers' => ['profitabilitas'],
                'elasticity' => 0.00,
                'is_locked' => true,
                'baseline_target' => 0.0,
                'unit' => '%',
            ],
            [
                'dept_code' => 'SCM',
                'code' => 'SC-01',
                'name' => 'Akurasi Perencanaan Produksi',
                'drivers' => ['profitabilitas', 'aktivitas'],
                'elasticity' => 0.50,
                'is_locked' => false,
                'baseline_target' => 1.0,
                'unit' => '%',
            ],
        ];
    }

    public function render()
    {
        // 1. Apex Revenue Calculations
        $deltaR = $this->revenueSliderPercent / 100.0;
        $kRevenue = 1.000 + $deltaR;
        $simulatedRevenueValue = round($this->baselineRevenue * $kRevenue);

        // 2. Drivers Calculation with Elasticity & Stepper Adjustments
        $driversDef = $this->getDriverDefinitions();
        $calculatedDrivers = [];
        foreach ($driversDef as $key => $d) {
            $stepperAdj = ($this->stepperAdjustments[$key] ?? 0) / 100.0;
            // k_driver = 1.000 + (deltaR * e) + stepperAdj
            $kDriver = 1.000 + ($deltaR * $d['elasticity']) + $stepperAdj;
            $deltaPercent = round(($kDriver - 1.000) * 100, 1);

            $calculatedDrivers[$key] = array_merge($d, [
                'k' => $kDriver,
                'k_formatted' => number_format($kDriver, 3, ',', '.'),
                'delta_percent' => $deltaPercent,
                'stepper_percent' => $this->stepperAdjustments[$key] ?? 0,
            ]);
        }

        // 3. 35 KPIs Calculation
        $rawKpis = $this->getRaw35Kpis();
        $calculatedKpis = [];
        $totalShiftedCount = 0;
        $shiftedKpisList = [];

        foreach ($rawKpis as $kpi) {
            if ($kpi['is_locked']) {
                $deltaKpi = 0.0;
                $simTarget = $kpi['baseline_target'];
                $isShifted = false;
            } else {
                // Average delta of parent drivers
                $parentDeltas = [];
                foreach ($kpi['drivers'] as $pDriver) {
                    if (isset($calculatedDrivers[$pDriver])) {
                        $parentDeltas[] = $calculatedDrivers[$pDriver]['k'] - 1.000;
                    }
                }
                $avgDriverDelta = count($parentDeltas) > 0 ? (array_sum($parentDeltas) / count($parentDeltas)) : 0.0;
                $deltaKpi = $avgDriverDelta * $kpi['elasticity'];
                $simTarget = round($kpi['baseline_target'] * (1.000 + $deltaKpi), 2);
                $isShifted = abs($deltaKpi) > 0.0001 && $kpi['baseline_target'] > 0;
                // If baseline is 0% but has delta, it's also shifted if non-zero delta
                if ($kpi['baseline_target'] == 0 && abs($deltaKpi) > 0.0001) {
                    $simTarget = round($deltaKpi * 100, 2);
                    $isShifted = true;
                }
            }

            $kpiItem = array_merge($kpi, [
                'sim_target' => $simTarget,
                'delta_kpi_pct' => round($deltaKpi * 100, 2),
                'is_shifted' => $isShifted,
            ]);

            $calculatedKpis[] = $kpiItem;

            if ($isShifted) {
                $totalShiftedCount++;
                $shiftedKpisList[] = $kpiItem;
            }
        }

        // 4. Group by Department
        $departmentsDef = $this->getDepartmentDefinitions();
        $kpisByDept = collect($calculatedKpis)->groupBy('dept_code');

        $calculatedDepartments = [];
        foreach ($departmentsDef as $deptCode => $dept) {
            $deptKpis = $kpisByDept->get($deptCode, collect());
            $deptShiftedCount = $deptKpis->where('is_shifted', true)->count();

            $calculatedDepartments[$deptCode] = array_merge($dept, [
                'kpis' => $deptKpis->values()->toArray(),
                'total_sasaran' => $deptKpis->count(),
                'shifted_sasaran' => $deptShiftedCount,
            ]);
        }

        // Filtered Departments for Mode 2 (Wiring Sasaran Mutu)
        $filteredDepartments = collect($calculatedDepartments)->filter(function($d) {
            $matchUnit = ($this->selectedUnit === 'all' || $d['code'] === $this->selectedUnit);
            $matchBergeser = (!$this->hanyaBergeser || $d['shifted_sasaran'] > 0);
            return $matchUnit && $matchBergeser;
        })->toArray();

        // 5. Selected Node Detail for Bottom Right Panel
        $selectedNodeDetail = null;
        if ($this->selectedNode) {
            if ($this->selectedNode === 'target_revenue') {
                $selectedNodeDetail = [
                    'type' => 'apex',
                    'title' => 'Target Revenue Konsolidasi',
                    'subtitle' => 'Puncak Transmisi Apex (BSC Hop 1)',
                    'k_val' => number_format($kRevenue, 3, ',', '.'),
                    'delta_pct' => round($deltaR * 100, 1),
                    'elasticity' => '1,00',
                    'units_count' => 9,
                    'targets_count' => 35,
                    'description' => 'Target Revenue bertindak sebagai sumber energi transmisi utama. Perubahan target revenue mengalirkan dorongan proporsional ke 6 kelompok rasio driver.',
                ];
            } elseif (isset($calculatedDrivers[$this->selectedNode])) {
                $d = $calculatedDrivers[$this->selectedNode];
                $selectedNodeDetail = [
                    'type' => 'driver',
                    'title' => 'Kelompok Rasio Driver: ' . $d['name'],
                    'subtitle' => 'Transmisi Tingkat 2 (BSC Hop 2)',
                    'k_val' => $d['k_formatted'],
                    'delta_pct' => $d['delta_percent'],
                    'elasticity' => number_format($d['elasticity'], 2, ',', '.'),
                    'units_count' => $d['connected_units_count'],
                    'targets_count' => collect($calculatedKpis)->filter(fn($k) => in_array($this->selectedNode, $k['drivers']))->count(),
                    'connected_units_names' => array_map(fn($code) => $departmentsDef[$code]['name'] ?? $code, $d['connected_depts']),
                    'description' => $d['description'],
                ];
            } elseif (isset($calculatedDepartments[$this->selectedNode])) {
                $dept = $calculatedDepartments[$this->selectedNode];
                $selectedNodeDetail = [
                    'type' => 'department',
                    'title' => 'Unit Kerja: ' . $dept['name'],
                    'subtitle' => 'Transmisi Tingkat 3 (BSC Hop 3/4)',
                    'k_val' => '-',
                    'delta_pct' => 0,
                    'elasticity' => '-',
                    'units_count' => 1,
                    'targets_count' => $dept['total_sasaran'],
                    'shifted_count' => $dept['shifted_sasaran'],
                    'feeding_drivers' => array_map(fn($k) => $calculatedDrivers[$k]['name'] ?? $k, $dept['drivers']),
                    'description' => 'Departemen ' . $dept['name'] . ' menampung ' . $dept['total_sasaran'] . ' sasaran mutu HRIS yang disadap dari kelompok rasio penggerak.',
                ];
            }
        }

        return view('livewire.bsc-wiring', [
            'simulatedRevenueValue' => $simulatedRevenueValue,
            'kRevenue' => $kRevenue,
            'kRevenueFormatted' => number_format($kRevenue, 3, ',', '.'),
            'deltaRPercent' => round($deltaR * 100, 1),
            'drivers' => $calculatedDrivers,
            'departments' => $calculatedDepartments,
            'filteredDepartments' => $filteredDepartments,
            'totalShiftedCount' => $totalShiftedCount,
            'shiftedKpisList' => $shiftedKpisList,
            'selectedNodeDetail' => $selectedNodeDetail,
        ]);
    }
}
