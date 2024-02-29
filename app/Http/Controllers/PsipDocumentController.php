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
use App\Models\PsipScreeningBrief;
use App\Models\PsipAchievementReport;
use App\Models\PsipPsNote;
use DB;
use Illuminate\Support\Facades\Log;
use App\Events\DocumentUploadedEvent;
use Carbon\Carbon;
use App\Models\DocGroup;


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

    public function getGroupDocuments(Activity $activity)
    {
        //return ($activity->psipDocs);

        return view('options.group_documents',[
            'activity' => $activity, 
            'documents' => $activity->psipDocs, 
            'doc_groups' => DocGroup::orderBy('group_name','ASC')->get()
        ]);
        //return view('options.group_documents');
    }

    public function updateGroupDocuments(Request $request)
    {
        //$documentId = $request->input('documentId');
        $groupId = $request->input('groupId');

        $document = PsipDoc::find($request->input('documentId'));
        if ($document) {
            $document->update(['doc_group_id' => $groupId]);
             return response()->json(['success' => true, 'message' => 'Item moved successfully.']);
        } else {
             return response()->json(['error' => true, 'message' => 'Your attempt has failed successfully.']);
        }
        
        // Logic to update the item's group based on itemId and groupId
        // For example, updating the database record for the item

       
 
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
            $psipdoc->created_by = auth()->id();
            $psip = $activity->psipName->id;
            $psipdoc->save();
            $docname=trim(DocType::find($request->doc_type)->doc_type_name);
            




            if (isset($request->file_upload)) {
                        sleep(2);
                    $file = $request->file_upload;
                    if (!empty($file)) {
                        $activity_code = str_reppreg_replace('/[\/\s\\\\,.:;\'"!?]+/', '_', $activity->id);
                        $doc_name_sanitized = preg_replace('/[\/\s\\\\,.:;\'"!?]+/', '_', $docname);
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
                        $activity_code = preg_replace('/[\/\s\\\\,.:;\'"!?]+/', '_', $activity_id);
                        $doc_name_sanitized = preg_replace('/[\/\s\\\\,.:;\'"!?]+/', '_', $docname);
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
            $log_old_doc->previous_doc_id = $document->previous_doc_id;
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
        catch (Exception $e) {
            DB::rollBack();
            Log::error(dd($e));
            //Log::error($e->getMessage());//log error to log file
            return dd($e);//replace this and remove comment when finished

        }
    }

    public function addScreeningBrief(Request $request,PsipName $psip)
    {
        $document = DocType::find(6);//screening brief
        DB::beginTransaction();//BEGIN THE PROCESS
        try {
            $screeningbrief = new PsipScreeningBrief;
            $screeningbrief->psip_names_id = $psip->id;
            /*$screeningbrief->file_name = ;
            $screeningbrief->details = ;*/
            //$screeningbrief->previous_note_id = ;
            
            $docname=trim($document->doc_type_name);
            /*upload and record file*/
            if (isset($request->file_upload)) {
                        sleep(2);
                    $file = $request->file_upload;
                    
                    if (!empty($file)) {
                        $psipid_code = str_replace(' ', '_', $psip->id).'_'.str_replace(' ', '_', $psip->code);
                        $doc_name_sanitized = preg_replace('/[\/\s\\\\,.:;\'"!?]+/', '_', $docname);
                        $doc = $psipid_code.'_'.$doc_name_sanitized.'_'.md5($file->getClientOriginalName()).'.'.$file->extension();
                       
                        $file->storeAs('public/documents/screeningbrief', $doc);


                        $screeningbrief->filepath = "documents/screeningbrief/".$doc;
                        $screeningbrief->file_type = $file->extension();
                        $screeningbrief->save();
                        event(new DocumentUploadedEvent(\Auth::user(), $document));//this is the mail notification
                    }
                }
            DB::commit();
            return redirect()->route('psip.show',['psip' => $psip->id])//replace this and remove comment when finished
            ->withSuccess(__('PSIP document saved successfully.'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error(dd($e));
            return dd($e);//replace this and remove comment when finished
        }
    }

    public function addPSNote(Request $request,PsipName $psip)
    {
        $document = DocType::find(2);// psnote
        DB::beginTransaction();//BEGIN THE PROCESS
        try {
            $psnote = new PsipPsNote;
            $psnote->psip_names_id = $psip->id;
            /*$psnote->file_name = ;
            $psnote->details = ;*/
            //$psnote->previous_note_id = ;
            
            $docname=trim($document->doc_type_name);
            /*upload and record file*/
            if (isset($request->file_upload)) {
                        sleep(2);
                    $file = $request->file_upload;
                    
                    if (!empty($file)) {
                        $psipid_code = str_replace(' ', '_', $psip->id).'_'.str_replace(' ', '_', $psip->code);
                        $doc_name_sanitized = preg_replace('/[\/\s\\\\,.:;\'"!?]+/', '_', $docname);
                        $doc = $psipid_code.'_'.$doc_name_sanitized.'_'.md5($file->getClientOriginalName()).'.'.$file->extension();
                       
                        $file->storeAs('public/documents/psnote', $doc);


                        $psnote->filepath = "documents/psnote/".$doc;
                        $psnote->file_type = $file->extension();
                        $psnote->save();
                        event(new DocumentUploadedEvent(\Auth::user(), $document));//this is the mail notification
                    }
                }
            DB::commit();
            return redirect()->route('psip.show',['psip' => $psip->id])//replace this and remove comment when finished
            ->withSuccess(__('PSIP document saved successfully.'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error(dd($e));
            return dd($e);//replace this and remove comment when finished
        }
    }

    public function addAchievementReport(Request $request,PsipName $psip)
    {
        $document = DocType::find(35);//screening brief
        DB::beginTransaction();//BEGIN THE PROCESS
        try {
            $achievementReport = new PsipAchievementReport;
            $achievementReport->psip_names_id = $psip->id;
            $achievementReport->file_name = $request->title;
            $achievementReport->details = $request->description;
            $achievementReport->achievement_date = Carbon::parse($request->report_date)->format('Y-m-d');
            $achievementReport->created_by = \Auth::user()->id;
            //$screeningbrief->previous_note_id = ;
            
            $docname=trim($document->doc_type_name);
            /*upload and record file*/
            if (isset($request->file_upload)) {
                        sleep(2);
                    $file = $request->file_upload;
                    
                    if (!empty($file)) {
                        $psipid_code = str_replace(' ', '_', $psip->id).'_'.str_replace(' ', '_', $psip->code);
                        $doc_name_sanitized = preg_replace('/[\/\s\\\\,.:;\'"!?]+/', '_', $docname);
                        $doc = $psipid_code.'_'.$doc_name_sanitized.'_'.md5($file->getClientOriginalName()).'.'.$file->extension();
                       
                        $file->storeAs('public/documents/achievement_report', $doc);


                        $achievementReport->filepath = "documents/achievement_report/".$doc;
                        $achievementReport->file_type = $file->extension();
                        $achievementReport->save();
                        event(new DocumentUploadedEvent(\Auth::user(), $document));//this is the mail notification
                    }
                }
            DB::commit();
            return redirect()->route('psip.show',['psip' => $psip->id])//replace this and remove comment when finished
            ->withSuccess(__('PSIP document saved successfully.'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error(dd($e));
            return dd($e);//replace this and remove comment when finished
        }
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
