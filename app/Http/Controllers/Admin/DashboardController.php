<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Timesheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {

        $totalEmployees = User::whereIn('role', ['employee', 'manager'])->count();


        $absentToday = 0;

        $contractsExpiring = 0;

        $monthlyCost = User::whereIn('role', ['employee', 'manager'])
            ->sum('base_salary');

        $monthlyCost = round($monthlyCost / 12, 2);


        $recentTimesheets = [];
        try {
            $recentTimesheets = Timesheet::with('user')
                ->latest('created_at')
                ->take(5)
                ->get();
        } catch (\Throwable $e) {

            error_log("Errore nel caricamento delle Timbrature: " . $e->getMessage());
        }


        $employeesPerDepartment = DB::table('departments')
            ->select('departments.name', DB::raw('COUNT(users.id) as employee_count'))
            ->leftJoin('users', 'departments.id', '=', 'users.department_id')
            ->groupBy('departments.id', 'departments.name')
            ->pluck('employee_count', 'name');

        $chartLabels = $employeesPerDepartment->keys()->toArray();
        $chartData = $employeesPerDepartment->values()->toArray();


        return view('admin.dashboard', compact(
            'totalEmployees',
            'absentToday',
            'contractsExpiring',
            'monthlyCost',
            'recentTimesheets',
            'chartLabels',
            'chartData'
        ));
    }
}
