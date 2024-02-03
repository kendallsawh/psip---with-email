<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PsipFinancial extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['psip_details_id','actual_expenditure','approved_estimates','revised_estimates','financial_year','updated_by','created_by'];
    public function psipDetail()
    {
        return $this->belongsTo('App\Models\PsipDetail', 'psip_details_id', 'id');
    }
}
