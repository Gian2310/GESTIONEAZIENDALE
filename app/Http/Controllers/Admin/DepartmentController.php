<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function index()
    {
        $departments = Department::withCount('users')
            ->latest()
            ->paginate(10);

        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments.create');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'nullable|string',
        ]);

        Department::create($validatedData);

        return redirect()->route('admin.departments.index')->with('success', 'Reparto creato con successo.');
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }


    public function update(Request $request, Department $department)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'description' => 'nullable|string',
        ]);

        $department->update($validatedData);

        return redirect()->route('admin.departments.index')->with('success', 'Reparto aggiornato con successo.');
    }


    public function destroy(Department $department)
    {

        if ($department->users()->count() > 0) {
            return redirect()->route('admin.departments.index')->with('error', 'Impossibile eliminare: ci sono dipendenti associati a questo reparto.');
        }

        $department->delete();

        return redirect()->route('admin.departments.index')->with('success', 'Reparto eliminato con successo.');
    }
}
