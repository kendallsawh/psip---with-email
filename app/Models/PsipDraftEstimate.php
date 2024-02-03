<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsipDraftEstimate extends Model
{
    use HasFactory;
    protected $fillable = ['psip_details_id','details','draft_est','draft_est_year','financial_year','updated_by','created_by'];
    
    public function psipDetail()
    {
        return $this->belongsTo('App\Models\PsipDetail', 'psip_details_id', 'id');
    }

}
