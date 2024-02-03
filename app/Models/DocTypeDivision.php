<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Division;
use App\Models\PsipName;
use App\Models\DocType;

class DocTypeDivision extends Model
{
    use HasFactory;
    protected $fillable = ['document_id','division_id','psip_id','activity_id'];

    public function getDivisionAttribute(){
        return Division::where('id','=',$this->division_id)->first()->division_name;

    }
    public function getDocumentAttribute(){
        return DocType::where('id','=',$this->document_id)->first()->doc_type_name;
    }
    public function getPSIPAttribute(){
        
    }

    public function division()
    {
        return $this->belongsTo('App\Models\Division', 'division_id', 'id');
    }

    public function document()
    {
        return $this->belongsTo('App\Models\DocType', 'document_id', 'id');
    }

    public function psip()
    {
        return $this->belongsTo('App\Models\PsipName', 'psip_id', 'id');
    }

    public function createdBy()
    {
            return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

}
