<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaySlip;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{

    public function costOfLabor(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

        $costData = PaySlip::selectRaw('
                MONTH(pay_date) as month,
                SUM(base_salary) as total_base_salary,
                SUM(overtime_pay) as total_overtime_pay,
                SUM(bonus_amount) as total_bonus,
                SUM(net_pay) as total_net_pay
            ')
            ->whereYear('pay_date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyCost = array_fill(1, 12, [
            'month' => 0,
            'total_base_salary' => 0,
            'total_overtime_pay' => 0,
            'total_bonus' => 0,
            'total_net_pay' => 0
        ]);

        foreach ($costData as $data) {
            $monthlyCost[$data->month] = $data->toArray();
        }

        return view('admin.reports.cost_of_labor', compact('monthlyCost', 'year'));
    }
}
