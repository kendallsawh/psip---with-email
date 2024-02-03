<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DocType;

class ReplacedPsipDoc extends Model
{
    use HasFactory;
    protected $fillable = ['filepath','file_type','doc_types_id','activities_id','description','created_by', 'previous_doc_id'];
    public function activity()
    {
        return $this->belongsTo('App\Models\Activity', 'activities_id', 'id');
    }

    public function docType()
    {
        return $this->belongsTo('App\Models\DocType', 'doc_types_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

}
