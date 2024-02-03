<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    public function fundType()
    {
        return $this->belongsTo('App\Models\FundType', 'fund_types_id', 'id');
    }

    public function subitems()
    {
        return $this->hasMany('App\Models\Subitem', 'items_id', 'id');
    }


}
