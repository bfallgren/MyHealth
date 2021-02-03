<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $items = $request->items ?? 10;      // get the pagination number or a default
      
        $img = Image::filter($request)->orderBy('apptDate','desc')->paginate($items)->onEachSide(1);  

        return view('imaging.index',compact('img','items')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     /*
            ADDED FOR DYNAMIC DROPDOWN
    */
        $patients = DB::table('patients')
        ->orderby('name','asc')
        ->pluck("name","id");
        $doctors = DB::table('doctors')
        ->orderby('name','asc')
        ->pluck("name","id");
        $specialty = DB::table('doctors')
        ->orderby('specialty','asc')
        ->pluck("specialty","id");
        return view('imaging.create',compact('patients','doctors','specialty'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
        'patientName' => 'required',
        'apptDate' => 'required',
        'doctorName' => 'required',
        'doctorSpecialty' => 'required',
        'fee' => 'numeric',
]);

        $newRec = new Image();
        $newRec->patientName = $request->get('patientName');
        $newRec->apptDate = $request->get('apptDate');
        $newRec->doctorName = $request->get('doctorName');
        $newRec->doctorSpecialty = $request->get('drSpec');
        $newRec->fee = $request->get('fee');
        $newRec->reason = $request->get('reason');
        $newRec->diagnosis = $request->get('diagnosis');
        $newRec->save();
 
        return redirect('imaging')->with('success','Imaging has been added');
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
        $img = Image::find($id);
        $patients = DB::table('patients')
        ->orderby('name','asc')
        ->pluck("name","id");
        $doctors = DB::table('doctors')
        ->orderby('name','asc')
        ->pluck("name","id");
        $specialty = DB::table('doctors')
        ->orderby('specialty','asc')
        ->pluck("specialty","id");
        return view('imaging.edit',compact('img','id','patients','doctors','specialty'));
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
         $request->validate([
        'patientName' => 'required',
        'apptDate' => 'required',
        'doctorName' => 'required',
        'doctorSpecialty' => 'required',
        'fee' => 'numeric',
]);
        $img= Image::find($id);
        $img->patientName = $request->get('patientName');
        $img->apptDate = $request->get('apptDate');
        $img->doctorName = $request->get('doctorName');
        $img->doctorSpecialty = $request->get('drSpec');
        $img->fee = $request->get('fee');
        $img->reason = $request->get('reason');
        $img->diagnosis = $request->get('diagnosis');
        $img->save();
        return redirect('imaging');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$img = Blog::find($id);
        //dd($id);
        //$img->delete($id);
        //return redirect('blogs')->with('success','Blog Has Been Deleted');
       
        DB::table("images")->delete($id);
        return response()->json(['success'=>"Imaging Deleted successfully.", 'tr'=>'tr_'.$id]);

    }

    public function getSpecs($id)
    {
        $specs = DB::table("doctors")->where("name",$id)->pluck("specialty","id");
        
        return(json_encode($specs));
    }
}
