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
    <h2>Family History <i class="fas fa-users"></i></h2>
    <div class=topPage>
      
    <form>
          {{ csrf_field() }}
          <label>Items Per Page</label>
          <select id="pagination" >
              <option value="5" @if($items == 5) selected @endif >5</option>
              <option value="10" @if($items == 10) selected @endif >10</option>
              <option value="25" @if($items == 25) selected @endif >25</option>
          </select>
    </form> 
   
        
        {{ $fhist->appends(compact('items'))->onEachSide(1)->links() }}
       
     </div> 
    
    <a title='Add Family History' data-toggle='tooltip' href="/fam/create" span class='fas fa-plus-square'style='font-size: 3em; color:green'></span></a>
 
         
       <table class="table" style="border:none border-collapse:collapse">
        <tr style="color:red">
            
            <th width="80px">Patient</th>
            <th width="80px">Family Member</th>
            <th width="80px">Relation</th>
            <th width="160px">Symptoms</th>
            <th width="40px">Edit</th>
            <th width="40px">Del.</th>
        </tr>
        @if($fhist->count())
            @foreach($fhist as $fhist)
                <tr>
                    
                    <td>{{$fhist['patient']}}</td>
                    <td>{{$fhist['familyMember']}}</td>
                    <td>{{$fhist['relation']}}</td>
                    <td><textarea readonly type="text" rows="1" cols="30" class="form-control" name="symptoms">{{$fhist->symptoms}}</textarea></td>
                                                            
                      <!-- EDIT button -->
                    <td align="left"><a title='Edit Family History' data-toggle='tooltip' href="{{action('FamhistController@edit', $fhist['id'])}}" span class='fas fa-edit'style='font-size: 18px; color:orange'></span></a></td>
                    
                    <!-- DELETE button -->
                     <td align="left">
                     <a href="{{ url('fam',$fhist->id) }}" class='fas fa-trash-alt'style='font-size: 18px; color:red'
                       data-tr="tr_{{$fhist->id}}"
                       title="Delete Family History record"
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
        window.location = "{{URL::route('myfam')}}?items=" + this.value; 
    }; 
</script>


</html>
@endsection