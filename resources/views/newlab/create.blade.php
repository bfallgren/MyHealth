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
      <h2>New Lab Test Detail</h2><br/>

      @if (count($errors) > 0)
         <div class = "alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif

      <form method="post" action="{{url('lab')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-12">
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
              <textarea type="text" size="80" maxlength="512" class="form-control" name="comments" id="ta_cmnt"></textarea>
              <div id="cmnt-count">
                <span id="curr-cmnt-cnt">0</span>
                <span id="max-cmnt-cnt">/ 512</span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group col-md-4" >
              <button type="submit" class="btn btn-success">Submit</button>
                <a href="/lab" class="btn btn-warning">Cancel</a>
            </div>
          </div>
        </div>
      </form>
    </div>
    <script>
    
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
