<?php

namespace App\Http\Controllers;

use App\Models\Ville;
use Illuminate\Http\Request;

class VilleController extends Controller
{
    public function index()
    {
        // Récupérer les villes avec leurs quartiers, triées par ordre alphabétique
        $villes = Ville::with('quartiers')->orderBy('name', 'asc')->get();

        return response()->json(['data' => $villes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $villes = Ville::create([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Ville créée avec succès', 'data' => $villes], 201);
    }

    public function show($id)
    {
        $ville = Ville::with('quartiers')->find($id);

        if (!$ville) {
            return response()->json(['message' => 'Ville non trouvée'], 404);
        }

        return response()->json(['data' => $ville]);
    }

    public function update(Request $request, $id)
    {
        $ville = Ville::find($id);

        if (!$ville) {
            return response()->json(['message' => 'Ville non trouvée'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $ville->update([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Ville mise à jour avec succès', 'data' => $ville]);
    }

    public function destroy($id)
    {
        $ville = Ville::find($id);

        if (!$ville) {
            return response()->json(['message' => 'Ville non trouvée'], 404);
        }

        $ville->delete();

        return response()->json(['message' => 'Ville supprimée avec succès']);
    }
}