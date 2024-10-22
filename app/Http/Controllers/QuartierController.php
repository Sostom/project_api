<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quartier;
use App\Models\Ville;

class QuartierController extends Controller
{
    public function index()
    {
        // Récupérer les quartiers avec leurs villes associées, triés par ordre alphabétique
        $quartiers = Quartier::with('ville')->orderBy('name', 'asc')->get();

        return response()->json(['data' => $quartiers]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ville_id' => 'required|exists:villes,id',
        ]);

        $quartier = Quartier::create([
            'name' => $request->name,
            'ville_id' => $request->ville_id,
        ]);

        return response()->json(['message' => 'Quartier créé avec succès', 'data' => $quartier], 201);
    }

    public function show($id)
    {
        $quartier = Quartier::with('ville')->find($id);

        if (!$quartier) {
            return response()->json(['message' => 'Quartier non trouvé'], 404);
        }

        return response()->json(['data' => $quartier]);
    }

    public function update(Request $request, $id)
    {
        $quartier = Quartier::find($id);

        if (!$quartier) {
            return response()->json(['message' => 'Quartier non trouvé'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'ville_id' => 'required|exists:villes,id',
        ]);

        $quartier->update([
            'name' => $request->name,
            'ville_id' => $request->ville_id,
        ]);

        return response()->json(['message' => 'Quartier mis à jour avec succès', 'data' => $quartier]);
    }

    public function destroy($id)
    {
        $quartier = Quartier::find($id);

        if (!$quartier) {
            return response()->json(['message' => 'Quartier non trouvé'], 404);
        }

        $quartier->delete();

        return response()->json(['message' => 'Quartier supprimé avec succès']);
    }
}