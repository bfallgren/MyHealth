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
      <h2>New Family History</h2><br/>

      @if (count($errors) > 0)
         <div class = "alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif
      
      <form method="post" action="{{url('fam')}}" enctype="multipart/form-data">
        @csrf
        
          <div class="form-group col-md-3">
              <label for="familyMember">Family Member:</label>
              <input type="text" size="16" maxlength="16" class="form-control" name="familyMember">
          </div>
          <div class="form-group col-md-3">
            <label for="relation">Relation:</label>
            <input type="text" size="16" maxlength="16" class="form-control" name="relation">
          </div>
          <div class="form-group col-md-3">
            <label for="symptoms">Symptoms:</label>
            <textarea type="text" size="80" maxlength="256" class="form-control" name="symptoms" id="ta_sym"></textarea>
            <div id="sym-count">
              <span id="curr-sym-cnt">0</span>
              <span id="max-sym-cnt">/ 256</span>
            </div>
          </div>   
          <div class="form-group col-md-3">
            <label for="comments">Comments:</label>
            <textarea type="text" size="80" maxlength="256" class="form-control" name="comments" id="ta_cmnt"></textarea>
            <div id="cmnt-count">
              <span id="curr-cmnt-cnt">0</span>
              <span id="max-cmnt-cnt">/ 256</span>
            </div>
          </div>   
        
        <div class="row">
            <div class="form-group col-md-4" style="margin-top:10px">
                <button type="submit" class="btn btn-success">Submit</button>
                <a href="/fam" class="btn btn-warning">Cancel</a>
            </div>
        </div>
      </form>
    </div>
    <script>
    
    $('#ta_sym').keyup(function() {
      
      var characterCount = $(this).val().length,
          current = $('#curr-sym-cnt'),
          maximum = $('#max-sym-cnt'),
          theCount = $('#sym-count');
        
      current.text(characterCount);   
          
    });

    $('#ta_cmnt').keyup(function() {
      
      var characterCount = $(this).val().length,
          current = $('#curr-cmnt-cnt'),
          maximum = $('#max-cmnt-cnt'),
          theCount = $('#cmnt-count');
        
      current.text(characterCount);   
          
    });
  </script>
  </body>
</html>
@endsection
