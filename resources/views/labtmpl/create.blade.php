<!-- create.blade.php -->
@extends('layouts.app')
@section('content') 
<!DOCTYPE html>
<html>
    <head>
        <title>My Health - Create Template</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
<body>
   
<div class="container">
    <h2>Create Templates</h2> 
   
    <form method="post" action="{{url('labtmpl')}}" enctype="multipart/form-data">
        @csrf
   
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
   
        @if (Session::has('success'))
            <div class="alert alert-success text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <p>{{ Session::get('success') }}</p>
            </div>
        @endif
       <!-- {{ $patientID }} == 1 -->
        <table class="table table-bordered" id="dynamicTable">  
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Component</th>
                <th>Comments</th>
                <th>Action</th>
            </tr>
            <tr>  
                <input type="hidden" name="addmore[0][patientID]" value="{{ $patientID }}" class="form-control"/>
                <td><input type="text" name="addmore[0][tmplName]" placeholder="Enter template Name" class="form-control" /></td>  
                <td><input type="date" name="addmore[0][testDate]" placeholder="select date" class="form-control" /></td>  
                <td><input type="text" name="addmore[0][component]" placeholder="Enter component" class="form-control" /></td>  
                <td><input type="text" name="addmore[0][comments]" placeholder="Enter comments" class="form-control" /></td>  
                <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
            </tr>  
        </table> 
    
        <button type="submit" class="btn btn-success">Save</button>
        <a href="/labtmpl" class="btn btn-warning">Cancel</a>
    </form>
</div>
   
<script type="text/javascript">
   
    var i = 0;
       
    $("#add").click(function(){
   
        ++i;
   
        $("#dynamicTable").append('<tr> + \
        <input type="hidden" name="addmore['+i+'][patientID]" value="{{ $patientID }}" class="form-control"/> + \
        <td><input type="text" name="addmore['+i+'][tmplName]" placeholder="Enter Template Name" class="form-control" /></td> + \
        <td><input type="date" name="addmore['+i+'][testDate]" placeholder="Select Date" class="form-control" /></td> + \
        <td><input type="text" name="addmore['+i+'][component]" placeholder="Enter Component" class="form-control" /></td> + \
        <td><input type="text" name="addmore['+i+'][comments]" placeholder="Enter comments" class="form-control" /></td> + \
        <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
    });
   
    $(document).on('click', '.remove-tr', function(){  
         $(this).parents('tr').remove();
    });  
   
</script>
  
</body>
</html>
@endsection