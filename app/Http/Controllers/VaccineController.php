<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vaccine;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class VaccineController extends Controller
{
   public function index(Request $request)
    {
     
    $items = $request->items ?? 10;      
    /* get the pagination number or a default */
     $shot = DB::table('vaccines')->orderBy('vDate', 'desc')->paginate($items)->onEachSide(1);
     return view('vaccine.index', compact('shot','items'));
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
      $shot = DB::table('vaccines')
                    ->where('patientName', 'like', '%'.$query.'%')
                    ->orWhere('vaccine', 'like', '%'.$query.'%')
                    ->orWhere('vDate', 'like', '%'.$query.'%')
                    ->orderBy($sort_by, $sort_type)
                    ->paginate($items);
      return view('vaccine.index_data', compact('shot'))->render();
     
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
