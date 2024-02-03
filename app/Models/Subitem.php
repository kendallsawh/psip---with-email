<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subitem extends Model
{
    use HasFactory;

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'items_id', 'id');
    }
    
    public function groups()
    {
        return $this->hasMany('App\Models\Group', 'subitems_id', 'id');
    }

}
