<?php

namespace App\Http\Controllers;

use App\Labtemplate;
use App\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Datatables;
use Auth;

class LabtemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()) { 
            $currentuser = Auth::user()->id;
               
            $data = DB::table('labtemplates')
            ->where('patientID','=',$currentuser)
            ->orderBy('component', 'asc')
            ->get();
              if(request()->ajax()) {
                return datatables()->of($data)
                ->addColumn('checkbox', '<input type = "checkbox" name = "add_chk[]" class = "add_chk" value = {{$id}} />')
                ->addColumn('action', function ($rows) {
                  $button = '<div class="btn-group btn-group-xs">';
                  $button .= '<a href="/labtmpl/' . $rows->id . '/edit" title="Edit" ><i class="fa fa-edit" style="font-size:24px"></i></a>';
                  $button .= '</div>';
                  return $button;
              })
              ->rawColumns(['checkbox','action'])
              ->make(true);
            }
    
              return view('labtmpl.index'); 
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
            $currentuserid = Auth::user()->id;
            $patientID = $currentuserid;
            return view('labtmpl.create',compact('patientID'));
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
          'addmore.*.tmplName' => 'required',
          'addmore.*.component' => 'required',
          'addmore.*.testDate' => 'required',
            
            ]);

            foreach ($request->addmore as $key => $value) {
              Labtemplate::create($value);
          }
            return redirect('labtmpl')->with('success','Template has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Labtemplate  $labtemplate
     * @return \Illuminate\Http\Response
     */
    public function show(Labtemplate $labtemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Labtemplate  $labtemplate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if(Auth::check()) {  
        $tmpl = Labtemplate::find($id);
        return view('labtmpl.edit',compact('tmpl','id'));
        }
      else {
        return redirect()->to('/');
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Labtemplate  $labtemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'tmplName' => 'required',
        'component' => 'required',
        ]);
        if(Auth::check()) { 
          $tmpl= Labtemplate::find($id);
          $tmpl->tmplName = $request->get('tmplName');
          $currentuserid = Auth::user()->id;
          $tmpl->patientID = $currentuserid;
          $tmpl->testDate = $request->get('testDate');    
          $tmpl->component = $request->get('component');   
          $tmpl->measuredValue = $request->get('measuredValue');  
          $tmpl->goodRange = $request->get('goodRange');
          $tmpl->comments = $request->get('comments');    
          $tmpl->save();
          return redirect('labtmpl');
        }
        else {
          return redirect()->to('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Labtemplate  $labtemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if(Auth::check()) {   
          DB::table("labtemplates")->delete($id);
          return redirect('labtmpl')->with('success','Template Record has been deleted');
      }
    }

    public function deleteall(Request $request)
    {
      if(Auth::check()) {   
          $user_id_array = $request->input('id');
          $tmpl = Labtemplate::whereIn('id', $user_id_array);
          if($tmpl->delete())
          {
              echo 'Data Deleted';
          }
          return redirect('labtmpl');
      }
    }

    public function storeall(Request $request)
    {
      if(Auth::check()) {   
        $selected_ids = $request->input('id');
        //\Debugbar::info('1',$selected_ids);
        // for each selected template, store a lab record
          foreach ($selected_ids as $key => $value) {
            $tmpl = Labtemplate::find($value);
            $newRec = new Lab();
            $currentuser = Auth::user()->id;
            $newRec->patientID = $currentuser;
            $newRec->testDate = $tmpl->testDate;
            $newRec->component = $tmpl->component;
            $newRec->measuredValue = $tmpl->measuredValue;
            $newRec->goodRange = $tmpl->goodRange;
            $newRec->comments = $tmpl->tmplName;
            $newRec->save();
          }
        echo 'Lab record(s) have been added';
      }
    }

    public function moddate(Request $request)
    {
      if(Auth::check()) {   

        $selected_ids = $request->input('id');
       // \Debugbar::info('$request',$request);
          // for each selected template, update testDate 
          foreach ($selected_ids as $key => $value) {
            $tmpl = Labtemplate::find($value);
            $tmpl->testDate = $request->input('nDate');
            $tmpl->save();
          }
        echo 'Lab Template Date(s) updated!';
      }
    }
}
