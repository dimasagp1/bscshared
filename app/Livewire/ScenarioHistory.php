<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use App\Models\Period;

class ScenarioHistory extends Component
{
    #[Url(as: 'period')]
    public $selectedPeriod = '2026-10';

    public $scenarioName = '';

    // Simulation Session Step Tracking (up to 50 steps)
    public $currentStepIndex = 0;
    public $totalSteps = 0;
    public $historySteps = [];

    // List of Saved Scenarios
    public $savedScenarios = [];

    // Import / Export Modals
    public $showExportModal = false;
    public $exportJsonContent = '';

    public $showImportModal = false;
    public $importJsonContent = '';

    public function mount()
    {
        $this->selectedPeriod = request()->query('period') ?: session('bsc_period', '2026-10');

        // Load saved scenarios from session or initialize with defaults matching screenshot
        $scenarios = session('bsc_saved_scenarios');
        if (!is_array($scenarios) || empty($scenarios)) {
            $this->savedScenarios = [
                [
                    'id' => 'sc-default-1',
                    'name' => 'NAIK TARGET REVENUE',
                    'created_at' => '28/10/2026, 09.16.16',
                    'steps_count' => 0,
                    'payload' => [
                        'revenue_target' => 61400,
                        'gpm_target' => 32.5,
                        'description' => 'Skenario kenaikan target pendapatan korporasi +5%',
                    ],
                ],
            ];
            session(['bsc_saved_scenarios' => $this->savedScenarios]);
        } else {
            $this->savedScenarios = $scenarios;
        }

        // Initialize session history steps
        $this->historySteps = session('bsc_history_steps', []);
        $this->totalSteps = count($this->historySteps);
        $this->currentStepIndex = (int) session('bsc_current_step_index', 0);
    }

    #[On('periodChanged')]
    public function onPeriodChanged($period)
    {
        if ($period) {
            $this->selectedPeriod = $period;
            session(['bsc_period' => $period]);
        }
    }

    public function saveScenario()
    {
        $name = trim($this->scenarioName);
        if (empty($name)) {
            session()->flash('error', 'Silakan masukkan nama skenario sebelum menyimpan.');
            return;
        }

        $newScenario = [
            'id' => 'sc-' . uniqid(),
            'name' => strtoupper($name),
            'created_at' => date('d/m/Y, H.i.s'),
            'steps_count' => $this->currentStepIndex,
            'payload' => [
                'period' => $this->selectedPeriod,
                'step_index' => $this->currentStepIndex,
                'created_at_iso' => now()->toIso8601String(),
            ],
        ];

        // Prepend to list
        array_unshift($this->savedScenarios, $newScenario);
        session(['bsc_saved_scenarios' => $this->savedScenarios]);

        $this->scenarioName = '';
        session()->flash('message', "Skenario '{$newScenario['name']}' berhasil disimpan!");
    }

    public function loadScenario($id)
    {
        $found = collect($this->savedScenarios)->firstWhere('id', $id);
        if ($found) {
            $this->currentStepIndex = $found['steps_count'] ?? 0;
            session(['bsc_current_step_index' => $this->currentStepIndex]);
            session()->flash('message', "Skenario '{$found['name']}' berhasil dimuat ke dalam sesi simulasi!");
        }
    }

    public function deleteScenario($id)
    {
        $this->savedScenarios = array_values(array_filter($this->savedScenarios, function ($s) use ($id) {
            return $s['id'] !== $id;
        }));
        session(['bsc_saved_scenarios' => $this->savedScenarios]);
        session()->flash('message', 'Skenario berhasil dihapus dari daftar tersimpan.');
    }

    public function resetForm()
    {
        $this->scenarioName = '';
        $this->currentStepIndex = 0;
        session(['bsc_current_step_index' => 0]);
        session()->flash('message', 'Sesi formulir skenario telah di-reset.');
    }

    public function undo()
    {
        if ($this->currentStepIndex > 0) {
            $this->currentStepIndex--;
            session(['bsc_current_step_index' => $this->currentStepIndex]);
            session()->flash('message', "Undo berhasil (Langkah: {$this->currentStepIndex}/{$this->totalSteps})");
        }
    }

    public function redo()
    {
        if ($this->currentStepIndex < $this->totalSteps) {
            $this->currentStepIndex++;
            session(['bsc_current_step_index' => $this->currentStepIndex]);
            session()->flash('message', "Redo berhasil (Langkah: {$this->currentStepIndex}/{$this->totalSteps})");
        }
    }

    public function openExportModal()
    {
        $exportData = [
            'version' => '2.5',
            'exported_at' => now()->toIso8601String(),
            'period' => $this->selectedPeriod,
            'current_step' => $this->currentStepIndex,
            'scenarios' => $this->savedScenarios,
        ];
        $this->exportJsonContent = json_encode($exportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $this->showExportModal = true;
    }

    public function closeExportModal()
    {
        $this->showExportModal = false;
        $this->exportJsonContent = '';
    }

    public function openImportModal()
    {
        $this->importJsonContent = '';
        $this->showImportModal = true;
    }

    public function closeImportModal()
    {
        $this->showImportModal = false;
        $this->importJsonContent = '';
    }

    public function importJson()
    {
        $raw = trim($this->importJsonContent);
        if (empty($raw)) {
            session()->flash('error', 'Konten JSON kosong.');
            return;
        }

        try {
            $data = json_decode($raw, true);
            if (!is_array($data)) {
                throw new \Exception('Format JSON tidak valid.');
            }

            if (isset($data['scenarios']) && is_array($data['scenarios'])) {
                foreach ($data['scenarios'] as $sc) {
                    $this->savedScenarios[] = [
                        'id' => 'sc-' . uniqid(),
                        'name' => strtoupper($sc['name'] ?? 'SKENARIO IMPOR'),
                        'created_at' => date('d/m/Y, H.i.s'),
                        'steps_count' => $sc['steps_count'] ?? 0,
                        'payload' => $sc['payload'] ?? [],
                    ];
                }
            } else {
                $this->savedScenarios[] = [
                    'id' => 'sc-' . uniqid(),
                    'name' => strtoupper($data['name'] ?? 'SKENARIO IMPOR'),
                    'created_at' => date('d/m/Y, H.i.s'),
                    'steps_count' => $data['steps_count'] ?? 0,
                    'payload' => $data,
                ];
            }

            session(['bsc_saved_scenarios' => $this->savedScenarios]);
            $this->closeImportModal();
            session()->flash('message', 'Skenario JSON berhasil diimpor!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal memproses JSON: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.scenario-history', [
            'savedScenarios' => $this->savedScenarios,
            'currentStepIndex' => $this->currentStepIndex,
            'totalSteps' => $this->totalSteps,
        ])->layout('layouts.app', ['title' => 'Kelola Skenario']);
    }
}

