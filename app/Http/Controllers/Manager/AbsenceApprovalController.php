<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // <-- AGGIUNTO: Importazione del Facade Auth

class AbsenceApprovalController extends Controller
{
    /**
     * Mostra le richieste di assenza in sospeso per i dipendenti gestiti.
     */
    public function index()
    {
        /** @var \App\Models\User $manager */
        $manager = Auth::user();


        $managedEmployeeIds = $manager->employees()->pluck('id'); // Usiamo la relazione 'employees'


        $pendingAbsences = Absence::with('user')
            ->whereIn('user_id', $managedEmployeeIds)
            ->where('status', 'Pending')
            ->orderBy('start_date', 'asc')
            ->paginate(10);

        return view('manager.approvals.index', compact('pendingAbsences'));
    }


    public function edit(Absence $absence)
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();
        if ($absence->user->manager_id !== $currentUser->id && !$currentUser->isAdmin()) {
            abort(403, 'Non sei autorizzato ad approvare questa richiesta.');
        }

        return view('manager.approvals.edit', compact('absence'));
    }

    public function update(Request $request, Absence $absence)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected',
            'manager_notes' => 'nullable|string|max:500',
        ]);

        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();


        if ($absence->user->manager_id !== $currentUser->id && !$currentUser->isAdmin()) {
            abort(403, 'Non sei autorizzato ad approvare questa richiesta.');
        }

        $absence->update([
            'status' => $request->status,
            'manager_notes' => $request->manager_notes,
        ]);


        return redirect()->route('manager.absence-approvals.index')->with('success', 'Richiesta di assenza ' . $request->status . ' con successo.');
    }
}
