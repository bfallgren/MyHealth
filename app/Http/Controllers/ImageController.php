<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Auth;

class ImageController extends Controller
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
           
            $data = DB::table('images')
            ->join('patients','patients.id','images.patientID')
            ->select('images.*','patients.fullName','patients.birthDate')
            ->where('patientID','=',$currentuser)
            ->orderBy('apptDate', 'desc')
            ->get();
        
            if(request()->ajax()) {
                return datatables()->of($data)
        
                ->addColumn('action', function ($rows) {
                    $button = '<div class="btn-group btn-group-xs">';
                    $button .= '<a href="/imaging/' . $rows->id . '/edit" title="Edit" ><i class="fa fa-edit" style="font-size:24px"></i></a>';
                    $button .= '<button type="button" title="Delete" name="deleteButton" id="' . $rows->id . '" class="deleteButton"><i class="fas fa-trash-alt" style="color:red"></i></button>';
                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
            }

            return view('imaging.index'); 
        }
        else 
        {
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
            return view('imaging.create',compact('doctors','specialty'));
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
]);

        $newRec = new Image();
        $currentuser = Auth::user()->id;
        $newRec->patientID = $currentuser;
        $newRec->apptDate = $request->get('apptDate');
        $newRec->doctorName = $request->get('doctorName');
        $newRec->doctorSpecialty = $request->get('drSpec');
        $newRec->fee = $request->get('fee');
        $newRec->reason = $request->get('reason');
        $newRec->diagnosis = $request->get('diagnosis');
        $newRec->save();
 
        return redirect('imaging')->with('success','Imaging has been added');
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
            $img = Image::find($id);
            $currentuser = Auth::user()->id;
            $doctors = DB::table('doctors')
            ->where('patientID','=',$currentuser)
            ->orderby('name','asc')
            ->pluck("name","id");
            $specialty = DB::table('doctors')
            ->orderby('specialty','asc')
            ->pluck("specialty","id");
            return view('imaging.edit',compact('img','id','doctors','specialty'));
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
]);
        $img= Image::find($id);
        $currentuser = Auth::user()->id;
        $img->patientID = $currentuser;
        $img->apptDate = $request->get('apptDate');
        $img->doctorName = $request->get('doctorName');
        $img->doctorSpecialty = $request->get('drSpec');
        $img->fee = $request->get('fee');
        $img->reason = $request->get('reason');
        $img->diagnosis = $request->get('diagnosis');
        $img->save();
        return redirect('imaging');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("images")->delete($id);
        return response()->json(['success'=>"Imaging Deleted successfully.", 'tr'=>'tr_'.$id]);

    }

    public function getSpecs($id)
    {
        $specs = DB::table("doctors")->where("name",$id)->pluck("specialty","id");
        
        return(json_encode($specs));
    }
}
