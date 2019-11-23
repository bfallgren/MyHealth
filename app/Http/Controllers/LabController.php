<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Labtest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = $request->items ?? 10;      // get the pagination number or a default
       
        $lab = Labtest::filter($request)->orderBy('testDate','desc')->paginate($items);  
        $lab->withPath('Labs');
        $lab->appends($request->all());

        return view('labs.index',compact('lab','items')); 
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
        return view('labs.create',compact('patients','doctors'));
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
        'measuredValue' => 'required',
        ]);

        $newRec = new Labtest();
        $newRec->patientName = $request->get('patientName');
        $newRec->testDate = $request->get('testDate');
        $newRec->component = $request->get('component');
        $newRec->measuredValue = $request->get('measuredValue');
        $newRec->goodRange = $request->get('goodRange');
        $newRec->comments = $request->get('comments');
        $newRec->save();
 
        return redirect('Labs')->with('success','Labtest has been added');
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
        $lab = Labtest::find($id);
        $patients = DB::table('patients')
        ->orderby('name','asc')
        ->pluck("name","id");
        $doctors = DB::table('doctors')
        ->orderby('name','asc')
        ->pluck("name","id");
        return view('labs.edit',compact('lab','id','patients','doctors'));
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
        ]);
        $lab = Labtest::find($id);
        $lab->patientName = $request->get('patientName');
        $lab->testDate = $request->get('testDate');
        $lab->component = $request->get('component');
        $lab->measuredValue = $request->get('measuredValue');
        $lab->goodRange = $request->get('goodRange');
        $lab->comments = $request->get('comments');
        $lab->save();
        return redirect('Labs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$lab = Blog::find($id);
        //dd($id);
        //$lab->delete($id);
        //return redirect('blogs')->with('success','Blog Has Been Deleted');
       
        DB::table("labtests")->delete($id);
        return response()->json(['success'=>"Labtest Deleted successfully.", 'tr'=>'tr_'.$id]);

    }

}
