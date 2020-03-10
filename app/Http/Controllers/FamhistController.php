<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Famhist;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class FamhistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // $member = Patient::get(); 
        $items = $request->items ?? 10;      // get the pagination number or a default
        $fhist = Famhist::orderBy('patient')->paginate($items);

        return view('famhist.index',compact('fhist','items')); 
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
        return view('famhist.create',compact('patients'));
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
        'familyMember' => 'required',
        'relation' => 'required',
         ]);
      $newRec = new Famhist();
        $newRec->patient = $request->get('patient');
        $newRec->familyMember = $request->get('familyMember');
        $newRec->relation = $request->get('relation');
        $newRec->symptoms = $request->get('symptoms');
        $newRec->save();
 
        return redirect('fam')->with('success','Family History has been added');
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
        $fhist = Famhist::find($id);
        
        return view('famhist.edit',compact('fhist','id','patients'));
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
        'familyMember' => 'required',
        'relation' => 'required',
        ]);
      $fhist= Famhist::find($id);
        
        $fhist->patient = $request->get('patient');
        $fhist->familyMember = $request->get('familyMember');
        $fhist->relation = $request->get('relation');
        $fhist->symptoms = $request->get('symptoms');
        $fhist->save();
        return redirect('fam');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       DB::table("famhists")->delete($id);
        return response()->json(['success'=>"Family History Deleted successfully.", 'tr'=>'tr_'.$id]);
    }
}
