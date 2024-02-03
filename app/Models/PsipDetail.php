<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PsipDetail extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['psip_name_id','psip_date','financial_year','recurring','details'];
   
    public function psipName()
    {
        return $this->belongsTo('App\Models\PsipName', 'psip_name_id', 'id');
    }
    public function psipFinancialsThisYear()
    {
        return $this->hasMany('App\Models\PsipFinancial', 'psip_details_id', 'id')->first();
    }
    public function psipFinancials()
    {
        return $this->hasMany('App\Models\PsipFinancial', 'psip_details_id', 'id');
    }

    public function psipFinancialsLatest()
    {
        return $this->hasMany('App\Models\PsipFinancial', 'psip_details_id', 'id')->latest('id')->first();
    }

    public function psipDraftEstimate()
    {
        return $this->hasMany('App\Models\psipDraftEstimate', 'psip_details_id', 'id');
    }

    public function psipDraftEstimateGraphs()
    {
        return $this->hasMany('App\Models\psipDraftEstimate', 'psip_details_id', 'id')->select(['draft_est','draft_est_year']);
    }

    public function psipDetails()
    {
        return $this->hasMany('App\Models\PsipDetail', 'psip_details_id', 'id');
    }
}
