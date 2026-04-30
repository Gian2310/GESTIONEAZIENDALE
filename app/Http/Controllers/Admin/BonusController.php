<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductionBonus;
use App\Models\Department;
use Illuminate\Http\Request;

class BonusController extends Controller
{

    public function index()
    {
        $bonuses = ProductionBonus::with('department')->orderBy('bonus_date', 'desc')->paginate(10);
        $departments = Department::all();
        return view('admin.bonuses.index', compact('bonuses', 'departments'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'bonus_date' => 'required|date',
            'department_id' => 'nullable|exists:departments,id',
            'description' => 'nullable|string',
        ]);

        ProductionBonus::create($request->all());

        return redirect()->route('admin.bonuses.index')->with('success', 'Premio di produzione registrato con successo.');
    }


    public function edit(ProductionBonus $bonus)
    {
        $bonuses = ProductionBonus::with('department')->orderBy('bonus_date', 'desc')->paginate(10);
        $departments = Department::all();
        // Ritorna la vista index con il bonus da modificare
        return view('admin.bonuses.index', compact('bonuses', 'departments', 'bonus'));
    }


    public function update(Request $request, ProductionBonus $bonus)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'bonus_date' => 'required|date',
            'department_id' => 'nullable|exists:departments,id',
            'description' => 'nullable|string',
        ]);

        $bonus->update($request->all());

        return redirect()->route('admin.bonuses.index')->with('success', 'Premio di produzione aggiornato con successo.');
    }


    public function destroy(ProductionBonus $bonus)
    {
        $bonus->delete();
        return redirect()->route('admin.bonuses.index')->with('success', 'Premio eliminato.');
    }
}
