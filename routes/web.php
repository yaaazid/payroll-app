<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\CompanySetting;
use App\Livewire\SalaryComponent;
use App\Livewire\TaxSetting;
use App\Livewire\TimeAttendance;





Route::redirect('/', 'dashboard')->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');


    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});



//Admin Routes
Route::middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('company-settings', CompanySetting::class)->name('company-settings');
    Route::view('departments-and-positions', 'admin.departments-and-positions')->name('departments-and-positions');
    Route::get('salary-component', SalaryComponent::class)->name('salary-components');
    Route::get('tax-setting',TaxSetting::class)->name('tax-settings');
    Route::get('time-attendance', TimeAttendance::class)->name('time-attendance');
});

require __DIR__ . '/auth.php';
