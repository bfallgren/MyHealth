<!-- create.blade.php -->
@extends('layouts.app')
@section('content') 
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>My Health - Create </title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   </head>
  <body>
    <div class="container">
      <h2>New Drug</h2><br/>

      @if (count($errors) > 0)
         <div class = "alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif
      
      <form method="post" action="{{url('meds')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group col-md-4">                 
             <label for="patient">Patient:</label>
            <select name="patient" class="form-control">
              <option value="">--Select Patient--</option>
                @foreach ($patients as $patients => $value)
                  <option > {{ $value }}</option>   
                @endforeach
            </select>
          </div>
          <div class="form-group col-md-3">
              <label for="name">Drug:</label>
              <input type="text" size="32" maxlength="32" class="form-control" name="name">
          </div>
          <div class="form-group col-md-3">
            <label for="dosage">Dosage:</label>
            <input type="text" size="8" maxlength="8" class="form-control" name="dosage">
          </div>
          <div class="form-group col-md-3">
            <label for="dailyFreq">Frequency:</label>
            <input type="text" class="form-control" name="dailyFreq">
          </div>
          <div class="form-group col-md-3">
            <label for="status">Status:</label>
            <input type="text" size="40" maxlength="80" class="form-control" name="status">
          </div>
          <div class="form-group col-md-3">
            <label for="sideAffects">Side Affects:</label>
            <input type="text" size="32" maxlength="32" class="form-control" name="sideAffects">
          </div>
          <div class="form-group col-md-3">
            <label for="precautions">Precautions:</label>
            <input type="text" size="32" maxlength="80" class="form-control" name="precautions">
          </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4" style="margin-top:10px">
                <button type="submit" class="btn btn-success">Submit</button>
                <a href="/meds" class="btn btn-warning">Cancel</a>
            </div>
        </div>
      </form>
    </div>
  </body>
</html>
@endsection
