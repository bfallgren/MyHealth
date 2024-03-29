<!-- edit.blade.php -->
@extends('layouts.app')
@section('content') 
<!DOCTYPE html>
<html>
  <meta charset="utf-8">
    <title>My Health - Edit </title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <body>
    <div class="container">
      <h2>Update Doctor</h2><br  />

        @if (count($errors) > 0)
           <div class = "alert alert-danger">
              <ul>
                 @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                 @endforeach
              </ul>
           </div>
        @endif
      
        <form method="post" action="{{action('DoctorController@update', $id)}}">
        @csrf
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
            <div class="form-group col-md-3">
                <label for="name">Doctor:</label>
                <input type="text" size="16" maxlength="32" class="form-control" name="name" value="{{$doc->name}}">
            </div>
            <div class="form-group col-md-3">
                <label for="specialty">Specialty:</label>
                <input type="text" size="16" maxlength="24" class="form-control" name="specialty" value="{{$doc->specialty}}">
            </div>
            
            <div class="form-group col-md-3">
              @if ($doc->active === 1)
                <input type="checkbox" id="active" name="active" value="{{$doc->active}}" checked>
              @else
                <input type="checkbox" id="active" name="active" value="{{$doc->active}}">
              @endif
                  
              <label for="active"> Active?</label><br>
            </div>
        </div>
        <div class="row">
        <div class="form-group col-md-3">
                <label for="location">Location:</label>
                <input type="text" size="24" maxlength="36" class="form-control" name="location" value="{{$doc->location}}">
            </div>
            <div class="form-group col-md-3">
                <label for="hospital">Hospital:</label>
                <input type="text" size="24" maxlength="36" class="form-control" name="hospital" value="{{$doc->hospital}}">
            </div>
        </div> 
        <div class="row">
            <div class="form-group col-md-3">
                <label for="doctorRating">Doctor Rating:</label>
                <input type="number" class="form-control" name="doctorRating" value="{{$doc->doctorRating}}">
            </div>
            <div class="form-group col-md-3">
                <label for="staffRating">Staff Rating:</label>
                <input type="number" class="form-control" name="staffRating" value="{{$doc->staffRating}}">
            </div>
            <div class="form-group col-md-3">
                <label for="services">Services:</label>
                <input type="text" size="24" maxlength="64" class="form-control" name="services" value="{{$doc->services}}">
            </div>
        </div> 
        <div class="row">
          <div class="form-group col-md-12" style="margin-top:10px">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/doctor" class="btn btn-warning">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
@endsection