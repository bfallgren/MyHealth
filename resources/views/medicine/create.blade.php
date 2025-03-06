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
        <div class="row">
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
            <textarea type="text" size="40" maxlength="80" class="form-control" id="ta_status" name="status"></textarea>
           
           <div id="status-count">
             <span id="curr-stat-cnt">0</span>
             <span id="max-stat-cnt">/ 80</span>
           </div>
          </div>
          <div class="form-group col-md-3">
            <label for="sideAffects">Side Affects:</label>
            <input type="text" size="32" maxlength="32" class="form-control" name="sideAffects">
          </div>
          <div class="form-group col-md-3">
            <label for="notes">Notes:</label>
            <textarea type="text" size="32" maxlength="255" class="form-control" id="ta_notes" name="notes"></textarea>
           
           <div id="notes-count">
             <span id="curr-notes-cnt">0</span>
             <span id="max-notes-cnt">/ 255</span>
           </div>          
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
<script>
  $('#ta_status').keyup(function() {
    
    var characterCount = $(this).val().length,
        current = $('#curr-stat-cnt'),
        maximum = $('#max-stat-cnt'),
        theCount = $('#status-count');
      
    current.text(characterCount);   
        
  });

  $('#ta_notes').keyup(function() {
    
    var characterCount = $(this).val().length,
        current = $('#curr-notes-cnt'),
        maximum = $('#max-notes-cnt'),
        theCount = $('#notes-count');
      
    current.text(characterCount);   
        
  });
</script>
@endsection
