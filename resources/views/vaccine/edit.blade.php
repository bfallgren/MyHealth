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
      <h2>Update Immunization</h2><br  />

      @if (count($errors) > 0)
         <div class = "alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif
      
        <form method="post" action="{{action('VaccineController@update', $id)}}">
        @csrf
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
          <div class="col-md-12"></div>
          <div class="form-group col-md-4">
            <label for="PatientName">Patient:</label>
            <select name="patientName" class="form-control">
              <option value="{{$shot->patientName}}">{{$shot->patientName}}</option>
                @foreach ($patients as $patients => $value)
                  <option > {{ $value }}</option>   
                @endforeach
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="vDate">Date of Vaccine:</label>
            <input type="date" class="form-control" name="vDate" value="{{$shot->vDate}}">
          </div>
          <div class="form-group col-md-4">
            <label for="vaccine">Vaccine:</label>
            <input type="text" size="24" maxlength="24" class="form-control" name="vaccine" value="{{$shot->vaccine}}">
          </div>
          <div class="form-group col-md-4">
            <label for="comments">Comments:</label>
            <textarea type="text" size="80" maxlength="512" class="form-control" name="comments">{{$shot->comments}}</textarea>
          </div>
          
        </div>
        <div class="row">
          <div class="col-md-12"></div>
          <div class="form-group col-md-12" style="margin-top:10px">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/vaccine" class="btn btn-warning">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
@endsection