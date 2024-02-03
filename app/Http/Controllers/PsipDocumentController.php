<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PsipDoc;
use App\Models\DocType;
use App\Models\PsipName;
use App\Models\Division;
use App\Models\PsipTag;
use App\Models\Activity;
use App\Models\DocTypeDivision;
use App\Models\ReplacedPsipDoc;
use DB;
use Illuminate\Support\Facades\Log;
use App\Events\DocumentUploadedEvent;



class PsipDocumentController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Activity $activity)
    {
        

        return view('psipupload.create',[
            'activity' => $activity, 
            'folder_types' => Activity::all(),
            'doc_types' => DocType::orderBy('doc_type_name','ASC')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Activity $activity)
    {
        //return $activity->id;
        
        DB::beginTransaction();//BEGIN THE PROCESS
        try{
            $psipdoc = new PsipDoc;
            $psipdoc->activities_id = $activity->id;
            $psipdoc->doc_types_id = $request->doc_type;
            $psipdoc->doc_title = $request->title;
            $psipdoc->description = $request->description;
            $psip = $activity->psipName->id;
            $psipdoc->save();
            $docname=trim(DocType::find($request->doc_type)->doc_type_name);
            




            if (isset($request->file_upload)) {
                        sleep(2);
                    $file = $request->file_upload;
                    if (!empty($file)) {
                        $activity_code = str_replace(' ', '_', $activity->id);
                        $doc_name_sanitized = str_replace(' ', '_', $docname);
                        $doc = $activity_code.'_'.$doc_name_sanitized.'_Scan_'.md5($file->getClientOriginalName()).'.'.$file->extension();
                        // upload document
                        $file->storeAs('public/documents', $doc);


                        $psipdoc->filepath = "documents/".$doc;
                        $psipdoc->file_type = $file->extension();
                        $psipdoc->save();
                        event(new DocumentUploadedEvent(\Auth::user(), DocType::find($request->doc_type)));
                    }
                }
        
        DB::commit();
            return redirect()->route('psip.show',['psip' => $psip])
            ->withSuccess(__('PSIP document saved successfully.'));
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect('psipupload/create/'.$activity->id)
            ->withInput();

        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PsipDoc  $post
     * @return \Illuminate\Http\Response
     */
    public function show(PsipName $psip)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PsipDoc  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(PsipDoc $post)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PsipDoc  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $activity_id= $request->update_activity_doc_id;
        $document = PsipDoc::find($request->update_doc_id);
        DB::beginTransaction();//BEGIN THE PROCESS
        try{
            $psipdoc = new PsipDoc;
            $psipdoc->activities_id = $activity_id;
            $psipdoc->doc_types_id = $document->doc_types_id;
            $psipdoc->description = 'Updated document - '.$document->description;
            $psipdoc->previous_doc_id = $document->id;
            //$psipdoc->save();
            $docname=trim(DocType::find($document->doc_types_id)->doc_type_name);
            /*upload and record file*/
            if (isset($request->file_upload)) {
                        sleep(2);
                    $file = $request->file_upload;
                    //$file->storeAs('public/documents', 'test');
                    if (!empty($file)) {
                        $activity_code = str_replace(' ', '_', $activity_id);
                        $doc_name_sanitized = str_replace(' ', '_', $docname);
                        $doc = $activity_code.'_'.$doc_name_sanitized.'_Scan_'.md5($file->getClientOriginalName()).'.'.$file->extension();
                       
                        $file->storeAs('public/documents', $doc);


                        $psipdoc->filepath = "documents/".$doc;
                        $psipdoc->file_type = $file->extension();
                        $psipdoc->save();
                        event(new DocumentUploadedEvent(\Auth::user(), DocType::find($document->doc_types_id)));//this is the mail notification
                    }
                }
            /*add old entry to archive*/
            $log_old_doc = new ReplacedPsipDoc;
            $log_old_doc->filepath = $document->filepath;
            $log_old_doc->file_type = $document->file_type;
            $log_old_doc->doc_types_id = $document->doc_types_id;
            $log_old_doc->activities_id = $document->activities_id;
            $log_old_doc->description = $document->description;
            $log_old_doc->previous_doc_id = $document->id;
            $log_old_doc->doc_group_id = $document->doc_group_id;
            $log_old_doc->created_by = $document->created_by;
            $log_old_doc->save();
            /*soft delete original entry*/
            $document->delete();

            $activity = Activity::find($activity_id);
            
        DB::commit();
            return redirect()->route('psip.show',['psip' => $activity->psipName->id])//replace this and remove comment when finished
            ->withSuccess(__('PSIP document saved successfully.'));
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            //Log::error($e->getMessage());//log error to log file
            return dd($e);//replace this and remove comment when finished

        }
    }

    public function addScreeningBrief(Request $request,PsipName $psip)
    {
        
    }

    public function assign()
    {
        $divisions = Division::all();
        $doctypes = DocType::all();
        return view('options.assign_doc', compact('divisions', 'doctypes'));
    }

    public function store_assign(Request $request)
    {
        //return dd($request->all());
        // Validate the request
        $request->validate([
            'division' => 'required',
            'psip' => 'required',
            'activity' => 'required',
            'doctype' => 'required',
        ]);

        // Create a new record in the DocTypeDivision model
        DocTypeDivision::create([
            'document_id' => $request->doctype,
            'division_id' => $request->division,
            'psip_id' => $request->psip,
            'activity_id' =>$request->activity,
        ]);

        // Redirect to the named route with the PSIP ID
        return redirect()->route('psip.show', ['psip' => $request->psip]);
    }

    public function store_assign_2(Request $request)
    {
        // Validate the request
        $request->validate([
            'division' => 'required',
            'activity' => 'required',
            'doctype' => 'required',
        ]);

        // Create a new record in the DocTypeDivision model
        DocTypeDivision::create([
            'document_id' => $request->doctype,
            'division_id' => $request->division,
            'psip_id' => $request->psip,
            'activity_id' =>$request->activity,
        ]);

        // Redirect to the named route with the PSIP ID
        return redirect()->route('psip.show', ['psip' => $request->psip]);
    }

    public function getPsips(Division $division)
    {
        $psips = $division->psipNames; // Assuming a one-to-many relationship
        return response()->json($psips);
    }

    public function getActivities(PsipName $psip)
    {
        $activities = $psip->activities; // Assuming a one-to-many relationship
        return response()->json($activities);
    }

    public function searchDocTypeDivision(Request $request)
    {
        $activity_id = $request->input('activity_id');
        $results = DocType::all();

        //return $results;
        if ($results->isEmpty()) {
            return response()->json(['status' => 'not_found']);
        }

        $output = [];
        foreach ($results as $result) {
            $search = PsipDoc::where('doc_types_id','=',$result->id)->where('activities_id','=',$activity_id)->first();
            $output[] = [    
                       
                'doc_type_name' => $result->doc_type_name,
                'uploaded'=> is_null($search)?'No':'Yes'
            ];
        }

        return response()->json(['status' => 'found', 'data' => $output]);
    }

    

}
