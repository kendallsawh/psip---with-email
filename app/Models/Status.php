<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Activity;
use App\Models\PsipName;

class Status extends Model
{
    use HasFactory;
    protected $table = 'statuses';

    public function activities()
    {
        return $this->hasMany(Activity::class, 'status_id', 'id');
    }

    public function psipNames()
    {
        return $this->hasMany(PsipName::class, 'status_id', 'id');
    }
}
