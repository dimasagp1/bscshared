<?php

namespace App\Livewire;

use Livewire\Component;

class SensitivityAnalysis extends Component
{
    public $tighteningPct = 0; // 0 to 40%
    public $scenario = 'baseline'; // baseline, moderate, severe

    public function setScenario($scenario)
    {
        $this->scenario = $scenario;
        if ($scenario === 'baseline') {
            $this->tighteningPct = 0;
        } elseif ($scenario === 'moderate') {
            $this->tighteningPct = 15;
        } elseif ($scenario === 'severe') {
            $this->tighteningPct = 35;
        }
    }

    public function resetCalibration()
    {
        $this->tighteningPct = 0;
        $this->scenario = 'baseline';
        session()->flash('message', 'Kalibrasi sensitivitas berhasil direset ke kondisi Baseline Normal.');
    }

    public function render()
    {
        // Multiplier based on scenario shock
        $shockMultiplier = 1.0;
        if ($this->scenario === 'moderate') {
            $shockMultiplier = 0.88; // -12% shock
        } elseif ($this->scenario === 'severe') {
            $shockMultiplier = 0.70; // -30% shock
        }

        // Base 7 Financial Ratios from Mockup
        $rawRatios = [
            [
                'name' => 'Net Profit Margin',
                'code' => 'NPM',
                'weight' => '20%',
                'category' => 'Profitabilitas',
                'base_actual' => 28.53,
                'base_threshold' => 20.0,
                'unit' => '%',
                'index' => '17 pt',
                'polarity' => 'up',
            ],
            [
                'name' => 'Return on Assets',
                'code' => 'ROA',
                'weight' => '15%',
                'category' => 'Profitabilitas',
                'base_actual' => 50.08,
                'base_threshold' => 12.0,
                'unit' => '%',
                'index' => '11.2 pt',
                'polarity' => 'up',
            ],
            [
                'name' => 'Return on Equity',
                'code' => 'ROE',
                'weight' => '10%',
                'category' => 'Profitabilitas',
                'base_actual' => 63.13,
                'base_threshold' => 15.0,
                'unit' => '%',
                'index' => '10.5 pt',
                'polarity' => 'up',
            ],
            [
                'name' => 'Current Ratio',
                'code' => 'CR',
                'weight' => '10%',
                'category' => 'Likuiditas',
                'base_actual' => 3.54,
                'base_threshold' => 2.0,
                'unit' => 'x',
                'index' => '4.5 pt',
                'polarity' => 'up',
            ],
            [
                'name' => 'Quick Ratio',
                'code' => 'QR',
                'weight' => '10%',
                'category' => 'Likuiditas',
                'base_actual' => 2.20,
                'base_threshold' => 1.0,
                'unit' => 'x',
                'index' => '4 pt',
                'polarity' => 'up',
            ],
            [
                'name' => 'Days Sales Outstanding',
                'code' => 'DSO',
                'weight' => '10%',
                'category' => 'Aktivitas',
                'base_actual' => 26.40,
                'base_threshold' => 45.0,
                'unit' => 'hari',
                'index' => '6 pt',
                'polarity' => 'down', // Lower is better
            ],
            [
                'name' => 'Debt to Equity Ratio',
                'code' => 'DER',
                'weight' => '10%',
                'category' => 'Solvabilitas',
                'base_actual' => 0.24,
                'base_threshold' => 0.50,
                'unit' => 'x',
                'index' => '3.5 pt',
                'polarity' => 'down', // Lower is better
            ],
        ];

        $tightenFactor = 1 + ($this->tighteningPct / 100);

        $calculatedRatios = [];
        $safeCount = 0;
        $warnCount = 0;
        $dangerCount = 0;

        foreach ($rawRatios as $r) {
            $shockedActual = round($r['base_actual'] * $shockMultiplier, 2);
            $effectiveThreshold = round($r['base_threshold'] * $tightenFactor, 2);

            if ($r['polarity'] === 'down') {
                $margin = round($effectiveThreshold - $shockedActual, 2);
            } else {
                $margin = round($shockedActual - $effectiveThreshold, 2);
            }

            // Buffer status logic
            if ($margin >= 10 || ($r['unit'] === 'x' && $margin >= 1.5)) {
                $status = 'AMAT AMAN';
                $safeCount++;
            } elseif ($margin > 0) {
                $status = 'WASPADA';
                $warnCount++;
            } else {
                $status = 'JATUH AMBANG';
                $dangerCount++;
            }

            $calculatedRatios[] = array_merge($r, [
                'shocked_actual' => $shockedActual,
                'effective_threshold' => $effectiveThreshold,
                'margin' => ($margin >= 0 ? '+' : '') . number_format($margin, 2, ',', '.') . ' ' . $r['unit'],
                'status' => $status,
            ]);
        }

        $resilienceScore = 71;
        if ($this->scenario === 'moderate') $resilienceScore = 58;
        if ($this->scenario === 'severe') $resilienceScore = 34;

        return view('livewire.sensitivity-analysis', [
            'ratios' => $calculatedRatios,
            'resilienceScore' => $resilienceScore,
            'safeCount' => $safeCount,
            'warnCount' => $warnCount,
            'dangerCount' => $dangerCount,
        ])->layout('layouts.app', ['pageTitle' => 'Kalibrasi & Analisis Sensitivitas']);
    }
}

