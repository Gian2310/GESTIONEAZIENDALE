<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\ContractController;
use App\Http\Controllers\Admin\BonusController;
use App\Http\Controllers\Admin\PaySlipAdminController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Manager\AbsenceApprovalController;
use App\Http\Controllers\Manager\ReportController as ManagerReportController;
use App\Http\Controllers\Employee\TimesheetController;
use App\Http\Controllers\Employee\AbsenceController;
use App\Http\Controllers\Employee\PaySlipController;


Route::get('/', function () {
    return redirect('/login');
});


Route::middleware('auth')->group(function () {


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {


        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


        Route::resource('employees', EmployeeController::class);
        Route::resource('departments', DepartmentController::class)->except(['show']);
        Route::resource('contracts', ContractController::class)->except(['show']);

        Route::resource('bonuses', BonusController::class);
        Route::get('payslips/create', [PaySlipAdminController::class, 'create'])->name('payslips.create');
        Route::post('payslips', [PaySlipAdminController::class, 'store'])->name('payslips.store');

        Route::get('reports/cost-of-labor', [AdminReportController::class, 'costOfLabor'])->name('reports.costOfLabor');
    });


    Route::middleware('role:manager')->prefix('manager')->name('manager.')->group(function () {

        Route::get('/', function () {
            return view('manager.dashboard');
        })->name('dashboard');

        Route::resource('absence-approvals', AbsenceApprovalController::class)->only(['index', 'edit', 'update']);

        Route::get('reports/department-overview', [ManagerReportController::class, 'departmentOverview'])->name('reports.departmentOverview');
    });

    Route::middleware('role:employee')->prefix('employee')->name('employee.')->group(function () {

        Route::get('/', function () {
            return view('employee.dashboard');
        })->name('dashboard');

        Route::resource('timesheets', TimesheetController::class)->only(['index', 'store']);
        Route::post('timesheets/clock-out', [TimesheetController::class, 'clockOut'])->name('timesheets.clockOut');

        Route::resource('absences', AbsenceController::class)->only(['index', 'create', 'store', 'show']);

        Route::get('payslips', [PaySlipController::class, 'index'])->name('payslips.index');
        Route::get('payslips/{paySlip}', [PaySlipController::class, 'show'])->name('payslips.show');
    });


    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user) {
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            if ($user->role === 'manager') {
                return redirect()->route('manager.dashboard');
            }
            if ($user->role === 'employee') {
                return redirect()->route('employee.dashboard');
            }
        }
        return view('dashboard');
    })->middleware('verified')->name('dashboard');
});

require __DIR__ . '/auth.php';
