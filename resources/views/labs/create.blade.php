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
      <h2>New Lab Test</h2><br/>

      @if (count($errors) > 0)
         <div class = "alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif

      <form method="post" action="{{url('Labs')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-12"></div>
           
          <div class="form-group col-md-4">                 
             <label for="patientName">Patient:</label>
            <select name="patientName" class="form-control">
              <option value="">--Select Patient--</option>
                @foreach ($patients as $patients => $value)
                  <option > {{ $value }}</option>   
                @endforeach
            </select>
          </div>

          <div class="form-group col-md-4">
            <label for="testDate">Date of Test:</label>
            <input type="date" class="form-control" name="testDate">
          </div>

          <div class="form-group col-md-4">
            <label for="component">Component:</label>
            <input type="text" size="24" maxlength="24" class="form-control" name="component">
          </div>

          <div class="form-group col-md-4">
            <label for="measuredValue">Value:</label>
            <input type="text" class="form-control" name="measuredValue">
          </div>

          <div class="form-group col-md-4">
            <label for="goodRange">Good Range:</label>
            <input type="text" size="24" maxlength="24" class="form-control" name="goodRange">
          </div>

          <div class="form-group col-md-4">
            <label for="comments">Comments:</label>
            <textarea type="text" size="80" maxlength="512" class="form-control" name="comments"></textarea>
          </div>
         
        </div>
        
        <div class="row">
          <div class="col-md-12"></div>
          <div class="form-group col-md-4" style="margin-top:10px">
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="/Labs" class="btn btn-warning">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
@endsection
