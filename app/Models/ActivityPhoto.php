<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ActivityPhoto extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['activity_id','file_path','type','title','uploaded_by'];

    public function activity()
    {
        return $this->belongsTo('App\Models\Activity', 'activities_id', 'id');
    }
}
