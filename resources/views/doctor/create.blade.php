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
      <h2>New Doctor</h2><br/>

      @if (count($errors) > 0)
         <div class = "alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif
     
      <form method="post" action="{{url('doctor')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="form-group col-md-3">
                <label for="name">Doctor:</label>
                <input type="text" size="16" maxlength="32" class="form-control" name="name" >
            </div>
            <div class="form-group col-md-3">
                <label for="specialty">Specialty:</label>
                <input type="text" size="16" maxlength="24" class="form-control" name="specialty" >
            </div>
            
            <div class="form-group col-md-3">              
                <input type="checkbox" name="active" value="$chk" checked>                  
                <label for="active"> Active?</label>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                <label for="location">Location:</label>
                <input type="text" size="24" maxlength="36" class="form-control" name="location" >
            </div>
            <div class="form-group col-md-3">
                <label for="hospital">Hospital:</label>
                <input type="text" size="24" maxlength="36" class="form-control" name="hospital" >
            </div>
        </div> 
        <div class="row">
            <div class="form-group col-md-3">
                <label for="doctorRating">Doctor Rating:</label>
                <input type="number" class="form-control" name="doctorRating" >
            </div>
            <div class="form-group col-md-3">
                <label for="staffRating">Staff Rating:</label>
                <input type="number" class="form-control" name="staffRating" >
            </div>
            <div class="form-group col-md-3">
                <label for="services">Services:</label>
                <input type="text" size="24" maxlength="64" class="form-control" name="services" >
            </div>
        </div> 
        <div class="row">
            <div class="form-group col-md-4" style="margin-top:10px">
                <button type="submit" class="btn btn-success">Submit</button>
                <a href="/doctor" class="btn btn-warning">Cancel</a>
            </div>
        </div>
      </form>
    </div>
  </body>
</html>
@endsection
