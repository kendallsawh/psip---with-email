<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public function subitem()
    {
        return $this->belongsTo('App\Models\Subitem', 'subitems_id', 'id');
    }

    public function psipNames()
    {
        return $this->hasMany('App\Models\PsipName', 'groups_id', 'id');
    }


}
