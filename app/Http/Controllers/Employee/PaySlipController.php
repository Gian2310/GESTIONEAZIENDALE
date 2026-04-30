<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\PaySlip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaySlipController extends Controller
{

    public function index()
    {
        $paySlips = PaySlip::where('user_id', Auth::id())
            ->orderBy('pay_date', 'desc')
            ->paginate(10);

        return view('employee.payslips.index', compact('paySlips'));
    }

    /**
     * @param PaySlip $paySlip La busta paga da mostrare (Model Binding)
     */
    public function show(PaySlip $paySlip)
    {

        if ($paySlip->user_id !== Auth::id()) {
            return redirect()->route('employee.payslips.index')
                ->with('error', 'Non sei autorizzato a visualizzare questa busta paga.');
        }

        return view('employee.payslips.show', compact('paySlip'));
    }
}
