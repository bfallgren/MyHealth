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
      if(Auth::check()) { 
          $currentuser = Auth::user()->id;
         
          $data = DB::table('medicines')
          ->join('patients','patients.id','medicines.patientID')
          ->select('medicines.*','patients.fullName','patients.birthDate')
          ->where('patientID','=',$currentuser)
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
      else {
        return redirect()->to('/');
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if(Auth::check()) {        
        return view('medicine.create');
      }
      else {
        return redirect()->to('/');
      }
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
        'name' => 'required',
        'dosage' => 'required',
        'dailyFreq' => 'required|numeric',
        ]);
        $newRec = new Medicine();
        $currentuserid = Auth::user()->id;
        $newRec->patientID = $currentuserid;
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
      if(Auth::check()) {  
        $med = Medicine::find($id);
        
        return view('medicine.edit',compact('med','id'));
      }
      else {
        return redirect()->to('/');
      }
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
        'name' => 'required',
        'dosage' => 'required',
        'dailyFreq' => 'required|numeric',
        ]);
      $med= Medicine::find($id);
        
        $med->name = $request->get('name');
        $currentuserid = Auth::user()->id;
        $med->patientID = $currentuserid;
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

