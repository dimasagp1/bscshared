<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\BscDashboard;
use App\Livewire\FinancialRatios;
use App\Livewire\DepartmentObjectives;
use App\Livewire\ActionPlans;
use App\Livewire\StagingLogs;
use App\Livewire\SystemIntegration;
use App\Livewire\BscWiring;

Route::get('/', BscDashboard::class)->name('dashboard');
Route::get('/ratios', FinancialRatios::class)->name('financial-ratios');
Route::get('/objectives', DepartmentObjectives::class)->name('department-objectives');
Route::get('/action-plans', ActionPlans::class)->name('action-plans');
Route::get('/wiring', BscWiring::class)->name('bsc-wiring');
Route::get('/integration', SystemIntegration::class)->name('system-integration');
Route::get('/staging-logs', StagingLogs::class)->name('staging-logs');
