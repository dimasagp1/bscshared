<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\FinancialRatio;
use App\Models\DepartmentObjective;
use App\Models\ActionPlan;
use App\Models\Period;

class BscWiring extends Component
{
    #[Url(as: 'period')]
    public $selectedPeriod = '2026-08';

    public $revenueBaseline = 120.00; // Miliar IDR
    public $revenueActual = 115.20;   // Miliar IDR
    
    public $activeTab = 'flow'; // 'flow' (Diagram Alur Bezier Makro) or 'cascade' (Wiring Sasaran Mutu (64 KPI))
    public $cascadeValue = 80.000; // Value for Uji Kaskade Revenue slider (Rp 80.000 JT)
    public $selectedUnit = 'all'; // Unit kerja filter
    public $hanyaBergeser = false; // Checkbox filter

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $periods = Period::pluck('period')->toArray();
        $revenueDelta = round((($this->revenueActual - $this->revenueBaseline) / $this->revenueBaseline) * 100, 2);

        $ratios = FinancialRatio::where('period', $this->selectedPeriod)->get();
        $objectives = DepartmentObjective::where('period', $this->selectedPeriod)->get();
        $actionPlans = ActionPlan::with('objective')->get();

        // Group objectives by department
        $objectivesByDept = $objectives->groupBy('dept_code');

        // Dynamic perspective calculation from DB ratios
        $perspectiveDefinitions = [
            [
                'id' => 'profitability',
                'name' => 'Profitabilitas',
                'cat' => 'Profitabilitas',
                'ratios' => ['Return on Equity / ROE (%)', 'Net Profit Margin (%)', 'ROE', 'NPM'],
                'color' => '#10b981', 'bg' => '#ecfdf5', 'border' => '#a7f3d0',
            ],
            [
                'id' => 'revenue',
                'name' => 'Revenue / Pertumbuhan',
                'cat' => 'Profitabilitas',
                'ratios' => ['Sales Growth', 'Gross Profit Margin'],
                'color' => '#10b981', 'bg' => '#ecfdf5', 'border' => '#a7f3d0',
            ],
            [
                'id' => 'activity',
                'name' => 'Aktivitas',
                'cat' => 'Aktivitas',
                'ratios' => ['Inventory Turnover', 'Asset Turnover'],
                'color' => '#f59e0b', 'bg' => '#fffbeb', 'border' => '#fde68a',
            ],
            [
                'id' => 'productivity',
                'name' => 'Produktivitas',
                'cat' => 'Produktivitas',
                'ratios' => ['Revenue per Employee (Juta IDR)', 'Labor Productivity'],
                'color' => '#0284c7', 'bg' => '#f0f9ff', 'border' => '#bae6fd',
            ],
            [
                'id' => 'liquidity',
                'name' => 'Likuiditas',
                'cat' => 'Likuiditas',
                'ratios' => ['Current Ratio', 'Quick Ratio'],
                'color' => '#0d9488', 'bg' => '#f0fdf4', 'border' => '#99f6e4',
            ],
            [
                'id' => 'solvency',
                'name' => 'Solvabilitas',
                'cat' => 'Solvabilitas',
                'ratios' => ['Debt to Equity Ratio'],
                'color' => '#8b5cf6', 'bg' => '#f5f3ff', 'border' => '#ddd6fe',
            ],
        ];

        $perspectives = [];
        foreach ($perspectiveDefinitions as $def) {
            $catRatios = $ratios->filter(function($r) use ($def) {
                return $r->category === $def['cat'] || in_array($r->ratio_name, $def['ratios']);
            });
            $avgPct = $catRatios->count() > 0 ? $catRatios->avg('achievement_pct') : 100.0;
            $unitCount = $objectives->count();
            $scoreFormatted = number_format($avgPct / 100, 3, ',', '.');
            
            $perspectives[] = [
                'id' => $def['id'],
                'name' => $def['name'],
                'detail' => 'e ' . number_format($avgPct / 100, 2, ',', '.') . ' · ' . $catRatios->count() . ' rasio',
                'score' => $scoreFormatted,
                'color' => $avgPct >= 100 ? '#10b981' : ($avgPct >= 80 ? '#f59e0b' : '#e11d48'),
                'bg' => $def['bg'],
                'border' => $def['border'],
                'ratios' => $catRatios->pluck('ratio_name')->toArray(),
            ];
        }

        // Dynamic Department list calculation from DB objectives
        $deptMap = [
            'SCM' => 'Supply Chain',
            'PROC' => 'Procurement',
            'PROD' => 'Production & Engineering',
            'RND' => 'Research & Development',
            'MGT' => 'Quality (Manager)',
            'QC' => 'Quality Control',
            'QA' => 'Quality Assurance',
            'GAL' => 'General Affair & Legal',
            'HRD' => 'Human Capital',
            'FIN' => 'Finance & Accounting',
            'MKT' => 'Marketing & Sales',
        ];

