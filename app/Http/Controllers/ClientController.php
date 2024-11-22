<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('livewire.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('livewire.clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'second_last_name' => 'nullable|string|max:100',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable|string|max:15',
            'ciNit' => 'required|string|max:20|unique:clients,ciNit',
            'status' => 'required|boolean',
        ]);

        Client::create([
            'company_name' => $request->company_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'second_last_name' => $request->second_last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'ciNit' => $request->ciNit,
            'status' => $request->status, // Guardar el estado
        ]);

        return redirect()->route('clients.index')->with('success', 'Cliente creado exitosamente.');
    }

    public function edit(Client $client)
    {
        return view('livewire.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'second_last_name' => 'nullable|string|max:100',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:15',
            'ciNit' => 'required|string|max:20|unique:clients,ciNit,' . $client->id,
            'status' => 'required|boolean',
        ]);

        $client->update([
            'company_name' => $request->company_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'second_last_name' => $request->second_last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'ciNit' => $request->ciNit,
            'status' => $request->status, // Actualizar el estado
        ]);

        return redirect()->route('clients.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Cliente eliminado.');
    }

    public function toggleStatus($id)
    {
        $client = Client::findOrFail($id);
        $client->status = !$client->status;
        $client->save();

        return redirect()->route('clients.index')->with('success', 'Estado del cliente actualizado correctamente.');
    }
}
