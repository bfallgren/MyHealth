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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
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
    <h2>Imaging  <i class="fas fa-x-ray"></i></h2>
    <div class=topPage>
      
    <form method="GET" action="/imaging" style=float:right> 
        {{ csrf_field() }}

          <input type="text" name="doctorName" placeholder="Doctor%">
          <input title='Doctor' data-toggle='tooltip' type="submit" class="btn btn-info" value="Filter"/>
          <input type="submit" class="btn btn-success" value="Reset"/>
       </form>
       
        <form>
          {{ csrf_field() }}
          <label>Items Per Page</label>
          <select id="pagination" >
              <option value="5" @if($items == 5) selected @endif >5</option>
              <option value="10" @if($items == 10) selected @endif >10</option>
              <option value="25" @if($items == 25) selected @endif >25</option>
          </select>
       </form> 
   
        
        {{ $img->appends(compact('items'))->links() }}
       
     </div> 
    
    <a title='Add Imaging' data-toggle='tooltip' href="/imaging/create" span class='fas fa-plus-square'style='font-size: 3em; color:green'></span></a>
 
         
       <table class="table" style="border:none border-collapse:collapse">
        <tr style="color:red">
            
            <th width="80px">Patient</th>
            <th width="90px">Appt Date</th>
            <th width="100px">Doctor</th>
            <th width="120px">Specialty</th>
            <th width="65px">Fee</th>
            <th width="120px">Reason/Diagnosis</th>
            <th width="40px">Edit</th>
            <th width="40px">Del.</th>
        </tr>
        @if($img->count())
            @foreach($img as $img)
                <tr>
                    
                    <td>{{$img['patientName']}}</td>
                    <td>{{$img['apptDate']}}</td>
                    <td >{{$img['doctorName']}}</td>
                    <td >{{$img['doctorSpecialty']}}</td>
                    <td>${{number_format($img['fee'],2)}}</td>
                    <td width="75px" data-container="body" data-toggle="popover" data-trigger="hover" title="Reason"  data-content="{!! $img->reason !!}" span class='fas fa-glasses'></span></td>
                   
                    <td data-container="body" data-toggle="popover" data-trigger="hover" title="Diagnosis"  data-content="{!! $img->diagnosis !!}" span class='fas fa-glasses'></span></td>
                                    
                      <!-- EDIT button -->
                    <td align="left"><a title='Edit Imaging' data-toggle='tooltip' href="{{action('ImageController@edit', $img['id'])}}" span class='fas fa-edit'style='font-size: 18px; color:orange'></span></a></td>
                    
                    <!-- DELETE button -->
                     <td align="left">
                     <a href="{{ url('imaging',$img->id) }}" class='fas fa-trash-alt'style='font-size: 18px; color:red'
                       data-tr="tr_{{$img->id}}"
                       title="Delete Imaging"
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

<script>
    document.getElementById('pagination').onchange = function() { 
        window.location = "{{URL::route('myimaging')}}?items=" + this.value; 
    }; 

    $('[data-toggle="popover"]').popover({
            placement : 'center',
            html : true
    }) 
</script>

</html>
@endsection