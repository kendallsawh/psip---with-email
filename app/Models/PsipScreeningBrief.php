<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PsipName;

class PsipScreeningBrief extends Model
{
    use HasFactory;

    public function psip()
    {
        return $this->belongsTo(PsipName::class, 'psip_names_id', 'id');
    }
}
