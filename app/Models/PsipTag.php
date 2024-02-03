<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsipTag extends Model
{
    use HasFactory;
    public function psip()
    {
        return $this->belongsTo('App\Models\PsipName', 'psip_id', 'id');
    }

}
