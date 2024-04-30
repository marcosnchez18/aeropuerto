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

        // Vamos a buscar el buelo cuyo id sea el del validate que hemos hecho
        $vuelo = Vuelo::findOrFail($validated['vuelo_id']);

        // miramos a ver si hay plazas
        if ($vuelo->plazas > 0) {
            // asi se resta 1 en laravel
            $vuelo->plazas--;
            $vuelo->save();

            // en caso de que haya plaza po creamos una reserva
            $reserva = new Reserva();
            $reserva->user_id = Auth::id(); // cojemos el id del usuario actual
            $reserva->vuelo_id = $validated['vuelo_id'];
            $reserva->save();

            session()->flash('success', 'La reserva se ha creado correctamente.');
            return redirect()->route('reservas.index');
        } else {

            session()->flash('error', 'No hay plazas disponibles para este vuelo.');
            return redirect()->back();
        }
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


        $vuelo_seleccionado = Vuelo::findOrFail($validated['vuelo_id']);

        // miramos si el vuelo es diferente al vuelo que haya cogido el usuario
        if ($vuelo_seleccionado->id !== $reserva->vuelo_id) {

            if ($vuelo_seleccionado->plazas > 0) {

                $vuelo_seleccionado->plazas--;
                $vuelo_seleccionado->save();

                // si el vuelo es diferente al de antes po le sumamos 1
                $vueloActual = Vuelo::findOrFail($reserva->vuelo_id);
                $vueloActual->plazas++;
                $vueloActual->save();

                // actualizamos la reserva
                $reserva->vuelo_id = $validated['vuelo_id'];
                $reserva->save();

                session()->flash('success', 'Reserva cambiada correctamente');
            } else {
                session()->flash('error', 'No hay plazas disponibles para el nuevo vuelo.');
            }
        } else {
            session()->flash('warning', 'Ya tiene seleccionado este vuelo.');
        }

        return redirect()->route('reservas.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        // cojemos el vuelo actual que vamos a borrar y le sumamos 1 a la cantidad
        $vuelo = $reserva->vuelo;
        $vuelo->plazas += 1;
        $vuelo->save();

        $reserva->delete();

        session()->flash('success', 'La reserva se ha eliminado correctamente y se ha aumentado en 1 la cantidad de plazas disponibles.');
        return redirect()->route('reservas.index');
    }
}
