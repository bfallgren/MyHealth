<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\beWell;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class HealthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $items = $request->items ?? 10;      // get the pagination number or a default
        /*$appt = beWell::get()->sortby('patientName'); */ 
        $appt = beWell::filter($request)->orderBy('apptDate','desc')->paginate($items); 

        return view('bewell.index',compact('appt','items')); 
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
        return view('bewell.create',compact('patients','doctors','specialty'));
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
         'vitalsWeight' => 'numeric',
        ]);
        $newRec = new beWell();
        $newRec->patientName = $request->get('patientName');
        $newRec->apptDate = $request->get('apptDate');
        $newRec->doctorName = $request->get('doctorName');
        $newRec->doctorSpecialty = $request->get('drSpec');
        $newRec->fee = $request->get('fee');
        $newRec->reason = $request->get('reason');
        $newRec->diagnosis = $request->get('diagnosis');
        $newRec->vitalsWeight = $request->get('vitalsWeight');
        $newRec->vitalsBP = $request->get('vitalsBP');
        $newRec->save();
 
        return redirect('myHealth')->with('success','Appt has been added');
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
        $appt = beWell::find($id);
        $patients = DB::table('patients')
        ->orderby('name','asc')
        ->pluck("name","id");
        $doctors = DB::table('doctors')
        ->orderby('name','asc')
        ->pluck("name","id");
        $specialty = DB::table('doctors')
        ->orderby('specialty','asc')
        ->pluck("specialty","id");
        return view('bewell.edit',compact('appt','id','patients','doctors','specialty'));
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
        'vitalsWeight' => 'numeric',
        ]);
        $appt= beWell::find($id);
        $appt->patientName = $request->get('patientName');
        $appt->apptDate = $request->get('apptDate');
        $appt->doctorName = $request->get('doctorName');
        $appt->doctorSpecialty = $request->get('drSpec');
        $appt->fee = $request->get('fee');
        $appt->reason = $request->get('reason');
        $appt->diagnosis = $request->get('diagnosis');
        $appt->vitalsWeight = $request->get('vitalsWeight');
        $appt->vitalsBP = $request->get('vitalsBP');
        $appt->save();
        return redirect('myHealth');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$appt = Blog::find($id);
        //dd($id);
        //$appt->delete($id);
        //return redirect('blogs')->with('success','Blog Has Been Deleted');
       
        DB::table("be_wells")->delete($id);
        return response()->json(['success'=>"Appt Deleted successfully.", 'tr'=>'tr_'.$id]);

    }

    public function getSpecs($id)
    {
        $specs = DB::table("doctors")->where("name",$id)->pluck("specialty","id");
        
        return(json_encode($specs));
    }
}
