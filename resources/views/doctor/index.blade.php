<!-- create.blade.php -->
@extends('layouts.app')
@section('content') 
<html>
  <head>
    <meta charset="utf-8">
    <title>My Health Index</title>
     <link href="{{ asset('css/app.css') }}" media="all" rel="stylesheet" type="text/css" />
   
    
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
  
    <h2>Doctors  <i class="fas fa-user-md"></i></h2>

    <br>
    <a title='Add Doctor' data-toggle='tooltip' href="/doctor/create" span class='fas fa-plus-square'style='font-size: 3em; color:green'></span></a><br></br>
    
    <div class=topPage>

    <input type="text" name="serach" id="serach" class="form-control" placeholder="doctor|specialty" width="25" />
         <form>
            <label>Items Per Page</label>
            <a title='Reset List' data-toggle='tooltip' href="/doctor" span class='fas fa-sync-alt'style='font-size: 1.5em; color:green'></span></a>
            <select id="mypagination" >
                <option value="5" @if($items == 5) selected @endif >5</option>
                <option value="10" @if($items == 10) selected @endif >10</option>
                <option value="25" @if($items == 25) selected @endif >25</option>
            </select>
        </form> 
      
    </div>
   
    <div class="table-responsive">
        <table class="table" style="border:none border-collapse:collapse">
          <thead>
            <tr>
              <th width="80px" class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer; color: red">Name <span id="name_icon"></span></th>
              <th width="80px" class="sorting" data-sorting_type="asc" data-column_name="specialty" style="cursor: pointer; color: red">Specialty<span id="specialty_icon"></span></th>
              <th width="40px">
              <th width="40px">
              <th width="10px" style="color: red">Edit</th>
              <th width="10px" style="color: red">Del.</th>
            </tr>
          </thead>
          @include('doctor.index_data')
        </table>
        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="specialty" />
        <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
   </div> <!-- row </-->

</div> <!-- container / end -->

</body>

<script type="text/javascript">
/* ITEM PAGINATION CODE */
document.getElementById('mypagination').onchange = function() { 
        window.location = "{{URL::route('mydoc')}}?items=" + this.value; 
    }; 

  $(document).ready(function () {
/* DELETE CODE */
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
              //console.log(data);
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

/* SSP CODE */ 
function clear_icon()
 {
  $('#name_icon').html('');
  $('#specialty_icon').html('');
 }

 function fetch_data(page, sort_type, sort_by, query, items)
 {
   $.ajax({
   url:"/fetchDocs?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&query="+query+"&items="+items,
   success:function(data)
   {
    //console.log('success-data:',data);
    $('tbody').html('');
    $('tbody').html(data);
   }
  })
 }

 $(document).on('keyup', '#serach', function(){
  var query = $('#serach').val();
  var column_name = $('#hidden_column_name').val();
  var sort_type = $('#hidden_sort_type').val();
  var page = $('#hidden_page').val();
  var myItems = document.getElementById("mypagination");
  var myItemsVal = myItems.value;
  fetch_data(page, sort_type, column_name, query, myItemsVal);
 });

 $(document).on('click', '.sorting', function(){
  var column_name = $(this).data('column_name');
  var order_type = $(this).data('sorting_type');
  var reverse_order = '';
  if(order_type == 'asc')
  {
   $(this).data('sorting_type', 'desc');
   reverse_order = 'desc';
   clear_icon();
   $('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
  }
  if(order_type == 'desc')
  {
   $(this).data('sorting_type', 'asc');
   reverse_order = 'asc';
   clear_icon
   $('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
  }
  $('#hidden_column_name').val(column_name);
  $('#hidden_sort_type').val(reverse_order);
  var page = $('#hidden_page').val();
  var query = $('#serach').val();
  var myItems = document.getElementById("mypagination");
  var myItemsVal = myItems.value;
  //console.log("items=",myItemsVal);
  fetch_data(page, reverse_order, column_name, query, myItemsVal);
 });
 $(document).on('click', '.pagination a', function(event){
  event.preventDefault();
  var page = $(this).attr('href').split('page=')[1];
  $('#hidden_page').val(page);
  var column_name = $('#hidden_column_name').val();
  var sort_type = $('#hidden_sort_type').val();
  var query = $('#serach').val();
  var myItems = document.getElementById("mypagination");
  var myItemsVal = myItems.value;
  $('li').removeClass('active');
        $(this).parent().addClass('active');
  fetch_data(page, sort_type, column_name, query, myItemsVal);
 });

});


</script>



</html>
@endsection