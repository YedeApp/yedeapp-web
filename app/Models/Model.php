<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    public function scopeRecent($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sorting', 'asc')->orderBy('id', 'desc');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
