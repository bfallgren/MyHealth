<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medicine;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Auth;

class MedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $currentuser = Auth::user()->name;
        
      $data = DB::table('medicines')
      ->select('medicines.*')
      ->where('patient','=',$currentuser)
      ->orderBy('name', 'asc')
      ->get();
    
      if(request()->ajax()) {
        return datatables()->of($data)
       
        ->addColumn('action', function ($rows) {
          $button = '<div class="btn-group btn-group-xs">';
          $button .= '<a href="/meds/' . $rows->id . '/edit" title="Edit" ><i class="fa fa-edit" style="font-size:24px"></i></a>';
          $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton"><i class="fas fa-trash-alt" style="color:red"></i></button>';
          $button .= '</div>';
          return $button;
      })
      ->rawColumns(['action'])
      ->make(true);


    }

        return view('medicine.index'); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
             
        $patients = DB::table('patients')
        ->orderby('name','asc')
        ->pluck("name","id");
        return view('medicine.create',compact('patients'));
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
        'patient' => 'required',
        'name' => 'required',
        'dosage' => 'required',
        'dailyFreq' => 'required|numeric',
        ]);
      $newRec = new Medicine();
        $newRec->patient = $request->get('patient');
        $newRec->name = $request->get('name');
        $newRec->dosage = $request->get('dosage');
        $newRec->dailyFreq = $request->get('dailyFreq');
        $newRec->status = $request->get('status');
        $newRec->sideAffects = $request->get('sideAffects');
        $newRec->notes = $request->get('notes');

        $newRec->save();
 
        return redirect('meds')->with('success','Drug has been added');
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
        $patients = DB::table('patients')
        ->orderby('name','asc')
        ->pluck("name","id");
        $med = Medicine::find($id);
        
        return view('medicine.edit',compact('med','id','patients'));
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
        'patient' => 'required',
        'name' => 'required',
        'dosage' => 'required',
        'dailyFreq' => 'required|numeric',
        ]);
      $med= Medicine::find($id);
        
        $med->name = $request->get('name');
        $med->patient = $request->get('patient');
        $med->dosage = $request->get('dosage');
        $med->dailyFreq = $request->get('dailyFreq');
        $med->status = $request->get('status');
        $med->sideAffects = $request->get('sideAffects');
        $med->notes = $request->get('notes');       
        $med->save();
        return redirect('meds');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       DB::table("medicines")->delete($id);
        return response()->json(['success'=>"Drug Deleted successfully.", 'tr'=>'tr_'.$id]);
    }
}

