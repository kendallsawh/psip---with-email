<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use HttpFoundation\Response;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use App\Models\Division;
use App\Models\FinancialYear;

class HomeController extends Controller
{
    public function index() 
    {
        $data = array('divisions' => Division::orderBy('division_name','asc')->paginate(25), 'financial_year'=>FinancialYear::first()->year);

        return view('home.index',$data);
    }

    
}
