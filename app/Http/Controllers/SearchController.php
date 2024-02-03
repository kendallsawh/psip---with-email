<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PsipName;
use App\Models\Activity;

class SearchController extends Controller
{
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        //return response->json('test');
        $data = PsipName::select("code as value", "id")
                    ->where('code', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();
    
        return response()->json($data);
    }

    public function searchresult(Request $request)
    {
        return $request;
        
    }
}
