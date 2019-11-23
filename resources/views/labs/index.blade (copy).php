<!-- create.blade.php -->
<!-- v.20190812 -->
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
  
    <h2>Lab Tests</h2>

      <form method="GET" action="/Labs" style=float:right>
      {{ csrf_field() }}

      <input type="text" name="doctorName" />
      <input title='Doctor' data-toggle='tooltip' type="submit" class="btn btn-info" value="Filter"/>
      <input type="submit" class="btn btn-success" value="Reset"/>
    </form>
{{ $lab->links()}}  
    
    <br>
    <a title='Add Lab Tests' data-toggle='tooltip' href="/Labs/create" span class='fas fa-plus-square'style='font-size: 3em; color:green'></span></a>

    <table class="table table-bordered">
        <tr style="color:red">
            
            <th width="80px">Patient</th>
            <th width="90px">Test Date</th>
            <th width="80px">Component</th>
            <th width="80px">Value</th>
            <th width="65px">Good Range</th>
            <th width="120px">Comments</th>
            <th width="40px">Edit</th>
            <th width="40px">Del.</th>
        </tr>
        @if($lab->count())
            @foreach($lab as $lab)
                <tr>
                    
                    <td>{{$lab['patientName']}}</td>
                    <td>{{$lab['testDate']}}</td>
                    <td>{{$lab['component']}}</td>
                    <td>{{$lab['measuredValue']}}</td>
                    <td>{{$lab['goodRange']}}</td>
                    <td>{{$lab['comments']}}</td>
                   
                    
                      <!-- EDIT button -->
                    <td align="left"><a title='Edit Lab Test' data-toggle='tooltip' href="{{action('LabController@edit', $lab['id'])}}" span class='fas fa-edit'style='font-size: 18px; color:orange'></span></a></td>
                    
                    <!-- DELETE button -->
                     <td align="left">
                     <a href="{{ url('Labs',$lab->id) }}" class='fas fa-trash-alt'style='font-size: 18px; color:red'
                       data-tr="tr_{{$lab->id}}"
                       title="Delete Lab Test"
                       data-toggle="confirmation"
                       data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-remove"
                       data-btn-ok-class="btn btn-sm btn-danger"
                       data-btn-cancel-label="Cancel"
                       data-btn-cancel-icon="fa fa-chevron-circle-left"
                       data-btn-cancel-class="btn btn-sm btn-default"
                       data-title="Are you sure you want to delete ?"
                       data-placement="left" data-singleton="true">
                        
                    </a>
                    
                </tr>
            @endforeach

        @endif
    </table>
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