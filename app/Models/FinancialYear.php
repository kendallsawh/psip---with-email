<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * FinancialYear Model.
 *
 * Represents the financial year within the application.
 */

class FinancialYear extends Model
{
    use HasFactory;
    protected $fillable = ['financial_year'];
}
