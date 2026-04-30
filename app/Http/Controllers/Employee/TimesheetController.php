<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TimesheetController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $openTimesheet = Timesheet::where('user_id', $user->id)
            ->whereNull('clock_out')
            ->first();

        $timesheets = Timesheet::where('user_id', $user->id)
            ->orderBy('clock_in', 'desc')
            ->paginate(15);

        return view('employee.timesheets.index', compact('openTimesheet', 'timesheets'));
    }

    /** Registrazione Timbratura (Clock In) */
    public function store(Request $request)
    {
        $user = Auth::user();


        if (Timesheet::where('user_id', $user->id)->whereNull('clock_out')->exists()) {
            return back()->with('error', 'Hai già una timbratura di ingresso aperta.');
        }

        Timesheet::create([
            'user_id' => $user->id,
            'clock_in' => Carbon::now(),
            'notes' => $request->input('notes'),
        ]);

        return back()->with('success', 'Ingresso registrato con successo.');
    }


    public function clockOut(Request $request)
    {
        $user = Auth::user();
        $openTimesheet = Timesheet::where('user_id', $user->id)->whereNull('clock_out')->first();

        if (!$openTimesheet) {
            return back()->with('error', 'Nessuna timbratura di ingresso trovata da chiudere.');
        }

        $clockOutTime = Carbon::now();
        $clockInTime = $openTimesheet->clock_in;

        $totalDuration = $clockOutTime->diffInMinutes($clockInTime);


        $pauseMinutes = $user->contract ? $user->contract->pause_minutes : 30;

        $effectiveDuration = max(0, $totalDuration - $pauseMinutes);
        $hoursWorked = $effectiveDuration / 60;


        $standardHours = $user->contract ? $user->contract->daily_hours : 8;
        $overtimeHours = max(0, $hoursWorked - $standardHours);

        $openTimesheet->update([
            'clock_out' => $clockOutTime,
            'hours_worked' => round($hoursWorked, 2),
            'overtime_hours' => round($overtimeHours, 2),
        ]);

        return back()->with('success', 'Uscita registrata. Ore lavorate: ' . round($hoursWorked, 2) . 'h.');
    }
}
