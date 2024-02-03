<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PsipName;
use Illuminate\Database\Eloquent\SoftDeletes;

class PsipScreeningBrief extends Model
{
    use HasFactory, SoftDeletes;

    public function psip()
    {
        return $this->belongsTo(PsipName::class, 'psip_names_id', 'id');
    }
}
