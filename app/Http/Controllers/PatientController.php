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


    public function index(Request $request)
    {
      if(request()->ajax()) {
        return datatables()->of(Patient::select('*'))
       
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
        
        return view('patient.create',compact('doctors'));
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
        $member = Patient::find($id);
        $doctors = DB::table('doctors')
        ->orderby('name','asc')
        ->pluck("name","id");
        return view('patient.edit',compact('member','id','doctors'));
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
       // return response()->json(['success'=>"member Deleted successfully.", 'tr'=>'tr_'.$id]);
       return redirect('patient')->with('success','Member has been deleted');
    }
}
