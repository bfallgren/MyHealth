<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lab;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class LabController extends Controller
{
    public function index(Request $request)
    {
     
    $items = $request->items ?? 10;      
    /* get the pagination number or a default */
     $data = DB::table('labs')->orderBy('testDate', 'desc')->orderBy('component', 'asc')->paginate($items)->onEachSide(1);
     return view('newlab.index', compact('data','items'));
    }

    Public function fetchData(Request $request)
    {
    
     if($request->ajax())
     {
      
      $sort_by = $request->get('sortby');
      $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $items = $request->get('items');
      $data = DB::table('labs')
                    ->where('patientName', 'like', '%'.$query.'%')
                    ->orWhere('component', 'like', '%'.$query.'%')
                    ->orWhere('testDate', 'like', '%'.$query.'%')
                    ->orderBy($sort_by, $sort_type)
                    ->paginate($items);
      return view('newlab.index_data', compact('data'))->render();
     
     }
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