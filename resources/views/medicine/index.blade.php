<!-- create.blade.php -->
@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>My Health - Medications</title>


  </head>
  <body>

    <div class="container mt-2">

      <div class="row">
        <div class="col-lg-12 margin-tb">
          <div class="pull-left">
            <h2>Medications</h2>
          </div>
          <div class="pull-right mb-2">
            <a class="btn btn-success" href="{{ route('meds.create') }}"> Add Medication</a>
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
              <th>Drug</th>
              <th>Dosage</th>
              <th>Freq.</th>
              <th>Status</th>
              <th>Side Affects</th>
              <th>Notes</th>
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
                      columns: [0, 1, 2, 3, 4, 5] //Your Column value those you want
                  }
              },
              {
                  extend: 'csv',
                  exportOptions: {
                    columns:  [0, 1, 2, 3, 4, 5] //Your Column value those you want
                  }
              },
              {
                  extend: 'excel',
                  exportOptions: {
                    columns:  [0, 1, 2, 3, 4, 5] //Your Column value those you want
                  }
              },
              {
                  extend: 'pdf',
                  title: "Prescriptions",
                  messageTop: function() {
                    var fullNameCol = $('#datatable-crud').dataTable().api().cell(0, 7).data();
                    var birthDateCol = $('#datatable-crud').dataTable().api().cell(0, 8).data();

                    return "Patient: " + fullNameCol + " , D-O-B: " + birthDateCol;
                  },
                  exportOptions: {
                    columns:  [0, 1, 2, 3, 4, 5] //Your Column value those you want
                  }
              },
              {
                  extend: 'print',
                  title: "Prescriptions",
                  messageBottom: function() {
                    var fullNameCol = $('#datatable-crud').dataTable().api().cell(0, 7).data();
                    var birthDateCol = $('#datatable-crud').dataTable().api().cell(0, 8).data();

                    return "Patient: " + fullNameCol + " , D-O-B: " + birthDateCol;
                  },
                  exportOptions: {
                    columns:  [0, 1, 2, 3, 4, 5] //Your Column value those you want
                  }
              },

            ],

           ajax: "{{ url('meds') }}",
           columns: [

                    { data: 'name', name: 'name'},
                    { data: 'dosage', name: 'dosage' },
                    { data: 'dailyFreq', name: 'dailyFreq'},
                    { data: 'status', name: 'status', orderable: false},
                    { data: 'sideAffects', name: 'sideAffects', orderable: false},
                    { data: 'notes', name: 'notes', orderable: false},

                    {data: 'action', name: 'action', orderable: false},
                    { data: 'fullName', name: 'fullName', orderable: false},
                    { data: 'birthDate', name: 'birthDate', orderable: false},
                 ],

                 columnDefs: [
                    { "targets": 0, "width":"10%"},
                    { "targets": 1, "width":"10%"},
                    { "targets": 2, "width":"10%"},
                    { "targets": 7, "visible":false},
                    { "targets": 8, "visible":false}
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
            url:"/meds/" + row_id,

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
