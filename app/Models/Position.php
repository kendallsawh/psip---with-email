<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    public function divisionPositions()
    {
        return $this->hasMany('App\Models\DivisionPosition', 'position_id', 'id');
    }

}
