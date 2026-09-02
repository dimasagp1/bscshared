<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Period;
use App\Models\FinancialRatio;
use App\Models\DepartmentObjective;
use App\Models\ActionPlan;
use App\Models\StagingLog;

class BscDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Period
        $period = Period::updateOrCreate(
            ['period' => '2026-08'],
            [
                'status' => 'OPEN',
                'apex_score' => 96.50,
            ]
        );

        // 2. Financial Ratios
        $ratios = [
            [
                'period' => '2026-08',
                'category' => 'Likuiditas',
                'ratio_name' => 'Current Ratio',
                'target' => 2.00,
                'actual' => 2.10,
                'achievement_pct' => 100.00,
                'status' => 'Tercapai',
            ],
            [
                'period' => '2026-08',
                'category' => 'Likuiditas',
                'ratio_name' => 'Quick Ratio',
                'target' => 1.50,
                'actual' => 1.45,
                'achievement_pct' => 96.67,
                'status' => 'Waspada',
            ],
            [
                'period' => '2026-08',
                'category' => 'Solvabilitas',
                'ratio_name' => 'Debt to Equity Ratio',
                'target' => 0.80,
                'actual' => 0.75,
                'achievement_pct' => 100.00,
                'status' => 'Tercapai',
            ],
            [
                'period' => '2026-08',
                'category' => 'Aktivitas',
                'ratio_name' => 'Inventory Turnover',
                'target' => 6.00,
                'actual' => 5.80,
                'achievement_pct' => 96.67,
                'status' => 'Waspada',
            ],
            [
                'period' => '2026-08',
                'category' => 'Profitabilitas',
                'ratio_name' => 'Net Profit Margin (%)',
                'target' => 15.00,
                'actual' => 14.80,
                'achievement_pct' => 98.67,
                'status' => 'Waspada',
            ],
            [
                'period' => '2026-08',
                'category' => 'Profitabilitas',
                'ratio_name' => 'Return on Equity / ROE (%)',
                'target' => 18.00,
                'actual' => 18.50,
                'achievement_pct' => 100.00,
                'status' => 'Tercapai',
            ],
            [
                'period' => '2026-08',
                'category' => 'Produktivitas',
                'ratio_name' => 'Revenue per Employee (Juta IDR)',
                'target' => 120.00,
                'actual' => 118.00,
                'achievement_pct' => 98.33,
                'status' => 'Waspada',
            ],
        ];

        foreach ($ratios as $r) {
            FinancialRatio::updateOrCreate(
                ['period' => $r['period'], 'ratio_name' => $r['ratio_name']],
                $r
            );
        }

        // 3. Department Objectives
        $objectives = [
            [
                'period' => '2026-08',
                'dept_code' => 'OPS',
                'kpi_code' => 'OPS-02',
                'kpi_name' => 'Kontribusi biaya operasional terhadap omset',
                'polarity' => 'Turun',
                'target' => 5.00,
                'actual' => 4.50,
                'achievement_pct' => 100.00,
                'status' => 'Tercapai',
            ],
            [
                'period' => '2026-08',
                'dept_code' => 'OPS',
                'kpi_code' => 'OPS-04',
                'kpi_name' => 'Pemastian sistem berjalan sesuai standar',
                'polarity' => 'Turun',
                'target' => 0.00,
                'actual' => 0.00,
                'achievement_pct' => 100.00,
                'status' => 'Tercapai',
            ],
            [
                'period' => '2026-08',
                'dept_code' => 'OPS',
                'kpi_code' => 'OPS-05',
                'kpi_name' => 'Implementasi RFT di operasional sistem',
                'polarity' => 'Turun',
                'target' => 0.00,
                'actual' => 0.00,
                'achievement_pct' => 100.00,
                'status' => 'Tercapai',
            ],
            [
                'period' => '2026-08',
                'dept_code' => 'OPS',
                'kpi_code' => 'OPS-01',
                'kpi_name' => 'Pemenuhan service level',
                'polarity' => 'Naik',
                'target' => 90.00,
                'actual' => 85.00,
                'achievement_pct' => 94.44,
                'status' => 'Waspada',
            ],
            [
                'period' => '2026-08',
                'dept_code' => 'OPS',
                'kpi_code' => 'OPS-06',
                'kpi_name' => 'Launching produk baru',
                'polarity' => 'Naik',
                'target' => 10.00,
                'actual' => 10.00,
                'achievement_pct' => 100.00,
                'status' => 'Tercapai',
            ],
            [
                'period' => '2026-08',
                'dept_code' => 'OPS',
                'kpi_code' => 'OPS-03',
                'kpi_name' => 'Cycle inventory turnover',
                'polarity' => 'Naik',
                'target' => 6.00,
                'actual' => 5.00,
                'achievement_pct' => 83.33,
                'status' => 'Waspada',
            ],
            [
                'period' => '2026-08',
                'dept_code' => 'MKT',
                'kpi_code' => 'MKT-01',
                'kpi_name' => 'Capaian Omzet Penjualan Produk Utama Herbal',
                'polarity' => 'Naik',
                'target' => 100.00,
                'actual' => 104.50,
                'achievement_pct' => 104.50,
                'status' => 'Tercapai',
            ],
            [
                'period' => '2026-08',
                'dept_code' => 'MKT',
                'kpi_code' => 'MKT-02',
                'kpi_name' => 'Penambahan Channel Distributor Baru (Cabang)',
                'polarity' => 'Naik',
                'target' => 15.00,
                'actual' => 12.00,
                'achievement_pct' => 80.00,
                'status' => 'Waspada',
            ],
        ];

        foreach ($objectives as $objData) {
            $obj = DepartmentObjective::updateOrCreate(
                ['period' => $objData['period'], 'kpi_code' => $objData['kpi_code']],
                $objData
            );

            // Action Plans for specific objectives
            if ($objData['kpi_code'] === 'KPI-HRD-001') {
                ActionPlan::updateOrCreate(
                    ['department_objective_id' => $obj->id, 'title' => 'Program Intensifikasi Pelatihan Teknis Produksi & K3'],
                    [
                        'owner_dept' => 'HRD',
                        'progress_pct' => 75,
                        'status' => 'On Progress',
                    ]
                );
            } elseif ($objData['kpi_code'] === 'KPI-PROD-001') {
                ActionPlan::updateOrCreate(
                    ['department_objective_id' => $obj->id, 'title' => 'Kalibrasi Ulang Mesin Utama Line 2'],
                    [
                        'owner_dept' => 'PROD',
                        'progress_pct' => 90,
                        'status' => 'On Progress',
                    ]
                );
            } elseif ($objData['kpi_code'] === 'KPI-MKT-001') {
                ActionPlan::updateOrCreate(
                    ['department_objective_id' => $obj->id, 'title' => 'Kampanye Digital Marketing Q3 Produk Herbal'],
                    [
                        'owner_dept' => 'MKT',
                        'progress_pct' => 100,
                        'status' => 'Completed',
                    ]
                );
            }
        }

        // 4. Staging Logs
        StagingLog::updateOrCreate(
            ['idempotency_key' => 'IDEMP-PROD-202608-001'],
            [
                'period' => '2026-08',
                'dept_code' => 'PROD',
                'status' => 'SCORED',
                'source_version' => 1,
                'message' => 'Data realisasi produksi berhasil dihitung dan diterbitkan.',
            ]
        );

        StagingLog::updateOrCreate(
            ['idempotency_key' => 'IDEMP-HRD-202608-001'],
            [
                'period' => '2026-08',
                'dept_code' => 'HRD',
                'status' => 'DELIVERED',
                'source_version' => 1,
                'message' => 'Data jam pelatihan diterima dari HRIS, dalam antrean skoring.',
            ]
        );
    }
}
