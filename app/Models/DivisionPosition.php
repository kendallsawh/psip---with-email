<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionPosition extends Model
{
    use HasFactory;
    public function division()
    {
        return $this->belongsTo('App\Models\Division', 'division_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo('App\Models\Position', 'position_id', 'id');
    }

}
