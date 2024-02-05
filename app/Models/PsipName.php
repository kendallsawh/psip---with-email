<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FinancialYear;
use App\Models\PsipDetail;
use App\Models\Division;
use App\Models\Status;
use App\Models\PsipScreeningBrief;
use App\Models\PsipPsNote;

class PsipName extends Model
{
    use HasFactory;
    protected $fillable = ['psip_name','code','description','division_id','groups_id','updated_by','created_by','status_id','cancelled_by'];
    public function division()
    {
        return $this->belongsTo('App\Models\Division', 'division_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Group', 'groups_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function activities()
    {
        return $this->hasMany('App\Models\Activity', 'psip_name_id', 'id');
    }

    /*public function screeningBrief()
    {
        return $this->hasMany('App\Models\PsipScreeningBrief', 'psip_names_id', 'id');
    }*/

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function psipDraftEstimates()
    {
        return $this->hasMany('App\Models\PsipDraftEstimate', 'psip_names_id', 'id');
    }

    public function psipDetailForCurrentYear()
    {
        $financial_year_record = FinancialYear::first();
        $year = $financial_year_record ? $financial_year_record->year : now()->year; // Retrieve the year from the FinancialYear model
        return $this->hasOne(PsipDetail::class)->where('financial_year', $year);
    }

    public function psipDetailsExceptCurrentYear()
    {
        $year = FinancialYear::first()->year; // Retrieve the year from the FinancialYear model
        return $this->hasMany(PsipDetail::class)->where('financial_year', '<>', $year);
    }

    public function psipDetailsLast()
    {
        $year = FinancialYear::first()->year; // Retrieve the year from the FinancialYear model
        return $this->hasMany(PsipDetail::class)->where('financial_year', '<>', $year)->orderBy('financial_year','desc')->first();
    }

    public function psipDetails()
    {
        
        return $this->hasMany(PsipDetail::class);
    }
    /*screening brief functions*/
    public function mostRecentScreeningBrief()
    {
        return $this->hasOne(PsipScreeningBrief::class, 'psip_names_id', 'id')->latest();
    }
    
    public function screeningBriefs()
    {
        return $this->hasMany(PsipScreeningBrief::class, 'psip_names_id', 'id');
    }

    public function screeningBriefsWithTrashed()
    {
        return $this->hasMany(PsipScreeningBrief::class, 'psip_names_id', 'id')->withTrashed();
    }
    /*ps note functions*/
    public function mostRecentPsNote()
    {
    // Assuming 'created_at' or 'id' for ordering, adjust as necessary
        return $this->hasOne(PsipPsNote::class, 'psip_names_id', 'id')->latest();
    }
    public function psNotes()
    {
        return $this->hasMany(PsipPsNote::class, 'psip_names_id', 'id');
    }
    public function psNotesWithTrashed()
    {
        return $this->hasMany(PsipPsNote::class, 'psip_names_id', 'id')->withTrashed();
    }


}
