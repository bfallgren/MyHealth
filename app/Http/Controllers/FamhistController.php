<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Famhist;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
Use Auth;
class FamhistController extends Controller
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
        $data = DB::table('famhists')
            ->where('patientID','=',$currentuser)
            ->get();
          if(request()->ajax()) {
            return datatables()->of($data)  
            ->addColumn('action', function ($rows) {
              $button = '<div class="btn-group btn-group-xs">';
              $button .= '<a href="/fam/' . $rows->id . '/edit" title="Edit" ><i class="fa fa-edit" style="font-size:24px"></i></a>';
              $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton"><i class="fas fa-trash-alt" style="color:red"></i></button>';
              $button .= '</div>';
              return $button;
          })
          ->rawColumns(['action'])
          ->make(true);


        }

            return view('famhist.index'); 
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
          return view('famhist.create');
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
        'familyMember' => 'required',
        'relation' => 'required',
         ]);
      $newRec = new Famhist();
        $currentuserid = Auth::user()->id;
        $newRec->patientID = $currentuserid;
        $newRec->familyMember = $request->get('familyMember');
        $newRec->relation = $request->get('relation');
        $newRec->symptoms = $request->get('symptoms');
        $newRec->comments = $request->get('comments');
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
        if(Auth::check()) { 
          $fhist = Famhist::find($id);
          return view('famhist.edit',compact('id','fhist'));
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
        'familyMember' => 'required',
        'relation' => 'required',
        ]);
        $fhist= Famhist::find($id);
        $currentuserid = Auth::user()->id;
        $fhist->patientID = $currentuserid;
        $fhist->familyMember = $request->get('familyMember');
        $fhist->relation = $request->get('relation');
        $fhist->symptoms = $request->get('symptoms');
        $fhist->comments = $request->get('comments');
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
