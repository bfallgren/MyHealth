<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Surgery;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class SurgeryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $items = $request->items ?? 10;      // get the pagination number or a default
      
        $oper = Surgery::filter($request)->orderBy('apptDate','desc')->paginate($items);  

        return view('surgerys.index',compact('oper','items')); 
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
        return view('surgerys.create',compact('patients','doctors','specialty'));
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
]);

        $newRec = new Surgery();
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
 
        return redirect('Surgery')->with('success','Surgery has been added');
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
        $oper = Surgery::find($id);
        $patients = DB::table('patients')
        ->orderby('name','asc')
        ->pluck("name","id");
        $doctors = DB::table('doctors')
        ->orderby('name','asc')
        ->pluck("name","id");
        $specialty = DB::table('doctors')
        ->orderby('specialty','asc')
        ->pluck("specialty","id");
        return view('surgerys.edit',compact('oper','id','patients','doctors','specialty'));
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
]);
        $oper= Surgery::find($id);
        $oper->patientName = $request->get('patientName');
        $oper->apptDate = $request->get('apptDate');
        $oper->doctorName = $request->get('doctorName');
        $oper->doctorSpecialty = $request->get('drSpec');
        $oper->fee = $request->get('fee');
        $oper->reason = $request->get('reason');
        $oper->diagnosis = $request->get('diagnosis');
        $oper->vitalsWeight = $request->get('vitalsWeight');
        $oper->vitalsBP = $request->get('vitalsBP');
        $oper->save();
        return redirect('Surgery');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$oper = Blog::find($id);
        //dd($id);
        //$oper->delete($id);
        //return redirect('blogs')->with('success','Blog Has Been Deleted');
       
        DB::table("surgeries")->delete($id);
        return response()->json(['success'=>"Surgery/Procedure Deleted successfully.", 'tr'=>'tr_'.$id]);

    }

    public function getSpecs($id)
    {
        $specs = DB::table("doctors")->where("name",$id)->pluck("specialty","id");
        
        return(json_encode($specs));
    }
}
