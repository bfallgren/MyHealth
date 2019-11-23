<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $member = Patient::get(); 
        $member = Patient::orderBy('name')->paginate(5);

        return view('patients.index',compact('member')); 
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
        $doctors = DB::table('doctors')
        ->orderby('name','asc')
        ->pluck("name","id");
        
        return view('patients.create',compact('doctors'));
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
        'primaryDoctor' => 'required',
        ]);
      $newRec = new Patient();
        $newRec->name = $request->get('name');
        $newRec->primaryDoctor = $request->get('primaryDoctor');
        $newRec->save();
 
        return redirect('Patient')->with('success','Member has been added');
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
        $member = Patient::find($id);
        $doctors = DB::table('doctors')
        ->orderby('name','asc')
        ->pluck("name","id");
        return view('patients.edit',compact('member','id','doctors'));
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
        'primaryDoctor' => 'required',
        ]);
      $member= Patient::find($id);
        $member->name = $request->get('name');
        $member->primaryDoctor = $request->get('primaryDoctor');        
        $member->save();
        return redirect('Patient');
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
        return response()->json(['success'=>"member Deleted successfully.", 'tr'=>'tr_'.$id]);
    }
}
