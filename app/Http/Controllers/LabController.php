<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lab;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Auth;

class LabController extends Controller
{
    public function index(Request $request)
    {

        $currentuser = Auth::user()->name;
     
       $data = DB::table('labs')
       ->select('labs.*')
       ->where('patientName','=',$currentuser)
       ->get();

      if(request()->ajax()) {
        return datatables()->of($data)
       
        ->addColumn('clickme', function ($rows) {
        
        })

        ->addColumn('action', function ($rows) {
          $button = '<div class="btn-group btn-group-xs">';
          $button .= '<a href="/lab/' . $rows->id . '/edit" title="Edit" ><i class="fa fa-edit" style="font-size:24px"></i></a>';
          $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton"><i class="fas fa-trash-alt" style="color:red"></i></button>';
          $button .= '</div>';
          return $button;
      })
      ->rawColumns(['action'])
      ->make(true);


    }

        return view('newlab.index'); 
    }

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
        return view('newlab.create',compact('patients','doctors'));
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
        'testDate' => 'required',
        'component' => 'required',
        'measuredValue' => 'required|numeric',
        ]);

        $newRec = new Lab();
        $newRec->patientName = $request->get('patientName');
        $newRec->testDate = $request->get('testDate');
        $newRec->component = $request->get('component');
        $newRec->measuredValue = $request->get('measuredValue');
        $newRec->goodRange = $request->get('goodRange');
        $newRec->comments = $request->get('comments');
        $newRec->save();
 
        return redirect('lab')->with('success','Lab Record has been added');
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
        $data = Lab::find($id);
        $patients = DB::table('patients')
        ->orderby('name','asc')
        ->pluck("name","id");
        $doctors = DB::table('doctors')
        ->orderby('name','asc')
        ->pluck("name","id");
        return view('newlab.edit',compact('data','id','patients','doctors'));
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
        'testDate' => 'required',
        'component' => 'required',
        'measuredValue' => 'required|numeric',
        ]);
        $data = Lab::find($id);
        $data->patientName = $request->get('patientName');
        $data->testDate = $request->get('testDate');
        $data->component = $request->get('component');
        $data->measuredValue = $request->get('measuredValue');
        $data->goodRange = $request->get('goodRange');
        $data->comments = $request->get('comments');
        $data->save();
        return redirect('lab');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("labs")->delete($id);
        //return response()->json(['success'=>"Lab Record Deleted successfully.", 'tr'=>'tr_'.$id]);
        return redirect('lab')->with('success','LabTest Record has been deleted');
    }    
}
?>