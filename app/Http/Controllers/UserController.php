<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');

        if ($status === 'active') {
            $users = User::where('status', 1)->get();
        } elseif ($status === 'inactive') {
            $users = User::where('status', 0)->get();
        } else {
            $users = User::all();
        }

        return view('livewire.users.index', compact('users'));
    }

    public function create()
    {
        return view('livewire.users.create');
    }

    public function edit(User $user)
    {
        return view('livewire.users.edit', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'first_name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'last_name' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/'
            ],
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'status' => 'required|integer|in:0,1', // Solo acepta 0 o 1
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'first_name.required' => 'El primer apellido es obligatorio.',
            'first_name.string' => 'El primer apellido debe ser una cadena de texto.',
            'first_name.max' => 'El primer apellido no puede tener más de 100 caracteres.',
            'first_name.regex' => 'El primer apellido solo puede contener letras y espacios.',
            'last_name.string' => 'El segundo apellido debe ser una cadena de texto.',
            'last_name.max' => 'El segundo apellido no puede tener más de 100 caracteres.',
            'last_name.regex' => 'El segundo apellido solo puede contener letras y espacios.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'role.required' => 'El rol es obligatorio.',
            'role.string' => 'El rol debe ser una cadena de texto.',
            'status.required' => 'El estado es obligatorio.',
            'status.integer' => 'El estado debe ser un número entero.',
            'status.in' => 'El estado debe ser 0 o 1.',
        ]);
    
        $user->update([
            'name' => $request->name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'user_id' => Auth::id(), // Cambiado de Auth::user()->id a Auth::id()
        ]);
    
        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }
    
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'first_name' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'last_name' => 'nullable|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'required|string',
            'status' => 'required|integer|in:0,1', // Solo acepta 0 o 1
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'first_name.required' => 'El primer apellido es obligatorio.',
            'first_name.string' => 'El primer apellido debe ser una cadena de texto.',
            'first_name.max' => 'El primer apellido no puede tener más de 100 caracteres.',
            'first_name.regex' => 'El primer apellido solo puede contener letras y espacios.',
            'last_name.string' => 'El segundo apellido debe ser una cadena de texto.',
            'last_name.max' => 'El segundo apellido no puede tener más de 100 caracteres.',
            'last_name.regex' => 'El segundo apellido solo puede contener letras y espacios.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'role.required' => 'El rol es obligatorio.',
            'role.string' => 'El rol debe ser una cadena de texto.',
            'status.required' => 'El estado es obligatorio.',
            'status.integer' => 'El estado debe ser un número entero.',
            'status.in' => 'El estado debe ser 0 o 1.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        User::create([
            'name' => $request->name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => 2,
            'password' => Hash::make($request->password), // Usar Hash::make en lugar de bcrypt
            'user_id' => Auth::id(), // Cambiado de Auth::user()->id a Auth::id()
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->user_id = Auth::id(); // Cambiado de Auth::user()->id a Auth::id()
        $user->save();

        return redirect()->route('users.index')->with('success', 'Estado del usuario actualizado correctamente.');
    }
    public function updateUser(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Buscar al usuario por email
        $user = User::where('email', $validatedData['email'])->first();
    
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado.',
            ], 404);
        }
    
        // Actualizar estado y contraseña
        $user->status = 1; // Actualizar el estado a 1
        $user->password = Hash::make($validatedData['password']);
        $user->save();
    
        return redirect()->route('dashboard');
    }
}
