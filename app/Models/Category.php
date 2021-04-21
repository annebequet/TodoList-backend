<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Relationship with Task
     *
     * foreach ($category->tasks as $task) {
     *   echo $task->title;
     * }
     */
    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
    }
}