        $departments = [];
        foreach ($deptMap as $code => $name) {
            $deptObjs = $objectivesByDept->get($code, collect());
            $sasaranCount = $deptObjs->count() > 0 ? $deptObjs->count() : 5;
            $bergeserCount = $deptObjs->where('status', '!=', 'Tercapai')->count();

            // Status dots based on real DB KPIs
            $dots = [];
            if ($deptObjs->count() > 0) {
                foreach ($deptObjs as $o) {
                    if ($o->status === 'Tercapai') $dots[] = '#10b981';
                    elseif ($o->status === 'Waspada') $dots[] = '#f59e0b';
                    else $dots[] = '#e11d48';
                }
            } else {
                $dots = ['#10b981', '#0284c7', '#f59e0b'];
            }

            $departments[] = [
                'code' => $code,
                'name' => $name,
                'sasaran' => $sasaranCount,
                'bergeser' => $bergeserCount,
                'dots' => array_slice($dots, 0, 4),
            ];
        }
        // Filter departments if unit kerja filter active or hanyaBergeser checkbox
        $filteredDepartments = collect($departments)->filter(function($d) {
            $matchUnit = $this->selectedUnit === 'all' || $d['code'] === $this->selectedUnit || $d['name'] === $this->selectedUnit;
            $matchBergeser = !$this->hanyaBergeser || $d['bergeser'] > 0;
            return $matchUnit && $matchBergeser;
        })->values()->toArray();

        // Detailed Department Cards with KPI items matching reference images
        $deptCards = [
            [
                'title' => 'Operation Manager',
                'code' => 'OPS',
                'sasaran_count' => '6 sasaran',
                'header_bg' => '#059669',
                'badge_bg' => '#ffffff',
                'badge_color' => '#059669',
                'kpis' => [
                    [
                        'code' => 'OPS-02',
                        'name' => 'Kontribusi biaya operasional terhadap omset',
                        'elasticity' => 'e 0,30',
                        'elasticity_type' => 'green',
                        'result' => '4,5 %',
                        'result_highlight' => false,
                        'left_accent' => '#64748b',
                    ],
                    [
                        'code' => 'OPS-04',
                        'name' => 'Pemastian sistem berjalan sesuai standar',
                        'elasticity' => 'dikunci',
                        'elasticity_type' => 'locked',
                        'result' => '0 kasus',
                        'result_highlight' => false,
                        'left_accent' => '#64748b',
                    ],
                    [
                        'code' => 'OPS-05',
                        'name' => 'Implementasi RFT di operasional sistem',
                        'elasticity' => 'dikunci',
                        'elasticity_type' => 'locked',
                        'result' => '0 kasus',
                        'result_highlight' => false,
                        'left_accent' => '#64748b',
                    ],
                    [
                        'code' => 'OPS-01',
                        'name' => 'Pemenuhan service level',
                        'elasticity' => 'e 0,50',
                        'elasticity_type' => 'yellow',
                        'result' => '85 %',
                        'result_highlight' => false,
                        'left_accent' => '#f59e0b',
                    ],
                    [
                        'code' => 'OPS-06',
                        'name' => 'Launching produk baru',
                        'elasticity' => 'e 1,00',
                        'elasticity_type' => 'green',
                        'result' => '10 produk',
                        'result_highlight' => false,
                        'left_accent' => '#f43f5e',
                    ],
                    [
                        'code' => 'OPS-03',
                        'name' => 'Cycle inventory turnover',
                        'elasticity' => 'e 0,50',
                        'elasticity_type' => 'yellow',
                        'result' => '5 x/thn',
                        'result_highlight' => false,
                        'left_accent' => '#f59e0b',
                    ],
                ]
            ],
            [
                'title' => 'Marketing & Sales Manager',
                'code' => 'MKT',
                'sasaran_count' => '8 sasaran',
                'header_bg' => '#0b192c',
                'badge_bg' => '#ffffff',
                'badge_color' => '#0b192c',
                'kpis' => [
                    [
                        'code' => 'MKT-01',
                        'name' => 'Capaian Omzet Penjualan Produk Utama Herbal',
                        'elasticity' => 'e 1,00',
                        'elasticity_type' => 'green',
                        'result' => '104,5 %',
                        'result_highlight' => true,
                        'left_accent' => '#f59e0b',
                    ],
                    [
                        'code' => 'MKT-02',
                        'name' => 'Penambahan Channel Distributor Baru (Cabang)',
                        'elasticity' => 'e 0,60',
                        'elasticity_type' => 'yellow',
                        'result' => '12 Cabang',
                        'result_highlight' => false,
                        'left_accent' => '#f59e0b',
                    ],
                ]
            ],
        ];

        // Filter deptCards based on selectedUnit
        $filteredDeptCards = collect($deptCards)->filter(function($c) {
            return $this->selectedUnit === 'all' || $c['code'] === $this->selectedUnit;
        })->values()->toArray();

        return view('livewire.bsc-wiring', [
            'periods' => $periods,
            'revenueDelta' => $revenueDelta,
            'ratios' => $ratios,
            'objectives' => $objectives,
            'objectivesByDept' => $objectivesByDept,
            'actionPlans' => $actionPlans,
            'perspectives' => $perspectives,
            'departments' => $departments,
            'filteredDepartments' => $filteredDepartments,
            'deptCards' => $deptCards,
            'filteredDeptCards' => $filteredDeptCards,
        ])->layout('layouts.app', ['title' => 'Wiring / Peta Hubungan']);
    }
}

