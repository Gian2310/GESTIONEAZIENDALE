<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{

    public function index(Request $request)
    {
        $query = User::with('department', 'contract')
            ->whereIn('role', ['employee', 'manager']);


        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $employees = $query->latest('hiring_date')->paginate(10);

        return view('admin.employees.index', compact('employees', 'search'));
    }


    public function create()
    {
        $departments = Department::all();
        $contracts = Contract::all();

        $roles = [
            'employee' => 'Dipendente',
            'manager' => 'Responsabile di Reparto',
            // 'admin' => 'Amministratore (Non Assegnabile Tramite Form Dipendente)',
        ];

        return view('admin.employees.create', compact('departments', 'contracts', 'roles'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', 'string', Rule::in(['employee', 'manager'])],
            'department_id' => 'nullable|exists:departments,id',
            'contract_id' => 'nullable|exists:contracts,id',
            'fiscal_code' => 'required|string|max:16|unique:users,fiscal_code',
            'base_salary' => 'required|numeric|min:0',
            'hiring_date' => 'required|date',
        ]);


        $validatedData['name'] = $validatedData['first_name'] . ' ' . $validatedData['last_name'];

        User::create($validatedData);

        return redirect()->route('admin.employees.index')->with('success', 'Dipendente creato con successo.');
    }


    public function show(User $employee)
    {
        if (!in_array($employee->role, ['employee', 'manager'])) {
            return redirect()->route('admin.employees.index')->with('error', 'Utente non gestibile tramite questo modulo.');
        }

        return view('admin.employees.show', compact('employee'));
    }


    public function edit(User $employee)
    {
        if (!in_array($employee->role, ['employee', 'manager'])) {
            return redirect()->route('admin.employees.index')->with('error', 'Utente non gestibile tramite questo modulo.');
        }

        $departments = Department::all();
        $contracts = Contract::all();
        $roles = [
            'employee' => 'Dipendente',
            'manager' => 'Responsabile di Reparto',
        ];

        return view('admin.employees.edit', compact('employee', 'departments', 'contracts', 'roles'));
    }


    public function update(Request $request, User $employee)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',

            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($employee->id)],

            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', 'string', Rule::in(['employee', 'manager'])],
            'department_id' => 'nullable|exists:departments,id',
            'contract_id' => 'nullable|exists:contracts,id',
            'fiscal_code' => ['required', 'string', 'max:16', Rule::unique('users', 'fiscal_code')->ignore($employee->id)],
            'base_salary' => 'required|numeric|min:0',
            'hiring_date' => 'required|date',
        ]);

        $validatedData['name'] = $validatedData['first_name'] . ' ' . $validatedData['last_name'];

        if (isset($validatedData['password'])) {
            $employee->password = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $employee->update($validatedData);

        return redirect()->route('admin.employees.index')->with('success', 'Dipendente aggiornato con successo.');
    }

    /**
     */
    public function destroy(User $employee)
    {
        if ($employee->role === 'admin') {
            return redirect()->route('admin.employees.index')->with('error', 'Impossibile eliminare l\'utente Amministratore.');
        }

        if (!in_array($employee->role, ['employee', 'manager'])) {
            return redirect()->route('admin.employees.index')->with('error', 'Utente non gestibile tramite questo modulo.');
        }

        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Dipendente eliminato con successo.');
    }
}
