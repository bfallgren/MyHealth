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
      <h2>Update Patient</h2><br  />

        @if (count($errors) > 0)
           <div class = "alert alert-danger">
              <ul>
                 @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                 @endforeach
              </ul>
           </div>
        @endif
      
        <form method="post" action="{{action('PatientController@update', $id)}}">
        @csrf
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
            
            <div class="form-group col-md-3">
              <label for="fullName">Full Name:</label>
              <input type="text" size="48" maxlength="48" class="form-control" name="fullName" value="{{$member->fullName}}">
          </div>
          <div class="form-group col-md-3">
              <label for="birthDate">Birth:</label>
              <input type="date" class="form-control" name="birthDate" value="{{$member->birthDate}}">
          </div>
          <div class="form-group col-md-3">
              <label for="insurance">Pri. Insurance:</label>
              <input type="text" size="48" maxlength="48" class="form-control" name="insurance" value="{{$member->insurance}}">
          </div>
          <div class="form-group col-md-3">
              <label for="memberID">Ins. Member ID:</label>
              <input type="text" size="24" maxlength="24" class="form-control" name="memberID" value="{{$member->memberID}}">
          </div>
            <div class="form-group col-md-3">
                <label for="primaryDoctor">Primary Doctor:</label>
                <select name="primaryDoctor" class="form-control">
                  <option value="{{$member->primaryDoctor}}">{{$member->primaryDoctor}}</option>
                  @foreach ($doctors as $doctors => $value)
                    <option > {{ $value }}</option>   
                  @endforeach
                </select>
            </div>
        </div>
        <div class="row">
          <div class="form-group col-md-12" style="margin-top:10px">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/patient" class="btn btn-warning">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
@endsection