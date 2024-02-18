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
use DB;
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
        $psip = PsipName::with([
            'psipDetailForCurrentYear', 
            'psipDetailForCurrentYear.psipFinancials', 
            'activities',
            'activities.activityParticulars'
        ])->find($id);


        return view('psipactivity.edit_activity', compact('psip'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function update(Request $request, $id)
    {
        $psip = PsipName::findOrFail($id);
        // Update Activities
        DB::beginTransaction();
        try {
            $activityNames = $request->input('activity_name');
            $particulars = $request->input('particulars');
            $particularsCost = $request->input('particulars_cost');

            foreach ($psip->activities as $index => $activity) {
                $activity->update([
                    'activity_name' => $activityNames[$index] ?? null,
                    'updated_by' => $loggedInUserId,
                ]);

                foreach ($activity->activityParticulars as $pIndex => $particular) {
                    $particular->update([
                        'particulars' => $particulars[$pIndex] ?? null,
                        'particulars_cost' => $particularsCost[$pIndex] ?? null,
                        'updated_by' => $loggedInUserId,
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('psip.show',$psip->id)->with('success', 'PSIP updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect('/activity-edit/'.$psip->id)
            ->withInput();
        }
        
    }*/

    public function update(Request $request, $id)
{
    //return dd($request->all());
    $psip = PsipName::findOrFail($id);
    $activityOrders = $request->input('activity_order',[]);
    $activityIds = $request->input('activity_id',[]);
    // Update Activities
    DB::beginTransaction();
    try {
        $activityNames = $request->input('activity_name',[]);
        $particulars = $request->input('particulars');
        $particularsCost = $request->input('particulars_cost');
        $loggedInUserId = auth()->id(); // Assuming you're getting the logged-in user's ID like this
        //return dd($activityOrders);

        foreach ($activityIds as  $activityId) {
            $activity = Activity::find($activityId);
            //return dd($activityOrders[$activityId],$activityNames[$activityId]);
            if ($activity) {
                $activity->update([
                    'activity_order' => $activityOrders[$activityId],
                    'activity_name' => $activityNames[$activityId], // Ensure this matches how you're sending the data
                    'updated_by' => $loggedInUserId,
                ]);
                
                    /*$activity->activity_order = $activityOrders[$activityId];
                    $activity->activity_name = $activityNames[$activityId]; // Ensure this matches how you're sending the data
                    $activity->updated_by = $loggedInUserId;
                    $activity->save();*/

                // Assuming particulars and particularsCost are sent in a way that they can be matched by activityId
                if (isset($particulars[$activityId]) && isset($particularsCost[$activityId])) {
                    foreach ($activity->activityParticulars as $pIndex => $particular) {
                        $particular->update([
                            'particulars' => $particulars[$pIndex][$particular] ?? null,
                            'particulars_cost' => $particularsCost[$pIndex][$particular] ?? null,
                            'updated_by' => $loggedInUserId,
                        ]);
                    }
                }
            }
        }

        DB::commit();
        return redirect()->route('psip.show', $psip->id)->with('success', 'PSIP updated successfully');
    } catch (Exception $e) {
        DB::rollBack();
        Log::error($e->getMessage());
        return redirect('activity/activity-edit/'.$psip->id)
                ->withInput();
    }
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
