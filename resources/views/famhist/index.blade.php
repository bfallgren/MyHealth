<!-- create.blade.php -->
@extends('layouts.app')
@section('content') 
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>My Health - Family History</title>
      
             
  </head>
  <body>
  
    <div class="container mt-2">
  
      <div class="row">
        <div class="col-lg-12 margin-tb">
          <div class="pull-left">
            <h2>Family History</h2>
          </div>
          <div class="pull-right mb-2">
            <a class="btn btn-success" href="{{ route('fam.create') }}"> Add Family History</a>
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
           
              <th>Family Member</th>
              <th>Relation</th>
              <th>Symptoms</th>
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
                      columns: [ 0, 1, 2, 3] //Your Column value those you want
                  }
              },
              {
                  extend: 'csv',
                  exportOptions: {
                    columns: [ 0, 1, 2, 3] //Your Column value those you want
                  }
              },
              {
                  extend: 'excel',
                  exportOptions: {
                    columns: [ 0, 1, 2, 3] //Your Column value those you want
                  }
              },
              {
                  extend: 'pdf',
                  exportOptions: {
                    columns: [ 0, 1, 2, 3] //Your Column value those you want
                  }
              },
              {
                  extend: 'print',
                  exportOptions: {
                    columns: [ 0, 1, 2, 3] //Your Column value those you want
                  }
              },
             
            ],

           ajax: "{{ url('fam') }}",
           columns: [
                   
                    { data: 'familyMember', name: 'familyMember' },
                    { data: 'relation', name: 'relation' },
                    { data: 'symptoms', name: 'symptoms', orderable: false },
                    { data: 'comments', name: 'comments', orderable: false },
                    { data: 'action', name: 'action', orderable: false},
                 ],
                 columnDefs: [
                    
                    { "targets": 0, "width":"15%"},
                    { "targets": 1, "width":"15%"},
                    { "targets": 2, "width":"25%"},
                    { "targets": 3, "width":"30%"},
                    { "targets": 4, "width":"15%"}          
                    
                  ],

         

                 order: [[0, 'asc']]
              
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
            url:"/fam/" + row_id,
         
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