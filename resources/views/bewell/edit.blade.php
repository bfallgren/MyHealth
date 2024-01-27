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
      <h2>Update Appointment</h2><br  />

      @if (count($errors) > 0)
         <div class = "alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif
      
        <form method="post" action="{{action('HealthController@update', $id)}}">
        @csrf
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
                   
          <div class="form-group col-md-4">
            <label for="apptDate">Date of Appt.:</label>
            <input type="date" class="form-control" name="apptDate" value="{{$appt->apptDate}}">
          </div>
          <div class="form-group col-md-4">
            <label for="doctorName">Doctor:</label>
            <select name="doctorName" class="form-control">
              <option value="{{$appt->doctorName}}">{{$appt->doctorName}}</option>
                @foreach ($doctors as $doctors => $value)
                  <option > {{ $value }}</option>   
                @endforeach
            </select>
          </div>
          <div class="form-group col-md-4">                 
             <label for="doctorSpecialty">Specialty:</label>
            <select name="doctorSpecialty" class="form-control">
              <option value="{{$appt->doctorSpecialty}}">{{$appt->doctorSpecialty}}</option>
                
            </select>
          </div>

          <div>
             <input type="hidden" id ="drSpec" name="drSpec">
          </div>
          <div class="form-group col-md-4">
            <label for="fee">Fee:</label>
            <input type="text" class="form-control" name="fee" required value="{{$appt->fee}}">
          </div>
          <div class="form-group col-md-4">
            <label for="reason">Reason:</label>
            <textarea type="text" size="80" maxlength="80" class="form-control" name="reason" >{{$appt->reason}}</textarea>
          </div>
          <div class="form-group col-md-4">
            <label for="diagnosis">Diagnosis:</label>
            <textarea type="text" size="80" maxlength="512" class="form-control" name="diagnosis" >{{$appt->diagnosis}}</textarea>
          </div>
          <div class="form-group col-md-4">
            <label for="vitalsWeight">Weight:</label>
            <input type="text" class="form-control" name="vitalsWeight" required value="{{$appt->vitalsWeight}}">
          </div>
          <div class="form-group col-md-4">
            <label for="vitalsBP">Blood Pressure:</label>
            <input type="text" size="8" maxlength="16" class="form-control" name="vitalsBP" value="{{$appt->vitalsBP}}">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12"></div>
          <div class="form-group col-md-12" style="margin-top:10px">
            <button type="submit" class="btn btn-success" onClick="checkSpec()">Update</button>
            <a href="/myHealth" class="btn btn-warning">Cancel</a>
          </div>
        </div>
      </form>
    </div>
<script type="text/javascript">
  jQuery(document).ready(function()
  {
    jQuery('select[name="doctorName"]').on('change',function() {
      
     var docName = jQuery(this).val();
      if (docName)
      {
       jQuery.ajax({
          url : '/myHealth/getSpecs/' +docName,
          type : "GET",
          dataType : "json",
          success:function(data)
          {
            jQuery('select[name="doctorSpecialty"]').empty();
            jQuery.each(data, function(key,value) {
              $('select[name="doctorSpecialty"]').append('<option value="'+ key + '">'+ value +'</option>');
              var y = value;
              document.getElementById('drSpec').value = y;
            });   
          }
        });
      }
        else
        {
          $('select[name="doctorSpecialty"]').empty();

        }
      });
  });    

  </script>
  <script>
    function checkSpec() {
      var len = $('#drSpec').val().length;
      if(len > 0) {
       /* alert('drSpec is not empty'); */
        
      }
      else {
        document.getElementById('drSpec').value = "{{$appt->doctorSpecialty}}";
        /* alert('drSpec is empty'); */
      }
    }
  </script>
  </body>
</html>
@endsection