<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use HttpFoundation\Response;
use Illuminate\Filesystem\Filesystem;
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
use App\Models\Group;
use Carbon\Carbon;


class DataEntryController extends Controller
{
   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $div = Division::all();
        $groups = Group::all();
        $psip = PsipName::find($id);
        $data = array(
                        
                        'divisions' => $div,
                        'groups' => $groups,
                        'psip'=>$psip,
                    );

        
        return view('dataentry.dataentry',$data);
    }

    public function store(Request $request, PsipName $psip)
    {       

        $psipdetail = new PsipDetail([
            'psip_name_id' => $psip->id,
            'financial_year' => $request->input('financial_year'),
            'details' => $request->input('description'),
        ]);
        $psipdetail->save();

        // Store in psip_draft_estimates table
        $psipfinancial = new PsipFinancial([
            'psip_details_id' => $psipdetail->id,
            'actual_expenditure' => $details,
            'approved_estimates' => $draftEst,
            'revised_estimates' => $draftEstYear,
            'current_expenditure' => $financial_year,
            'financial_year' => $request->input('financial_year'),
            'created_by' => auth()->id()
        ]);
        $draftEstimate->save();
        // Get the submitted data
        $activityNames = $request->input('activity_name');
        $particulars = $request->input('particulars');
        $particularsCost = $request->input('particulars_cost');

        // Loop through each activity
        foreach ($activityNames as $index => $activityName) {
            
            // Create a new Activity and associate it with the current PsipName
            $activity = new Activity(['activity_name' => $activityName]);
            $activity = $psip->activities()->save($activity);

            // Loop through each particular for the current activity
            foreach ($particulars[$index] as $j => $particular) {
                $cost = $particularsCost[$index][$j];

                // Create a new ActivityParticular and associate it with the current Activity
                $activityParticular = new ActivityParticular([
                    'activity_id' => $activity->id,
                    'particulars' => $particular,
                    'particulars_cost' => $cost,
                ]);
                $activity->activityParticulars()->save($activityParticular);
            }
        }
    }
}
