<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PsipDoc;
use App\Models\DocType;
use App\Models\PsipName;
use App\Models\Division;
use App\Models\PsipTag;
use App\Models\Status;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Activity extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['psip_name_id','activity_name','financial_year','allocation','status_id','cancelled_by','deleted_by','activity_order','updated_by'];

    public function getDocumentsAttribute($value='')
    {
        return PsipDoc::where('activities_id',$this->id)->orderBy('doc_types_id', 'asc')->get();
    }

    public function psipName()
    {
        return $this->belongsTo(PsipName::class);
    }

    public function activityParticulars()
    {
        return $this->hasMany('App\Models\ActivityParticular', 'activity_id', 'id');
    }

    public function psipDocs()
    {
        return $this->hasMany('App\Models\PsipDoc', 'activities_id', 'id');
    }

    public function activityPhotos()
    {
        return $this->hasMany('App\Models\ActivityPhoto', 'activities_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

}
