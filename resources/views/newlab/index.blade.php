<!-- index.blade.php -->
@extends('layouts.app')
@section('content') 
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>My Health - Labwork</title>
      
             
  </head>
  <body>
  
    <div class="container mt-2">
  
      <div class="row">
        <div class="col-lg-12 margin-tb">
          <div class="pull-left">
            <h2>Labs <i class="fas fa-vials"></i></h2>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12 margin-tb">
          <div class="pull-left mb-2">
            <a class="btn btn-success" href="{{ route('lab.create') }}"> Add Labwork</a>
          </div>
          <div class="pull-right mb-2">
            <a id="popupHelp" class="btn btn-primary"> Help <i class="fas fa-info"></i></a>
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
              <th>Test Date</th>
              <th>Component</th>
              <th>Value</th>
              <th>Good Range</th>
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

    $('#popupHelp').on('click', function () {
      Swal.fire({
        title: "Labs",
        html: `
        <h4>You can <b>click</b> on the
        <a autofocus>Eyeglass icon</a>
        to see comments</h4>
      `,
        width: 600,
        icon: "info"
        });
    })
      
     $(document).ready( function () {
      $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      
      var table = $('#datatable-crud').DataTable({
      

           processing: true,
           serverSide: true,
           pageLength: 25,
           
           dom: '<Blf<t>ip>', /* Buttons, Length and filter above, information and pagination below table: */
            buttons: [
             
              {
                  extend: 'copy',
                  exportOptions: {
                      columns: [ 0, 1, 2, 3, 4] //Your Column value those you want
                  }
              },
              {
                  extend: 'csv',
                  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4] //Your Column value those you want
                  }
              },
              {
                  extend: 'excel',
                  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4] //Your Column value those you want
                  }
              },
              {
                  extend: 'pdf',
                  title: "Labwork",
                  messageTop: function() {
                    var fullNameCol = $('#datatable-crud').dataTable().api().cell(0, 7).data();
                    var birthDateCol = $('#datatable-crud').dataTable().api().cell(0, 8).data();
                    
                    return "Patient: " + fullNameCol + " , D-O-B: " + birthDateCol;
                  },
                  exportOptions: {
                    columns: [  0, 1, 2, 3, 4] //Your Column value those you want
                  }
              },
              {
                  extend: 'print',
                  title: "Labwork",
                  messageBottom: function() {
                    var fullNameCol = $('#datatable-crud').dataTable().api().cell(0, 7).data();
                    var birthDateCol = $('#datatable-crud').dataTable().api().cell(0, 8).data();
                    
                    return "Patient: " + fullNameCol + " , D-O-B: " + birthDateCol;
                  },
                  exportOptions: {
                    columns: [  0, 1, 2, 3, 4] //Your Column value those you want
                  }
              },
             
            ],
            
           ajax: "{{ url('lab') }}",
           columns: [
                                        
              { data: 'testDate', name: 'testDate' },
              { data: 'component', name: 'component'},      
              { data: 'measuredValue', name: 'measuredValue' },
              { data: 'goodRange', name: 'goodRange'},  
              { data: 'comments', name: 'comments'},  
              { data: 'clickme', name: 'clickme',  "className": "comments-class", orderable: false},
              { data: 'action', name: 'action', orderable: false},
              { data: 'fullName', name: 'fullName', orderable: false},
              { data: 'birthDate', name: 'birthDate', orderable: false},
            ],
           rowCallback: function( row, data ) {
                       
                        if (data.comments && data.comments.includes("abnormal")) {  
                          $("td:eq(4)", row).css('color','red','font-weight','bold')     
                        }
                        else 
                        {
                          $("td:eq(4)", row).css('color','green','font-weight','bold')
                        }
                      },
                    
            columnDefs: [
                  
                    { "targets": 0, "width":"10%"},
                    { "targets": 1, "width":"30%"},
                    { "targets": 2, "width":"5%", orderable: false},
                    { "targets": 3, "width":"20%", orderable: false},
                    { "targets": 5, "width":"5%",
                      "render": function (data, type, col, meta) {
                        // data is null
                        return type === 'display'? '<center>  <i class="fa fa-glasses center"></i> </center>' : data;
                      }     
                    },
                    { "targets": 4, "visible":false} ,
                    { "targets": 7, "visible":false},   
                    { "targets": 8, "visible":false}    
                    
                  ],
          order: [[0, 'desc'], [1, 'asc']]              
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
            url:"/lab/" + row_id,
         
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