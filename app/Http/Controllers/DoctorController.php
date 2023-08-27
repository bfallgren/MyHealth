<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Datatables;
use Auth;

class DoctorController extends Controller
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
           
        $data = DB::table('doctors')
        ->where('patientID','=',$currentuser)
        ->orderBy('name', 'asc')
        ->get();
          if(request()->ajax()) {
            return datatables()->of($data)
          
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
      if(Auth::check()) { 
        return view('doctor.create');
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
        'name' => 'required',
        'specialty' => 'required',
        ]);
        $newRec = new Doctor();
        $newRec->name = $request->get('name');
        $currentuserid = Auth::user()->id;
        $newRec->patientID = $currentuserid;
        $newRec->specialty = $request->get('specialty');
        $newRec->location = $request->get('location');   
        $newRec->hospital = $request->get('hospital');   
        if($request->has('active')){
          $newRec->active = 1; 
        }else{
          $newRec->active = 0;
        }  
        $newRec->doctorRating = $request->get('doctorRating');   
        $newRec->staffRating = $request->get('staffRating');   
        $newRec->services = $request->get('services');      
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
       if(Auth::check()) {  
        $doc = Doctor::find($id);
        return view('doctor.edit',compact('doc','id'));
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
        'name' => 'required',
        'specialty' => 'required',
        ]);
        if(Auth::check()) { 
          $doc= Doctor::find($id);
          $doc->name = $request->get('name');
          $currentuserid = Auth::user()->id;
          $doc->patientID = $currentuserid;
          $doc->specialty = $request->get('specialty');    
          $doc->location = $request->get('location');   
          $doc->hospital = $request->get('hospital');  
          if($request->has('active')){
              $doc->active = 1; 
          }else{
              $doc->active = 0;
          } 
            
          $doc->doctorRating = $request->get('doctorRating');   
          $doc->staffRating = $request->get('staffRating');   
          $doc->services = $request->get('services');       
          $doc->save();
          return redirect('doctor');
        }
        else {
          return redirect()->to('/');
        }
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
        return redirect('doctor')->with('success','Doctor Record has been deleted');
    }
}
