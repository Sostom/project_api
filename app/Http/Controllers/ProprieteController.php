<?php

namespace App\Http\Controllers;

use App\Models\Propriete;
use Illuminate\Http\Request;

class ProprieteController extends Controller
{
    // Méthode pour récupérer toutes les propriétés
    public function index()
    {
        $proprietes = Propriete::with(['ville', 'quartier'])->get();
        return response()->json($proprietes);
    }

    // Méthode pour récupérer une propriété spécifique
    public function show($id)
    {
        $propriete = Propriete::find($id);

        if (!$propriete) {
            return response()->json(['message' => 'Propriété non trouvée'], 404);
        }

        return response()->json($propriete);
    }

    // Méthode pour ajouter une nouvelle propriété
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'designation_id' => 'required|exists:designations,id',
            'ville_id' => 'required|exists:villes,id',
            'quartier_id' => 'nullable|exists:quartiers,id',
            'indication' => 'nullable|string',
            'description' => 'nullable|array',
            'prix' => 'required|integer|min:0',
            'picture' => 'nullable|string',
            'statut' => 'nullable|in:disponible,occupé',
            'user_id' => 'required|exists:users,id',
        ]);

        $propriete = Propriete::create($validatedData);

        return response()->json(['message' => 'Propriété ajoutée avec succès!', 'data' => $propriete], 201);
    }

    // Méthode pour mettre à jour une propriété
    public function update(Request $request, $id)
    {
        $propriete = Propriete::find($id);

        if (!$propriete) {
            return response()->json(['message' => 'Propriété non trouvée'], 404);
        }

        $validatedData = $request->validate([
            'designation_id' => 'required|exists:designations,id',
            'ville_id' => 'required|exists:villes,id',
            'quartier_id' => 'nullable|exists:quartiers,id',
            'indication' => 'nullable|string',
            'description' => 'nullable|array',
            'prix' => 'required|integer|min:0',
            'picture' => 'required|string',
            'statut' => 'nullable|in:disponible,occupé',
            'user_id' => 'required|exists:users,id',
        ]);

        $propriete->update($validatedData);

        return response()->json(['message' => 'Propriété mise à jour avec succès!', 'data' => $propriete], 200);
    }

    // Méthode pour supprimer une propriété
    public function destroy($id)
    {
        $propriete = Propriete::find($id);

        if (!$propriete) {
            return response()->json(['message' => 'Propriété non trouvée'], 404);
        }

        $propriete->delete();

        return response()->json(['message' => 'Propriété supprimée avec succès!'], 200);
    }
}
