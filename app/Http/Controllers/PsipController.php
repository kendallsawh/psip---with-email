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
use Carbon\Carbon;


class PsipController extends Controller
{
    
    public function index(Division $division) 
    {
        $psips = PsipName::where('division_id',$division->id)->paginate(10);
        $data = array(
                        'psips' => $psips,
                        'division' => $division->division_name,
                    );

        return view('home.psip_listing',$data);
    }
    public function prev_yrs() 
    {
        

        return view('home.prvyrs');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $div = Division::all();
        $data = array(
                        
                        'divisions' => $div,
                    );

        
        return view('options.add_psip',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return dd($request->all());

        $data = array('divisions' => Division::paginate(20));
        return view('home.index',$data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PsipName  $post
     * @return \Illuminate\Http\Response
     */
    public function show(PsipName $psip)
    {
        $financial_year_record = FinancialYear::first();
        $financial_year = $financial_year_record ? $financial_year_record->year : now()->year;
        $activities = Activity::where('psip_name_id', $psip->id)->where('financial_year',$financial_year)->get();
        $psipdetails = $psip->psipDetailForCurrentYear;
        if (is_null($psipdetails)) {
            $draft_estimates = json_encode(null);
            $approved_estimates = json_encode(null);
            $actual_expenditure = json_encode(null);
            $revised_estimates = json_encode(null);
        } else {
            $draft_estimates = json_encode($psip->psipDetailForCurrentYear->psipDraftEstimateGraphs);
            $approved_estimates = json_encode($psip->psipDetailForCurrentYear->psipFinancialsThisYear()->approved_estimates);
            $actual_expenditure = json_encode($psip->psipDetailForCurrentYear->psipFinancialsThisYear()->actual_expenditure);
            $revised_estimates = json_encode($psip->psipDetailForCurrentYear->psipFinancialsThisYear()->revised_estimates);
        }
        
        
        $data = array(
            'title' => $psip->psip_name.' - '.$psip->code,
            'activities' => $activities,
            'psipid' => $psip->id,
            'dtds' => DocTypeDivision::where('psip_id',$psip->id)->get(),
            'psip'=> $psip,
            'divisions' => Division::all(),
            'doctypes' => DocType::all(),
            'financial_year' => $financial_year,
            'draft_estimates' => $draft_estimates,
            'approved_estimates' => $approved_estimates,
            'actual_expenditure' => $actual_expenditure,
            'revised_estimates' => $revised_estimates,
        );
        return view('psip.test', $data);
    }

    public function edit($id)
    {
        $psip = PsipName::with([
            'psipDetailForCurrentYear', 
            'psipDetailForCurrentYear.psipFinancials', 
            'activities',
            'activities.activityParticulars'
        ])->find($id);


        return view('psipedit.edit', compact('psip'));
        
    }

    public function update(Request $request, $id)
    {
        // Find the PsipName by ID
        //return dd($request->all());
        $psip = PsipName::findOrFail($id);

        $loggedInUserId = auth()->id();  // Get the logged-in user's ID

        // Update PSIP Name
        $psip->psip_name = $request->psip_name;
        $psip->updated_by = $loggedInUserId;
        $psip->save();

        // Update PsipDetailForCurrentYear
        $psip->psipDetailForCurrentYear->update([
            'details' => trim($request->input('details')),
        ]);

        // Update Financials
        $actualExpenditures = $request->input('actual_expenditure');
        $approvedEstimates = $request->input('approved_estimates');
        $revisedEstimates = $request->input('revised_estimates');

        foreach ($psip->psipDetailForCurrentYear->psipFinancials as $index => $financial) {
            $financial->update([
                'actual_expenditure' => $actualExpenditures[$index] ?? null,
                'approved_estimates' => $approvedEstimates[$index] ?? null,
                'revised_estimates' => $revisedEstimates[$index] ?? null,
            ]);
        }

        

        

        // Update Activities
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

        return redirect()->route('psip.show',$psip->id)->with('success', 'PSIP updated successfully');
    }

    public function updateApproved(Request $request,PsipName $psip)
    {
        $psipdetail = $psip->psipDetailForCurrentYear->psipFinancialsLatest();
        $psipdetail->approved_estimates = $request->input('approved_estimates');
        $psipdetail->save();
        return redirect()->route('psip.show', $psip->id);
    }

    public function updateRevised(Request $request,PsipName $psip)
    {
        $psipdetail = $psip->psipDetailForCurrentYear->psipFinancialsLatest();
        $psipdetail->revised_estimates =$request->input('revised_estimates');
        $psipdetail->save();
        return redirect()->route('psip.show', $psip->id);
    }

     public function updateCurrentExpenditure(Request $request,PsipName $psip)
    {
        $psipdetail = $psip->psipDetailForCurrentYear->psipFinancialsLatest();
        $psipdetail->current_expenditure = $request->input('current_expenditure');
        $psipdetail->current_expenditure_dt = Carbon::now()->toDateString();
        $psipdetail->save();
        return redirect()->route('psip.show', $psip->id);
    }

    public function surpressPsip(Request $request,PsipName $psip)
    {
        $psip->status_id = 3;
        $psip->cancelled_by = auth()->id();
        $psip->save();
        return redirect()->route('psip.show', $psip->id);
    }

    public function startProcess()
    {
        //return 'hight there';
        $financial_year_record = FinancialYear::first();
        //$financial_year = $financial_year_record ? $financial_year_record->year : now()->year;
        $financial_year = '2024';

        $psipDetails = PsipDetail::where('financial_year', $financial_year)->get();

        foreach ($psipDetails as $psipDetail) {
            // Fetch associated psip_draft_estimates
            $draftEstimates = PsipDraftEstimate::where('psip_details_id', $psipDetail->id)->get();

            if ($draftEstimates->isEmpty()) {
                continue;
            }

            // Find the nearest financial_year among draftEstimates
            $nearestDraftEstimate = $draftEstimates->sortBy('financial_year')->first();

            // Create new records based on nearestDraftEstimate
            // Create a new record in psip_details
            $newPsipDetail = PsipDetail::create([
                'psip_name_id' => $psipDetail->psip_name_id,
                'financial_year' => $nearestDraftEstimate->draft_est_year,
                'details' => $nearestDraftEstimate->details,
                // ... any other fields
            ]);

            // Create a new record in psip_financials
            $psipFinancial = PsipFinancial::create([
                'psip_details_id' => $newPsipDetail->id,
                'revised_estimates' => $nearestDraftEstimate->draft_est,
                'financial_year' => $psipDetail->financial_year,
                // ... any other fields
            ]);

            // Reinsert remaining records
            $remainingDraftEstimates = $draftEstimates->where('id', '!=', $nearestDraftEstimate->id);
            
            foreach ($remainingDraftEstimates as $remainingDraftEstimate) {
                PsipDraftEstimate::create([
                    'psip_details_id' => $newPsipDetail->id, // assuming $newPsipDetail is the newly created record
                    'details' => $remainingDraftEstimate->details,
                    'draft_est' => $remainingDraftEstimate->draft_est,
                    'draft_est_year' => $remainingDraftEstimate->draft_est_year,
                    'financial_year' => $newPsipDetail->financial_year,
                    // ... other fields
                ]);
            }
        }

        // Redirect or further processing
    }

}
