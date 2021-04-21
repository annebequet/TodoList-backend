<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function list()
    {
        $categoriesList = Category::all();

        return response()->json($categoriesList);
    }

    /**
     * Get a category
     *
     * @param int $id Category's ID
     */
    public function item($id)
    {
        // Cherche les données de la catégorie à partir de l'id et s'il ne trouve rien, une réponse 404 est envoyée
        $category = Category::findOrFail($id);

        return response()->json($category);
    }
}
