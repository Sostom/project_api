<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;

class DesignationController extends Controller
{
    /**
     * Affiche la liste des titres de propriété.
     */
    public function index()
    {
        $designations = Designation::all();
        return response()->json($designations);
    }

    /**
     * Affiche un titre spécifique.
     */
    public function show($id)
    {
        $designation = Designation::find($id);

        if (!$designation) {
            return response()->json(['message' => 'Titre de propriété non trouvé'], 404);
        }

        return response()->json($designation);
    }

    /**
     * Enregistre un nouveau titre de propriété.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $designation = Designation::create([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Titre de propriété crée avec succès', 'data' => $designation], 201);
    }

    /**
     * Met à jour un titre existant.
     */
    public function update(Request $request, $id)
    {
        $designation = Designation::find($id);

        if (!$designation) {
            return response()->json(['message' => 'Titre de propriété non trouvé'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $designation->update([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Titre de propriété mis à jour avec succès', 'data' => $designation]);
    }

    /**
     * Supprime un titre de propriété.
     */
    public function destroy($id)
    {
        $designation = Designation::find($id);

        if (!$designation) {
            return response()->json(['message' => 'Titre de propriété non trouvé'], 404);
        }

        $designation->delete();

        return response()->json(['message' => 'Titre de propriété supprimé avec succès']);
    }
}