<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundType extends Model
{
    use HasFactory;
    public function items()
    {
        return $this->hasMany('App\Models\Item', 'fund_types_id', 'id');
    }

}
