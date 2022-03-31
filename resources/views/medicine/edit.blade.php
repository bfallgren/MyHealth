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
      <h2>Update Drug</h2><br  />

        @if (count($errors) > 0)
           <div class = "alert alert-danger">
              <ul>
                 @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                 @endforeach
              </ul>
           </div>
        @endif
      
        <form method="post" action="{{action('MedController@update', $id)}}">
        @csrf
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
          <div class="form-group col-md-4">
            <label for="patient">Patient:</label>
            <select name="patient" class="form-control">
              <option value="{{$med->patient}}">{{$med->patient}}</option>
                @foreach ($patients as $patients => $value)
                  <option > {{ $value }}</option>   
                @endforeach
            </select>
          </div>
          <div class="form-group col-md-3">
              <label for="name">Drug:</label>
              <input type="text" size="32" maxlength="32" class="form-control" name="name" value="{{$med->name}}">
          </div>
          <div class="form-group col-md-3">
            <label for="dosage">Dosage:</label>
            <input type="text" size="8" maxlength="8" class="form-control" name="dosage" value="{{$med->dosage}}">
          </div>
          <div class="form-group col-md-3">
            <label for="dailyFreq">Frequency:</label>
            <input type="text" class="form-control" name="dailyFreq" value="{{$med->dailyFreq}}">
          </div>
          <div class="form-group col-md-3">
            <label for="status">Status:</label>
            <input type="text" size="40" maxlength="80" class="form-control" name="status" value="{{$med->status}}">
          </div>
          <div class="form-group col-md-3">
            <label for="sideAffects">Side Affects:</label>
            <input type="text" size="32" maxlength="32" class="form-control" name="sideAffects" value="{{$med->sideAffects}}">
          </div>
          <div class="form-group col-md-3">
            <label for="notes">Notes:</label>
            <input type="text" size="32" maxlength="80" class="form-control" name="notes" value="{{$med->notes}}">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-12" style="margin-top:10px">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/meds" class="btn btn-warning">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
@endsection