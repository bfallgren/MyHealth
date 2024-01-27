<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\beWell;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Auth;

class HealthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::check()) { 
                $currentuser = Auth::user()->name;
                $currentuserid = Auth::user()->id;
               
                $data = DB::table('be_wells')
                ->join('patients','patients.id','be_wells.patientID')
                ->select('be_wells.*','patients.fullName','patients.birthDate')
                ->where('patientID','=',$currentuserid)
                ->orderBy('apptDate', 'desc')
                ->get();
            
                if(request()->ajax()) {
                    return datatables()->of($data)
            
                    ->addColumn('action', function ($rows) {
                        $button = '<div class="btn-group btn-group-xs">';
                        $button .= '<a href="/myHealth/' . $rows->id .  '/edit" title="Edit" ><i class="fa fa-edit" style="font-size:24px"></i></a>';
                        $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton"><i class="fas fa-trash-alt" style="color:red"></i></button>';
                        $button .= '</div>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

                }
                return view('bewell.index');
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
     /*
            ADDED FOR DYNAMIC DROPDOWN
    */
            $currentuser = Auth::user()->id;
            $doctors = DB::table('doctors')
            ->where('patientID','=',$currentuser)
            ->orderby('name','asc')
            ->pluck("name","id");
            $specialty = DB::table('doctors')
            ->orderby('specialty','asc')
            ->pluck("specialty","id");
            return view('bewell.create',compact('doctors','specialty'));
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
        'apptDate' => 'required',
        'doctorName' => 'required',
        'doctorSpecialty' => 'required',
        'fee' => 'numeric',
         'vitalsWeight' => 'numeric',
        ]);
        $newRec = new beWell();
        $currentuser = Auth::user()->id;
        $newRec->patientID = $currentuser;
        $newRec->apptDate = $request->get('apptDate');
        $newRec->doctorName = $request->get('doctorName');
        $newRec->doctorSpecialty = $request->get('drSpec');
        $newRec->fee = $request->get('fee');
        $newRec->reason = $request->get('reason');
        $newRec->diagnosis = $request->get('diagnosis');
        $newRec->vitalsWeight = $request->get('vitalsWeight');
        $newRec->vitalsBP = $request->get('vitalsBP');
        $newRec->save();
 
        return redirect('myHealth')->with('success','Appt has been added');
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
            $appt = beWell::find($id);
            $patients = DB::table('patients')
            ->orderby('name','asc')
            ->pluck("name","id");
            $currentuser = Auth::user()->id;
            $doctors = DB::table('doctors')
            ->where('patientID','=',$currentuser)
            ->orderby('name','asc')
            ->pluck("name","id");
            $specialty = DB::table('doctors')
            ->orderby('specialty','asc')
            ->pluck("specialty","id");
            return view('bewell.edit',compact('appt','id','patients','doctors','specialty'));
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
        'apptDate' => 'required',
        'doctorName' => 'required',
        'doctorSpecialty' => 'required',
        'fee' => 'numeric',
        'vitalsWeight' => 'numeric',
        ]);
        $appt= beWell::find($id);
        $currentuser = Auth::user()->id;
        $appt->patientID = $currentuser;
        $appt->apptDate = $request->get('apptDate');
        $appt->doctorName = $request->get('doctorName');
        $appt->doctorSpecialty = $request->get('drSpec');
        $appt->fee = $request->get('fee');
        $appt->reason = $request->get('reason');
        $appt->diagnosis = $request->get('diagnosis');
        $appt->vitalsWeight = $request->get('vitalsWeight');
        $appt->vitalsBP = $request->get('vitalsBP');
        $appt->save();
        return redirect('myHealth');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("be_wells")->delete($id);
        //return response()->json(['success'=>"Appt Deleted successfully.", 'tr'=>'tr_'.$id]);
        return redirect('myHealth')->with('success','Wellness Record has been deleted');
    }

    public function getSpecs($id)
    {
        $specs = DB::table("doctors")->where("name",$id)->pluck("specialty","id");
        
        return(json_encode($specs));
    }
}
