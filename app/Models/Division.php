<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PsipName;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
{
    use HasFactory, SoftDeletes;

    public function countpsip()
    {
        $count = PsipName::where('division_id',$this->id)->count();
        if ($count>=1) {
            return $count;
        } else {
            return 0;
        }
        
         
    }

    /*public function psipNames()
    {
        return $this->hasMany(PsipName::class);
    }*/

    public function psipNames()
    {
        return $this->hasMany('App\Models\PsipName', 'division_id', 'id');
    }

    public function divisionPositions()
    {
        return $this->hasMany('App\Models\DivisionPosition', 'division_id', 'id');
    }

    public function docTypeDivisions()
    {
        return $this->hasMany('App\Models\DocTypeDivision', 'division_id', 'id');
    }

}
