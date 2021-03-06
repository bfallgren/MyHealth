<!-- create.blade.php -->
@extends('layouts.app')
@section('content') 
<html>
  <head>
    <meta charset="utf-8">
    <title>My Health Index</title>
     <link href="{{ asset('css/app.css') }}" media="all" rel="stylesheet" type="text/css" />
   
    <!-- using font-awesome (free/solid) icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/solid.css" integrity="sha384-r/k8YTFqmlOaqRkZuSiE9trsrDXkh07mRaoGBMoDcmA58OHILZPsk29i2BsFng1B" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/fontawesome.css" integrity="sha384-4aon80D8rXCGx9ayDt85LbyUHeMWd3UiBaWliBlJ53yzm9hqN21A+o1pqoyK04h+" crossorigin="anonymous">
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


  </head>
<body>

 <div class="container">
          
    @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div>
    @endif
  
    <h2>Patients   <i class="fas fa-user"></i></h2>

    <br>
    <a title='Add Member' data-toggle='tooltip' href="/patient/create" span class='fas fa-plus-square'style='font-size: 3em; color:green'></span></a><br></br>

{{ $member->links()}}     

     <div class="row" form-group style="color:red">
        
        <div class="col-md-4">
          <h4 width="40px">Patient</h4>
        </div>
        <div class="col-md-4">
          <h4 width="40px">Primary Doctor</h4>
        </div>
        <div class="col-md-1">
          <h4 width="10px">Edit</h4>
        </div>
        <div class="col-md-1">
          <h4 width="10px">Del.</h4>
        </div>
      </div>

         @if($member->count())
            @foreach($member as $member)

              <div class="row">
                
                 <div class="col-md-4">
                  <p>{{$member['name']}}</p>
                 </div> 
                 <div class="col-md-4">
                  <p>{{$member['primaryDoctor']}}</p>
                 </div>    
                 <!-- EDIT button -->
                 <div class="col-md-1">
                 <a title='Edit Member' data-toggle='tooltip' href="{{action('PatientController@edit', $member['id'])}}">
                 <span class='fas fa-edit'style='font-size: 18px; color:orange'></span></a>
                 </div>   
                 <!-- DELETE button -->
                 <div class="col-md-1">
                    <a href="{{ URL::to('patient',$member->id) }}" class='fas fa-trash-alt'style='font-size: 18px; color:red'
                       data-tr="tr_{{$member->id}}"
                       title="Delete Member"
                       data-toggle="confirmation"
                       data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-remove"
                       data-btn-ok-class="btn btn-sm btn-danger"
                       data-btn-cancel-label="Cancel"
                       data-btn-cancel-icon="fa fa-chevron-circle-left"
                       data-btn-cancel-class="btn btn-sm btn-default"
                       data-title="Are you sure you want to delete ?"
                       data-placement="left" data-singleton="true">
                        
                    </a>
                  </div>
              </div>    
            @endforeach

        @endif

</div> <!-- container / end -->

</body>

<!-- DELETE CODE -->
<script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.trigger('confirm');
            }
        });

        $(document).on('confirm', function (e) {
            var ele = e.target;
            e.preventDefault();


            $.ajax({
                url: ele.href,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                        location.reload();
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });


            return false;
        });
    });
</script>


</html>
@endsection