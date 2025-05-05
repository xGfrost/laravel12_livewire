<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivewireController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
});

Route::middleware(['auth', 'verified', 'can:access_companies'])->prefix('companies')->name('companies.')->group(function () {
    Route::get('/', [LivewireController::class, 'handle'])->name('index')->defaults('component', \App\Livewire\Admin\Companies\Index::class);
    Route::get('/create', [LivewireController::class, 'handle'])->name('create')->defaults('component', \App\Livewire\Admin\Companies\Create::class);
    Route::get('/{company}/edit', [LivewireController::class, 'handle'])->name('edit')->defaults('component', \App\Livewire\Admin\Companies\Edit::class);
});




Route::middleware(['company.context'])->group(function()
{
    Route::middleware(['auth', 'verified', 'can:access_departments'])->prefix('departments')->name('departments.')->group(function () {
        Route::get('/', [LivewireController::class, 'handle'])->name('index')->defaults('component', \App\Livewire\Admin\Departments\Index::class);
        Route::get('/create', [LivewireController::class, 'handle'])->name('create')->defaults('component', \App\Livewire\Admin\Departments\Create::class);
        Route::get('/{department}/edit', [LivewireController::class, 'handle'])->name('edit')->defaults('component', \App\Livewire\Admin\Departments\Edit::class);
    });

    Route::middleware(['auth', 'verified', 'can:access_designations'])->prefix('designations')->name('designations.')->group(function () {
        Route::get('/', [LivewireController::class, 'handle'])->name('index')->defaults('component', \App\Livewire\Admin\Designations\Index::class);
        Route::get('/create', [LivewireController::class, 'handle'])->name('create')->defaults('component', \App\Livewire\Admin\Designations\Create::class);
        Route::get('/{designation}/edit', [LivewireController::class, 'handle'])->name('edit')->defaults('component', \App\Livewire\Admin\Designations\Edit::class);
    });

    Route::middleware(['auth', 'verified', 'can:access_employees'])->prefix('employees')->name('employees.')->group(function () {
        Route::get('/', [LivewireController::class, 'handle'])->name('index')->defaults('component', \App\Livewire\Admin\Employees\Index::class);
        Route::get('/create', [LivewireController::class, 'handle'])->name('create')->defaults('component', \App\Livewire\Admin\Employees\Create::class);
        Route::get('/{employee}/edit', [LivewireController::class, 'handle'])->name('edit')->defaults('component', \App\Livewire\Admin\Employees\Edit::class);
    });

    Route::middleware(['auth', 'verified', 'can:access_contracts'])->prefix('contracts')->name('contracts.')->group(function () {
        Route::get('/', [LivewireController::class, 'handle'])->name('index')->defaults('component', \App\Livewire\Admin\Contracts\Index::class);
        Route::get('/create', [LivewireController::class, 'handle'])->name('create')->defaults('component', \App\Livewire\Admin\Contracts\Create::class);
        Route::get('/{contract}/edit', [LivewireController::class, 'handle'])->name('edit')->defaults('component', \App\Livewire\Admin\Contracts\Edit::class);
    });

    Route::middleware(['auth', 'verified', 'can:access_payrolls'])->prefix('payrolls')->name('payrolls.')->group(function () {
        Route::get('/', [LivewireController::class, 'handle'])->name('index')->defaults('component', \App\Livewire\Admin\Payrolls\Index::class);
        Route::get('/show', [LivewireController::class, 'handle'])->name('show')->defaults('component', \App\Livewire\Admin\Payrolls\Show::class);
    });
});


