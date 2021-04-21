<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * Relationship with Category
     *
     * $task->category->name;
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
