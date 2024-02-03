<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use HttpFoundation\Response;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use App\Models\PsipName;
use App\Models\Division;
use App\Models\Activity;
use App\Models\FinancialYear;//there is a middleware updatefinancialyear that automatically updates the year record in the database on september 30th

class ActivityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $psip = PsipName::all();
        $data = array(
                        
                        'psips' => $psip,
                    );

        
        return view('options.add_activity',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $financial_year_record = FinancialYear::first();
        $financial_year = $financial_year_record ? $financial_year_record->year : now()->year;

        $activity = new Activity;
        $activity->psip_name_id = $request->psip;
        $activity->activity_name = $request->activity;
        $activity->financial_year = $financial_year;
        $activity->allocation = $request->allocation;
        $activity->save();
        

        return redirect()->route('psip.show', ['psip' => $request->psip]);


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

    public function surpressActivity(Request $request)
    {
        $activity = Activity::find($request->surpress_activity);
        $activity->status_id = 3;
        //$psip->cancelled_by = auth()->id();
        $activity->save();
        return redirect()->back();
    }

    public function softDelete(Request $request)
    {
        $activity = Activity::find($request->remove_activity);
        $activity->delete();
        $activity->deleted_by = auth()->id();
        $activity->save();
        return redirect()->back();
    }

    //use this function to add psip details and activities dynamically though something similar alread exists
    public function functiontocontinuedeveloping(Request $request, PsipName $psipname)
    {
        // Validate the request (optional but recommended)
        $request->validate([
            'activity_name.*' => 'required|string',
            'particulars.*.*' => 'required|string',
            'particulars_cost.*.*' => 'required|numeric',
        ]);

        //Get financial year
        $financial_year_record = FinancialYear::first();
        $financial_year = $financial_year_record ? $financial_year_record->year : now()->year;

        // Get the submitted data
        $activityNames = $request->input('activity_name');
        $particulars = $request->input('particulars');
        $particularsCost = $request->input('particulars_cost');

        // Loop through each activity
        foreach ($activityNames as $index => $activityName) {
            
            // Create a new Activity and associate it with the current PsipName
            $activity = new Activity(['activity_name' => $activityName]);
            $activity = $psipname->activities()->save($activity);

            // Loop through each particular for the current activity
            foreach ($particulars[$index] as $j => $particular) {
                $cost = $particularsCost[$index][$j];

                // Create a new ActivityParticular and associate it with the current Activity
                $activityParticular = new ActivityParticular([
                    'particulars' => $particular,
                    'particulars_cost' => $cost,
                ]);
                $activity->activityParticulars()->save($activityParticular);
            }
        }

        // Redirect or do whatever you need to after storing the records
        return redirect()->route('your.redirect.route');
    }
}
