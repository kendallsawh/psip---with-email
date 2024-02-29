<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DocType;
use Illuminate\Database\Eloquent\SoftDeletes;

class PsipDoc extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['filepath','file_type','doc_types_id','activities_id','description','created_by', 'previous_doc_id', 'doc_group_id', 'doc_title'];
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

    public function docGroup()
    {
        return $this->belongsTo('App\Models\DocType', 'doc_group_id', 'id');
    }

    /*public function getDocumentAttribute(){
        return DocType::where('id','=',$this->document_id)->first()->doc_type_name;
    }*/

}
