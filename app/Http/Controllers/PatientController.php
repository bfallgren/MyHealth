<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
Use Auth;

class PatientController extends Controller
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
        $data = DB::table('patients')
            ->where('id','=',$currentuser)
            ->get();
        if(request()->ajax()) {
          return datatables()->of($data)    
          ->addColumn('action', function ($rows) {
              $button = '<div class="btn-group btn-group-xs">';
              $button .= '<a href="/patient/' . $rows->id . '/edit" title="Edit" ><i class="fa fa-edit" style="font-size:24px"></i></a>';
              $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton"><i class="fas fa-trash-alt" style="color:red"></i></button>';
              $button .= '</div>';
              return $button;
          })
          ->rawColumns(['action'])
          ->make(true);
        }
            return view('patient.index'); 
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
      /*
            ADDED FOR DYNAMIC DROPDOWN
    */
      if(Auth::check()) { 
        $currentuserid = Auth::user()->id;   
        if (Patient::where('id', $currentuserid)->exists()){
          return redirect('patient')->with('success','Patient already exists');
        }
            
        $doctors = DB::table('doctors')
            ->where('patientID','=', $currentuserid)
            ->orderby('name','asc')
            ->pluck("name","id");
            
            return view('patient.create',compact('doctors'));
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
       'primaryDoctor' => 'required',
        ]);
      $newRec = new Patient();
        $currentuserid = Auth::user()->id;
        $newRec->id = $currentuserid;
        $newRec->fullName = $request->get('fullName');
        $newRec->birthDate = $request->get('birthDate');
        $newRec->insurance = $request->get('insurance');
        $newRec->memberID = $request->get('memberID');
        $newRec->primaryDoctor = $request->get('primaryDoctor');
        $newRec->save();
 
        return redirect('patient')->with('success','Member has been added');
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
        $member = Patient::find($id);
        $currentuserid = Auth::user()->id;    
        $doctors = DB::table('doctors')
        ->where('patientID','=',$currentuserid)
        ->orderby('id','asc')
        ->pluck("name","id");
        
        return view('patient.edit',compact('member','id','doctors'));
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
       'primaryDoctor' => 'required',
        ]);
      $member= Patient::find($id);
        $currentuserid = Auth::user()->id;
        $member->id = $currentuserid;
        $member->fullName = $request->get('fullName');
        $member->birthDate = $request->get('birthDate');
        $member->insurance = $request->get('insurance');
        $member->memberID = $request->get('memberID');
        $member->primaryDoctor = $request->get('primaryDoctor');        
        $member->save();
        return redirect('patient');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       DB::table("patients")->delete($id);
       return redirect('patient')->with('success','Member has been deleted');
    }
}
