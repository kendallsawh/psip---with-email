<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PsipName;
use Illuminate\Database\Eloquent\SoftDeletes;

class PsipPsNote extends Model
{
    use HasFactorySoftDeletes;

    public function psip()
    {
        return $this->belongsTo(PsipName::class, 'psip_names_id', 'id');
    }
}
