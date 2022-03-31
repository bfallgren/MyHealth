<!-- index.blade.php -->
@extends('layouts.app')
@section('content') 
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>My Health - Vaccine</title>
      
             
  </head>
  <body>
  
    <div class="container mt-2">
  
      <div class="row">
        <div class="col-lg-12 margin-tb">
          <div class="pull-left">
          <h2>Immunizations <i class="fas fa-syringe"></i></h2>
          </div>
          <div class="pull-right mb-2">
            <a class="btn btn-success" href="{{ route('vaccine.create') }}"> Add Vaccine</a>
          </div>
        </div>
      </div>
        
      @if ($message = Session::get('success'))
          <div class="alert alert-success">
              <p>{{ $message }}</p>
          </div>
      @endif
    
      <div class="card-body">

        <table class="row-border table" id="datatable-crud">
          <thead style=color:red>
            <tr>
              <th>Patient</th>
              <th>Vaccine Date</th>
              <th>Vaccine</th>
              <th>Comments</th>
              <th>Comments</th>
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

      <div class="modal fade" id="DiagModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">�</button>
                    <h3 class="modal-title">Comments Detail</h3>

                </div>
                <div class="modal-body">
                   <!-- Data passed is displayed
                            in this part of the 
                            modal body -->
                            <p id="modal_body"></p> 

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                   
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
  

  </body>

 

  <script type="text/javascript">
      
     $(document).ready( function () {
      $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var table = $('#datatable-crud').DataTable({
        
           processing: true,
           serverSide: true,
           
           dom: '<Blf<t>ip>', /* Buttons, Length and filter above, information and pagination below table: */
            buttons: [
             
              {
                  extend: 'copy',
                  exportOptions: {
                      columns: [ 1, 2, 3] //Your Column value those you want
                  }
              },
              {
                  extend: 'csv',
                  exportOptions: {
                    columns: [ 1, 2, 3] //Your Column value those you want
                  }
              },
              {
                  extend: 'excel',
                  exportOptions: {
                    columns: [ 1, 2, 3] //Your Column value those you want
                  }
              },
              {
                  extend: 'pdf',
                  exportOptions: {
                    columns: [ 1, 2, 3] //Your Column value those you want
                  }
              },
              {
                  extend: 'print',
                  exportOptions: {
                    columns: [ 1, 2, 3] //Your Column value those you want
                  }
              },
             
            ],
           ajax: "{{ url('vaccine') }}",
           columns: [
                                        
              { data: 'patientName', name: 'patientName'},
              { data: 'vDate', name: 'vDate' },
              { data: 'vaccine', name: 'Vaccine'},      
              { data: 'comments', name: 'comments' },
              { data: 'clickme', name: 'clickme',  "className": "comments-class", orderable: false},
              { data: 'action', name: 'action', orderable: false},
            ],

            columnDefs: [
                  
                    { "targets": 0, "width":"15%"},
                    { "targets": 1, "width":"15%"},
                    { "targets": 2, "width":"35%"},
                    { "targets": 4, width:"10%",
                      "render": function (data, type, col, meta) {
                         return type === 'display'? '<i class="fa fa-glasses"></i>' : data;
                      }     
                    },
                    { "targets": 3, "visible":false}                    
                    
                  ],

          order: [[0, 'desc']]

         
              
      });

      
      var colData;
      var rowData;
      $('#datatable-crud').on('click', '.comments-class', function () {
        
        colData = table.cell( this ).data() ;
       
        var data = table.row($(this).parents('tr')).data(); // getting target row 
        var dataDiag = data['comments'];
      
        $("#modal_body").html(dataDiag);
        
        $('#DiagModal').modal("show");
    });
     
     
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
            url:"/vaccine/" + row_id,
         
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