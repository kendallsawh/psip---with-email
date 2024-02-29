<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ActivityPhoto;
use App\Models\Activity;
use DB;
use Illuminate\Support\Facades\Storage;


class ActivityPhotoController extends Controller
{


    /**
     * Listing Of images gallery
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $data = array(
            'activity' => $activity = Activity::find($id),
            'images' => $images = ActivityPhoto::where('activity_id',$activity->id)->get(),
        );
        return view('psipactivity.image-gallery',$data);
    }


    /**
     * Upload image function
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request,$id)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ]);


        $input['file_path'] = time().'.'.$request->image->getClientOriginalExtension();//add activity id to file name
        //$request->image->move(public_path('images'), $input['file_path']);
        $request->image->storeAs('images', $input['file_path'], 'public');


        $input['title'] = $request->title;
        $input['activity_id'] = $id;
        $input['type'] = $request->image->getClientOriginalExtension();
        ActivityPhoto::create($input);


        return back()
            ->with('success','Image Uploaded successfully.');
    }


    /**
     * Remove Image function
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ActivityPhoto::find($id)->delete();
        return back()
            ->with('success','Image removed successfully.');    
    }
}