<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');

        if ($status === 'active') {
            $employees = Employee::where('status', 1)->with('user')->get();
        } elseif ($status === 'inactive') {
            $employees = Employee::where('status', 0)->with('user')->get();
        } else {
            $employees = Employee::with('user')->get();
        }

        // Ruta ajustada para coincidir con la carpeta 'livewire'
        return view('livewire.employees.index', compact('employees'));
    }

    public function create()
    {
        // Lista de usuarios que aún no están asociados a un empleado
        $users = User::doesntHave('employee')->get();
        
        // Ruta ajustada para coincidir con la carpeta 'livewire'
        return view('livewire.employees.select_user', compact('users'));
    }

    public function showCreateForm($userId)
    {
        $user = User::findOrFail($userId); // Encontrar el usuario seleccionado

        // Ruta ajustada para coincidir con la carpeta 'livewire'
        return view('livewire.employees.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'position' => 'required|in:Vendedor,Gerente,Asistente',
        ]);

        Employee::create([
            'user_id' => $request->user_id,
            'address' => $request->address,
            'phone' => $request->phone,
            'position' => $request->position,
            'status' => 1, // Estado activo por defecto
        ]);

        return redirect()->route('employees.index')->with('success', 'Empleado creado exitosamente.');
    }

    public function edit(Employee $employee)
    {
        // Ruta ajustada para coincidir con la carpeta 'livewire'
        return view('livewire.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'position' => 'required|in:Vendedor,Gerente,Asistente',
        ]);

        $employee->update([
            'address' => $request->address,
            'phone' => $request->phone,
            'position' => $request->position,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('employees.index')->with('success', 'Empleado actualizado correctamente.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Empleado eliminado correctamente.');
    }

    public function toggleStatus($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->status = !$employee->status;
        $employee->save();

        return redirect()->route('employees.index')->with('success', 'Estado del empleado actualizado correctamente.');
    }

}

