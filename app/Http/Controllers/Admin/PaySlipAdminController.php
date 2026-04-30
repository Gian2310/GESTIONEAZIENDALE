<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaySlip;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaySlipAdminController extends Controller
{
    /** Mostra il form per caricare una busta paga */
    public function create()
    {
        $employees = User::whereIn('role', ['employee', 'manager'])->orderBy('last_name')->get();
        return view('admin.payslips.create', compact('employees'));
    }

    /** Logica per salvare la busta paga (Simulata) */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'pay_date' => 'required|date',
            'base_salary' => 'required|numeric|min:0',
            'total_hours_worked' => 'required|numeric|min:0',
            'total_overtime_hours' => 'nullable|numeric|min:0',
            'overtime_pay' => 'nullable|numeric|min:0',
            'bonus_amount' => 'nullable|numeric|min:0',
            'total_deductions' => 'nullable|numeric|min:0',
            'net_pay' => 'required|numeric|min:0',
            // 'payslip_file' => 'nullable|file|mimes:pdf|max:2048', // Per caricamento file reale
        ]);

        $netPay = $request->base_salary + ($request->overtime_pay ?? 0) + ($request->bonus_amount ?? 0) - ($request->total_deductions ?? 0);
        if ($netPay != $request->net_pay) {
            // Un controllo base
            // In un sistema reale, il calcolo sarebbe gestito internamente
        }

        $filePath = null;
        // Simulazione caricamento file
        if ($request->hasFile('payslip_file')) {
            // $filePath = $request->file('payslip_file')->store('payslips', 'public');
        }

        PaySlip::create([
            'user_id' => $request->user_id,
            'pay_date' => $request->pay_date,
            'base_salary' => $request->base_salary,
            'total_hours_worked' => $request->total_hours_worked,
            'total_overtime_hours' => $request->total_overtime_hours ?? 0,
            'overtime_pay' => $request->overtime_pay ?? 0,
            'bonus_amount' => $request->bonus_amount ?? 0,
            'total_deductions' => $request->total_deductions ?? 0,
            'net_pay' => $request->net_pay,
            'file_path' => $filePath, // Manteniamo la simulazione
        ]);

        return redirect()->route('admin.payslips.create')->with('success', 'Busta paga caricata con successo.');
    }
}
