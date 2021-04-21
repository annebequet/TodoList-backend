<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function list()
    {
        $taskList = Task::all();

        // Je demande à Eloquent de récupérer les données de la catégorie associée à la tâche
        $taskList->load('category');

        return response()->json($taskList);
    }

    /**
     * Add a task
     *
     * @param Request $request HTTP request object representation
     */
    public function add(Request $request)
    {
        // Je valide les données reçues dans ma requête HTTP
        $this->validate(
            $request,
            [
                'title'      => 'required|string|min:2|max:128',
                'completion' => 'required|integer|min:0|max:100',
                'status'     => 'required|integer|in:1,2,3',
                'categoryId' => 'required|integer|exists:App\Models\Category,id'
            ]
        );

        $task = new Task;

        // J'affecte les données envoyées dans la requête à mon model
        /*
        // Avec une variable intermédiaire
        $title = $request->input('title');

        $task->title = $title;

        // Avec la méthode input
        $task->title = $request->input('title');

        // Avec la propriété virtuelle
        $task->title = $request->title;
        */
        // Avec la méthode json
        $task->title       = $request->json('title');
        $task->category_id = $request->json('categoryId');
        $task->status      = $request->json('status');
        $task->completion  = $request->json('completion');

        // Je sauvegarde dans la base de données ma nouvelle tâche. Si la sauvegarde échoue, une réponse avec code 500 sera automatiquement envoyée.
        $task->save();

        $task->load('category');

        // J'envoie dans la réponse HTTP la nouvelle tâche formatée en JSON avec le code de réponse 201 Created
        return response()->json($task, 201);
    }

    /**
     * Overwrite a task
     *
     * @param Request $request HTTP request object representation
     * @param int     $id Task id
     */
    public function overwrite(Request $request, $id)
    {
        // Si la tâche n'est pas trouvé, une réponse avec le code 404 est automatiquement envoyée
        $task = Task::findOrFail($id);

        // Je valide les données reçues dans la requête HTTP
        $this->validate(
            $request,
            [
                'title'      => 'required|string|min:2|max:128',
                'completion' => 'required|integer|min:0|max:100',
                'status'     => 'required|integer|in:1,2,3',
                'categoryId' => 'required|integer|exists:App\Models\Category,id'
            ]
        );

        // J'écrase les données de ma tâche
        $task->title       = $request->json('title');
        $task->category_id = $request->json('categoryId');
        $task->status      = $request->json('status');
        $task->completion  = $request->json('completion');

        // Je sauvegarde les données modifiées de ma tâche
        $task->save();

        // Automatiquement, une réponse avec code 200 sera envoyée
    }

    /**
     * Update a task
     *
     * @param Request $request HTTP request object representation
     * @param int     $id Task id
     */
    public function update(Request $request, $id)
    {
        // Si la tâche n'est pas trouvé, une réponse avec le code 404 est automatiquement envoyée
        $task = Task::findOrFail($id);

        // Je valide les données reçues dans la requête HTTP (aucune donnée n'est obligatoire en PATCH)
        $this->validate(
            $request,
            [
                'title'      => 'string|min:2|max:128',
                'completion' => 'integer|min:0|max:100',
                'status'     => 'integer|in:1,2,3',
                'categoryId' => 'integer|exists:App\Models\Category,id'
            ]
        );

        // Si au moins une donnée est renseignée...
        if (
            $request->has('title') ||
            $request->has('completion') ||
            $request->has('status') ||
            $request->has('categoryId')
        ) {
            // ... je fais la mise à jour
            if ($request->has('title')) {
                $task->title = $request->input('title');
            }

            if ($request->has('completion')) {
                $task->completion = $request->input('completion');
            }

            if ($request->has('status')) {
                $task->status = $request->input('status');
            }

            if ($request->has('categoryId')) {
                $task->category_id = $request->input('categoryId');
            }

            $task->save();
        } else {
            // Sinon, je déclenche une erreur 204 No Content
            return response('', 204);
        }

    }
}
