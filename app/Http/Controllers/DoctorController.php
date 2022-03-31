<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Datatables;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
         
    public function index(Request $request)
    {
      if(request()->ajax()) {
        return datatables()->of(Doctor::select('*'))
       
        ->addColumn('action', function ($rows) {
          $button = '<div class="btn-group btn-group-xs">';
          $button .= '<a href="/doctor/' . $rows->id . '/edit" title="Edit" ><i class="fa fa-edit" style="font-size:24px"></i></a>';
          $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton"><i class="fas fa-trash-alt" style="color:red"></i></button>';
          $button .= '</div>';
          return $button;
      })
      ->rawColumns(['action'])
      ->make(true);


    }

        return view('doctor.index'); 
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     return view('doctor.create');
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
        'specialty' => 'required',
        ]);
      $newRec = new Doctor();
        $newRec->name = $request->get('name');
        $newRec->specialty = $request->get('specialty');
        $newRec->save();
 
        return redirect('doctor')->with('success','Doctor has been added');
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
        $doc = Doctor::find($id);
        return view('doctor.edit',compact('doc','id'));
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
        'specialty' => 'required',
        ]);
      $doc= Doctor::find($id);
        $doc->name = $request->get('name');
        $doc->specialty = $request->get('specialty');        
        $doc->save();
        return redirect('doctor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       DB::table("doctors")->delete($id);
        //return response()->json(['success'=>"Doctor Deleted successfully.", 'tr'=>'tr_'.$id]);
        return redirect('doctor')->with('success','Doctor Record has been deleted');
    }
}
