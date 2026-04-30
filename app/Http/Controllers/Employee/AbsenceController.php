<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsenceController extends Controller
{
    public function index()
    {
        $absences = Absence::where('user_id', Auth::id())->orderBy('start_date', 'desc')->paginate(10);
        return view('employee.absences.index', compact('absences'));
    }

    public function create()
    {
        $vacationBalance = 20;
        return view('employee.absences.create', compact('vacationBalance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:Ferie,Permesso,Malattia',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:500',

        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);


        $daysRequested = $startDate->diffInDays($endDate) + 1;

        $absence = Absence::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'days_requested' => $daysRequested,
            'reason' => $request->reason,
            'status' => 'Pending',
        ]);


        return redirect()->route('employee.absences.index')->with('success', 'Richiesta di ' . $request->type . ' inviata con successo per approvazione.');
    }

    public function show(Absence $absence)
    {
        if ($absence->user_id !== Auth::id()) {
            abort(403, 'Accesso non autorizzato.');
        }
        return view('employee.absences.show', compact('absence'));
    }
}
