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
        if(Auth::check()) { 
            $currentuser = Auth::user()->id;
            
            $data = DB::table('vaccines')
            ->join('patients','patients.id','vaccines.patientID')
            ->select('vaccines.*','patients.fullName','patients.birthDate')
            ->where('patientID','=',$currentuser)
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
        else {
            return redirect()->to('/');
        }
    }

    public function create()
    {
        if(Auth::check()) {   
     /*
            ADDED FOR DYNAMIC DROPDOWN
    */
     /*   $patients = DB::table('patients')
        ->orderby('name','asc')
        ->pluck("name","id"); */
            return view('vaccine.create');
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
        'vDate' => 'required',
        'vaccine' => 'required',
        ]);

        $newRec = new Vaccine();
        $currentuser = Auth::user()->id;
        $newRec->patientID = $currentuser;
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
        if(Auth::check()) {  
            $shot = Vaccine::find($id);
        /* $patients = DB::table('patients')
            ->orderby('name','asc')
            ->pluck("name","id"); */
            return view('vaccine.edit',compact('shot','id'));
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
        'vDate' => 'required',
        'vaccine' => 'required',
        ]);
        $shot = Vaccine::find($id);
        $currentuser = Auth::user()->id;
        $shot->patientID = $currentuser;
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
        return redirect('vaccine')->with('success','Immunization Record has been deleted');

    }  
}
