<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{

    public function index()
    {
        $contracts = Contract::paginate(10);
        return view('admin.contracts.index', compact('contracts'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:contracts,name',
            'description' => 'nullable|string',
            'daily_hours' => 'required|integer|min:1',
            'pause_minutes' => 'required|integer|min:0',
            'vacation_days_per_year' => 'required|integer|min:0',
        ]);

        Contract::create($request->all());

        return redirect()->route('admin.contracts.index')->with('success', 'Contratto creato con successo.');
    }


    public function edit(Contract $contract)
    {
        $contracts = Contract::paginate(10);
        return view('admin.contracts.index', compact('contracts', 'contract'));
    }

    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:contracts,name,' . $contract->id,
            'description' => 'nullable|string',
            'daily_hours' => 'required|integer|min:1',
            'pause_minutes' => 'required|integer|min:0',
            'vacation_days_per_year' => 'required|integer|min:0',
        ]);

        $contract->update($request->all());

        return redirect()->route('admin.contracts.index')->with('success', 'Contratto aggiornato con successo.');
    }

    public function destroy(Contract $contract)
    {
        if ($contract->users()->exists()) {
            return redirect()->route('admin.contracts.index')->with('error', 'Impossibile eliminare: Contratto collegato a dipendenti.');
        }

        $contract->delete();
        return redirect()->route('admin.contracts.index')->with('success', 'Contratto eliminato.');
    }
}
