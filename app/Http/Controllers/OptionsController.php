<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PsipName;
use App\Models\Division;
use App\Models\FinancialYear;//there is a middleware updatefinancialyear that automatically updates the year record in the database on september 30th
use App\Models\PsipDetail;
use App\Models\PsipFinancial;
use App\Models\Activity;
use App\Models\ActivityParticular;
use App\Models\DocTypeDivision;
use App\Models\DocType;
use App\Models\PsipDraftEstimate;
use Carbon\Carbon;

class OptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_psip()
    {
        /*$year = FinancialYear::first()->year;
        $psips = PsipName::whereHas('psipDetails', function ($query) use($year) {
                            $query->where('financial_year', '<>', $year);
                            })->with(['psipDetails' => function ($query) use($year) {
                            $query->where('financial_year', '<>', $year)->orderBy('financial_year','desc')->get();}])->get();
        return $psips->first();*/

        $year = FinancialYear::first()->year;
        $psips = PsipName::whereHas('psipDetails', function ($query) use($year) {
            $query->where('financial_year', '<>', $year);
        })
        ->with(['psipDetails' => function ($query) use($year) {
            $query->where('financial_year', '<>', $year)->orderBy('financial_year','desc');
        }])
        ->get();

        // Assuming you want the psip_details of the first PsipName that meets the criteria
        //$psipDetails = optional($psips->first())->psipDetails->first()->details;

        //return $psipDetails;
       /* $psips = PsipName::where('status_id','<>',3)->get();*/
        return view('options.update_psip_financial',compact('psips'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_psip_store(Request $request)
    {
        //return dd($request->all());
        $year = FinancialYear::first()->year;
        $psipdetail = new PsipDetail;
        foreach ($request->psip as $key =>$p) {
            $psipdetail->psip_name_id = $p;
            $psipdetail->details = $request->objective[$key];
            $psipdetail->financial_year = $year;
            $psipdetail->save();

            $psipfinancial = new PsipFinancial;
            $psipfinancial->psip_details_id = $psipdetail->id;
            $psipfinancial->actual_expenditure = 0;
            $psipfinancial->approved_estimates = 0;
            $psipfinancial->revised_estimates = 0;
            $psipfinancial->current_expenditure = 0;
            $psipfinancial->financial_year =$year;
            $psipfinancial->save();

            $psipsoftdelete = PsipDetail::where('psip_name_id',$p )
                                        ->where('financial_year', '<>', $year)
                                        ->delete();
        }

        
        
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
