<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ThemesController extends Controller
{
    /**
     * Afficher la liste des thèmes.
     */
    public function index()
    {
        $themes = Theme::all();
        return response()->json(['data' => $themes]);
    }

    /**
     * Afficher les détails d'un thème spécifique.
     */
    public function show(Theme $theme)
    {
        return response()->json(['data' => $theme]);
    }

    /**
     * Enregistrer un nouveau thème.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:themes',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $theme = Theme::create([
            'name' => $request->name,
        ]);

        return response()->json(['data' => $theme, 'message' => 'Thème créé avec succès'], 201);
    }

    /**
     * Mettre à jour un thème existant.
     */
    public function update(Request $request, Theme $theme)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:themes,name,' . $theme->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $theme->update([
            'name' => $request->name,
        ]);

        return response()->json(['data' => $theme, 'message' => 'Thème mis à jour avec succès']);
    }

    /**
     * Supprimer un thème.
     */
    public function destroy(Theme $theme)
    {
        $theme->delete();
        return response()->json(['message' => 'Thème supprimé avec succès']);
    }
} 