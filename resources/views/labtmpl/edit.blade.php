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
      <h2>Update Template</h2><br  />

        @if (count($errors) > 0)
           <div class = "alert alert-danger">
              <ul>
                 @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                 @endforeach
              </ul>
           </div>
        @endif
      
        <form method="post" action="{{action('LabtemplateController@update', $id)}}">
        @csrf
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
            <div class="form-group col-md-3">
                <label for="tmplName">Name:</label>
                <input type="text" size="24" maxlength="24" class="form-control" name="tmplName" value="{{$tmpl->tmplName}}">
            </div>
            <div class="form-group col-md-2">
                <label for="testDate">Date:</label>
                <input type="date" class="form-control" name="testDate" value="{{$tmpl->testDate}}">
            </div>
            
            <div class="form-group col-md-3">
                <label for="component">Component:</label>
                <input type="text" size="24" maxlength="24" class="form-control" name="component" value="{{$tmpl->component}}">
            </div>
            <div class="form-group col-md-2">
                <label for="measuredValue">Value:</label>
                <input type="text" class="form-control" name="measuredValue" value="{{$tmpl->measuredValue}}">
            </div>
            <div class="form-group col-md-2">
                <label for="goodRange">Range:</label>
                <input type="text" size="24" maxlength="24" class="form-control" name="goodRange" value="{{$tmpl->goodRange}}">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="comments">Comment:</label>
                <textarea type="text" size="40" maxlength="512" class="form-control" name="comments">{{$tmpl->comments}}</textarea>
            </div>
        </div> 
        <div class="row">
          <div class="form-group col-md-12" style="margin-top:10px">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/labtmpl" class="btn btn-warning">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
@endsection