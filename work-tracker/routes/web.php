<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\EmploymentController;
use App\Http\Controllers\WorkdayController;
use App\Http\Middleware\CheckAcceptedMiddleware;
use App\Http\Middleware\CheckAdminMiddleware;
use App\Http\Middleware\CheckAdministrationMiddleware;
use App\Models\Workday;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();




Route::middleware([CheckAcceptedMiddleware::class])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/employees/my-months', [EmployeeController::class, 'myMonths'])->name('employees.my-months');
    Route::get('/workdays/{month}/{year}/work-month-normal', [WorkdayController::class, 'workMonthNormal'])->name('workdays.work-month-normal');
    Route::post('/vacation-request', [VacationController::class, 'store'])->name('vacations.store');
    Route::get('/vacation-requests', [VacationController::class, 'index'])->name('vacations.index');
    Route::get('/vacation-request/{id}', [VacationController::class, 'show'])->name('vacations.show');
    Route::get('/create', [VacationController::class, 'create'])->name('vacations.create');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create/{subject?}', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages/store',[MessageController::class,'store'])->name('messages.store');
    Route::get('/messages/sent', [MessageController::class, 'sentMessages'])->name('messages.sentMessages');
    Route::get('/messages/received', [MessageController::class, 'receivedMessages'])->name('messages.receivedMessages');
});

Route::middleware([CheckAdministrationMiddleware::class])->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::put('/accounts/{id}/accept', [AccountController::class, 'accept'])->name('accounts.accept');
    Route::get('/accounts/{id}/details', [AccountController::class, 'details'])->name('accounts.details');
    Route::get('/accounts/{id}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::put('/accounts/{id}', [AccountController::class, 'update'])->name('accounts.update');
    Route::post('/accounts/{id}/change-role', [AccountController::class, 'changeRole'])->name('accounts.change-role');
    Route::get('/employees/{id}/employee', [EmployeeController::class, 'employee'])->name('employees.employee');
    Route::get('/employments/{id}/create-employment', [EmploymentController::class, 'createEmployment'])->name('employments.create-employment');
    Route::post('/employments/store-employment', [EmploymentController::class, 'storeEmployment'])->name('employments.store-employment');
    Route::get('/employments', [EmploymentController::class, 'index'])->name('employments.index');
    Route::get('/employments/{id}/details', [EmploymentController::class, 'details'])->name('employments.details');
    Route::get('/workdays/{id}/{month}/{year}/work-month', [WorkdayController::class, 'workMonth'])->name('workdays.work-month');
    Route::post('/workdays/update', [WorkdayController::class, 'update'])->name('workdays.update');
    Route::get('/admin/vacation-requests', [VacationController::class, 'adminIndex'])->name('vacations.adminIndex');
    Route::post('/admin/vacation-request/{id}/change-status', [VacationController::class, 'changeStatus'])->name('vacations.changeStatus');
});

Route::middleware([CheckAdminMiddleware::class])->group(function () {
    Route::delete('/accounts/{id}', [AccountController::class, 'delete'])->name('accounts.delete');
});