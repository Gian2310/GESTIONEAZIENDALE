<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Timesheet;
use App\Models\Absence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{

    public function departmentOverview(Request $request)
    {
        $manager = Auth::user();
        $departmentId = $manager->department_id;
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        if (!$departmentId) {
            return view('manager.reports.department_overview')->with('error', 'Il tuo account non è associato a un reparto.');
        }

        $employees = User::where('department_id', $departmentId)
            ->where('role', 'employee')
            ->get();

        $reportData = [];

        foreach ($employees as $employee) {

            $totalHours = Timesheet::where('user_id', $employee->id)
                ->whereYear('clock_in', $year)
                ->whereMonth('clock_in', $month)
                ->sum('hours_worked');


            $totalAbsenceDays = Absence::where('user_id', $employee->id)
                ->whereYear('start_date', $year)
                ->whereMonth('start_date', $month)
                ->where('status', 'Approved')
                ->sum('days_requested');

            $reportData[] = [
                'employee' => $employee->name,
                'total_hours' => round($totalHours, 2),
                'total_absence_days' => round($totalAbsenceDays, 1),
            ];
        }

        return view('manager.reports.department_overview', compact('reportData', 'month', 'year', 'manager'));
    }
}
