<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\User;
use App\Models\Vuelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservas = Auth::user()->reservas;
        return view('reservas.index', [
            'reservas' => $reservas,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reservas.create', [
            'vuelos' => Vuelo::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vuelo_id' => 'required|exists:vuelos,id',
        ]);

        $reserva = new Reserva();
        $reserva->user_id = Auth::id(); // Utiliza Auth::id() para obtener el ID del usuario actual
        $reserva->vuelo_id = $validated['vuelo_id'];
        $reserva->save();

        session()->flash('success', 'La reserva se ha creado correctamente.');
        return redirect()->route('reservas.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        return view('reservas.show', [
            'reserva' => $reserva,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        return view('reservas.edit', [
            'reserva' => $reserva,
            'vuelos' => Vuelo::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        $validated = $request->validate([
            'vuelo_id' => 'required|exists:vuelos,id',
        ]);

        $reserva->vuelo_id = $validated['vuelo_id'];
        $reserva->save();
        session()->flash('success', 'Reserva cambiada correctamente');
        return redirect()->route('reservas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        $reserva->delete();
        session()->flash('success', 'La reserva se ha eliminado correctamente.');
        return redirect()->route('reservas.index');
    }
}
