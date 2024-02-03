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
use App\Models\FinancialYear;//there is a middleware updatefinancialyear that automatically updates the year record in the database on september 30th
use DB;

class PsipActivitiesController extends Controller
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
    public function create(PsipName $psip)
    {

        return view('psipupload.create',[
            'psip' => $psip, 'folder_types' => Activity::all(),'doc_types' => DocType::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Activity $psip)
    {
        DB::beginTransaction();//BEGIN THE PROCESS
        try{
            $psipdoc = new PsipDoc;
            $psipdoc->activities_id = $psip->id;
            $psipdoc->doc_types_id = $request->doc_type;
            $psipdoc->proj_folders_id = $request->folder_type;
            $psipdoc->description = $request->description;
            $psipdoc->save();
        
        DB::commit();
            return redirect()->route('psip.show',$psip->id)
            ->withSuccess(__('PSIP document saved successfully.'));
        }
        catch (Exception $e) {
                DB::rollBack();
                return redirect('/planning_add')
                ->withInput()
                ->withErrors($validator);

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
        return view('posts.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PsipDoc  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PsipDoc $post)
    {
        $post->update($request->only('title', 'description', 'body'));

        return redirect()->route('posts.index')
            ->withSuccess(__('Post updated successfully.'));
    }
}
