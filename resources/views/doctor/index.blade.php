<!-- create.blade.php -->
@extends('layouts.app')
@section('content') 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>My Health - Doctors</title>       
  </head>
  <style>
    .fa-check-circle {
        color: green;
        font-weight: bold;
        font-size: 24px;
    }
    .fa-star {
        color: gold;
        font-weight: bold;
        font-size: 10px;    
    }
  </style>
  <body>
  
    <div class="container mt-2">
  
      <div class="row">
        <div class="col-lg-12 margin-tb">
          <div class="pull-left">
            <h2>Doctors</h2>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12 margin-tb">
          <div class="pull-left mb-2">
            <a class="btn btn-success" href="{{ route('doctor.create') }}"> Add Doctor</a>
          </div>
        </div>
      </div>
        
      @if ($message = Session::get('success'))
          <div class="alert alert-success">
              <p>{{ $message }}</p>
          </div>
      @endif
    
      <div class="card-body">

        <table style=width:100% class="row-border table" id="datatable-crud">
          <thead style=color:red>
            <tr>
              <th>Name</th>
              <th>Specialty</th>
              <th>Location</th>
              <th>Hospital</th>
              <th>Active</th>
              <th>Doc Rating</th>
              <th>Staff Rating</th>
              <th>Services</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>

      </div>


      <!-- Delete Area Modal -->


<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this record?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

  </body>

 

<script type="text/javascript">
      
 $(document).ready( function () {
      $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $('#datatable-crud').DataTable({
           processing: true,
           serverSide: true,
          
           dom: '<Blf<t>ip>', /* Buttons, Length and filter above, information and pagination below table: */
            buttons: [
             
              {
                  extend: 'copy',
                  exportOptions: {
                      columns: [ 0, 1] //Your Column value those you want
                  }
              },
              {
                  extend: 'csv',
                  exportOptions: {
                      columns: [ 0, 1] //Your Column value those you want
                  }
              },
              {
                  extend: 'excel',
                  exportOptions: {
                      columns: [ 0, 1] //Your Column value those you want
                  }
              },
              {
                  extend: 'pdf',
                  exportOptions: {
                      columns: [ 0, 1] //Your Column value those you want
                  }
              },
              {
                  extend: 'print',
                  exportOptions: {
                      columns: [ 0, 1] //Your Column value those you want
                  }
              },
             
            ],
                       
           ajax: "{{ url('doctor') }}",
           columns: [
                                       
                    { data: 'name', name: 'name'},
                    { data: 'specialty', name: 'specialty' },
                    { data: 'location', name: 'location' },
                    { data: 'hospital', name: 'hospital' },
                    { data: 'active', name: 'active' },
                    { data: 'doctorRating', name: 'doctorRating' },
                    { data: 'staffRating', name: 'staffRating' },
                    { data: 'services', name: 'services' },
                    { data: 'action', name: 'action', orderable: false},
                 ],

                 columnDefs: [
                   
                    { "targets": 4, "width":"5%",
                        "render": function (data, type, col, meta) {
                            
                            if ( data == "1" )
                                {return '<center> <i class="fas fa-check-circle fa-2xl"></i>';}
                            else 
                                { return ' ';}
                        } 
                    }, 
                    { "targets": 5, "width":"5%",
                        "render": function (data, type, col, meta) {
                           if ( data > "0" )
                            {
                                var start = '<span class="';
                                var mid = 'fa fa-star';
                                var end = '"></span>';
                                var cat = start+mid+end; 
                                var fullrating = cat.repeat(data);
                                //console.log("'" +fullrating+ "'");
                                return fullrating;
                            }
                            else 
                                { return ' ';}
                        } 
                    }, 
                    { "targets": 6, "width":"5%",
                        "render": function (data, type, col, meta) {
                           if ( data > "0" )
                            {
                                var start = '<span class="';
                                var mid = 'fa fa-star';
                                var end = '"></span>';
                                var cat = start+mid+end; 
                                var fullrating = cat.repeat(data);
                                //console.log("'" +fullrating+ "'");
                                return fullrating;
                            }
                            else 
                                { return ' ';}
                        } 
                    }, 
                    { "targets": 8, "width":"5%"}
                     
                  ],

                 order: [[4, 'desc'], [0, 'asc']]
              
      });

    var table = $('#datatable-crud').DataTable() ; 
   
    $('#datatable-crud').on('click', 'tr', function() {
    table.row(this).nodes().to$().addClass('larger-font')
    }) ;     
    var row_id;

    // Delete action
    $(document).on('click', '.deleteButton', function(){
        row_id = $(this).attr('id');
        $('#deleteModal').modal('show');
    });

    $('#ok_button').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
       
            type: "POST",
            data:{
            _method:"DELETE"
            },
            url:"/doctor/" + row_id,
         
        });
            $.ajax({
                beforeSend:function(){
                    $('#ok_button').text('Deleting...');
                },
            success:function(data)
            {
                setTimeout(function(){
                    $('#deleteModal').modal('hide');
                    $('#datatable-crud').DataTable().ajax.reload();
                }, 1000);
            }
        });
    });


});

  

</script>
</html>  

@endsection