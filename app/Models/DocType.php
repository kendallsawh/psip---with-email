<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocType extends Model
{
    use HasFactory, SoftDeletes;
    public function psipDocs()
    {
        return $this->hasMany('App\Models\PsipDoc', 'doc_types_id', 'id');
    }

}
