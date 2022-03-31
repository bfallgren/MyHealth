<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vaccine;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Auth;

class VaccineController extends Controller
{
    public function index(Request $request)
    {
        $currentuser = Auth::user()->name;
        
        $data = DB::table('vaccines')
        ->select('vaccines.*')
        ->where('patientName','=',$currentuser)
        ->orderBy('vDate', 'desc')
        ->get();
      
        if(request()->ajax()) {
            return datatables()->of($data)
       
        ->addColumn('clickme', function ($rows) {
        
        })

        ->addColumn('action', function ($rows) {
          $button = '<div class="btn-group btn-group-xs">';
          $button .= '<a href="/vaccine/' . $rows->id . '/edit" title="Edit" ><i class="fa fa-edit" style="font-size:24px"></i></a>';
          $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton"><i class="fas fa-trash-alt" style="color:red"></i></button>';
          $button .= '</div>';
          return $button;
      })
      ->rawColumns(['action'])
      ->make(true);


    }

        return view('vaccine.index'); 
    }

    public function create()
    {
     /*
            ADDED FOR DYNAMIC DROPDOWN
    */
        $patients = DB::table('patients')
        ->orderby('name','asc')
        ->pluck("name","id");
        return view('vaccine.create',compact('patients'));
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
        'vDate' => 'required',
        'vaccine' => 'required',
        ]);

        $newRec = new Vaccine();
        $newRec->patientName = $request->get('patientName');
        $newRec->vDate = $request->get('vDate');
        $newRec->vaccine = $request->get('vaccine');
        $newRec->comments = $request->get('comments');
        $newRec->save();
 
        return redirect('vaccine')->with('success','Immunization Record has been added');
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
        $shot = Vaccine::find($id);
        $patients = DB::table('patients')
        ->orderby('name','asc')
        ->pluck("name","id");
        return view('vaccine.edit',compact('shot','id','patients'));
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
        'vDate' => 'required',
        'vaccine' => 'required',
        ]);
        $shot = Vaccine::find($id);
        $shot->patientName = $request->get('patientName');
        $shot->vDate = $request->get('vDate');
        $shot->vaccine = $request->get('vaccine');
        $shot->comments = $request->get('comments');
        $shot->save();
        return redirect('vaccine');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
               
        DB::table("vaccines")->delete($id);
       // return response()->json(['success'=>"Immunization Record Deleted successfully.", 'tr'=>'tr_'.$id]);
       return redirect('vaccine')->with('success','Immunization Record has been deleted');

    }  
}
