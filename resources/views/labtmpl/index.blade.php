<!-- create.blade.php -->
@extends('layouts.app')
@section('content') 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>My Health - Lab Templates</title>       
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
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <body>
  
    <div class="container mt-2">
  
      <div class="row">
        <div class="col-lg-12 margin-tb">
          <div class="pull-left">
            <h2>Lab Templates</h2>
          </div>
          <div class="pull-right mb-2">
            <a class="btn btn-success" href="{{ route('labtmpl.create') }}"> Add Template</a>
          </div>
        </div>
      </div>
        
      @if ($message = Session::get('success'))
          <div class="alert alert-success">
              <p>{{ $message }}</p>
          </div>
      @endif
       
      <div class="card-body">
      <div class="container">
          <input type="checkbox" id='select-all'>Select All
          <br>
          <button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-xs" title = "Delete selected lab templates">Delete</button>
          <button type="button" name="bulk_add" id="bulk_add" class="btn btn-success btn-xs" title="Add selected templates to Lab table">Add</button>
          <button type="button" name="mod_date" id="mod_date" class="btn btn-primary btn-xs" title="Override selected dates">Overide Date</button>
      
        <table style=width:100% class="row-border table" id="datatable-crud">
          <thead style=color:red>
            <tr>
              <th></th>
              <th>Name</th>
              <th>Test Date</th>
              <th>Component</th>
              <th>Measured Value</th>
              <th>Good Range</th>
              <th>Comments</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>

      </div>

      <div id="moddateModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h2 class="modal-title">Override Date</h2>
                  </div>
                  <div class="modal-body">
                    <input name="newDate" id="newDate" type="date" class="form-control" required /> 
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
           pageLength: 25,
          
           dom: '<f<t>lip>', /*  filter above, Length, information and pagination below table: */
                       
           ajax: "{{ url('labtmpl') }}",
           columns: [
            {data: null,
           defaultContent: '<input type="checkbox" name="chkbx">',
          },  
                    { data: 'tmplName', name: 'tmplName'},
                    { data: 'testDate', name: 'testDate' },
                    { data: 'component', name: 'component' },
                    { data: 'measuredValue', name: 'measuredValue' },
                    { data: 'goodRange', name: 'goodRange' },
                    { data: 'comments', name: 'comments' },
                    { data: 'action', name: 'action', orderable: false},
                 ],

                 columnDefs: [
                    
                    { 'targets': 0,
                      'width':"2%",
                      'className': "dt-body-center"
                    },
                    { "targets": 1, "width":"10%",
                    }, 
                    { "targets": 2, "width":"10%",
                    }, 
                    { "targets": 3, "width":"10%",
                    }, 
                    { "targets": 4, "width":"7%",
                    }, 
                    { "targets": 5, "width":"7%",
                    },
                    { "targets": 7, "width":"5%",
                    }, 
                  ],
                  'select': {
                   'style': 'multi'
                    },
                 order: [[1, 'asc']]
              
      });

    var table = $('#datatable-crud').DataTable() ; 
   
    // from https://live.datatables.net/mutavegi/5/edit
      
    $('#select-all').on('change', function () {
        var checked = $(this).prop('checked');
        
        table.cells(null, ).every( function () {
        var cell = this.node();
        $(cell).find('input[type="checkbox"][name="chkbx"]').prop('checked', checked); 
        } );
    });

    // end https://live.datatables.net/mutavegi/5/edit

    $('#datatable-crud').on('click', 'tr', function() {
    table.row(this).nodes().to$().addClass('larger-font')
    }) ;     
    
    //bulk delete
    $(document).on('click', '#bulk_delete', function(){
        var id = [];
       
        var rdata = table
            .rows( function ( idx, data, node ) {
                return $(node).find('input[type="checkbox"][name="chkbx"]').prop('checked');
            } )
            .data()
            .toArray();
           // console.log(rdata);
         
          //swal
          swal({
            title: 'Are you sure?',
            text: "You will permanently delete the selected templates",
            icon: 'warning',
            button: "Yes, Delete it!",
            dangerMode: true,

            }).then((result) => {
                if (result) {
                    rdata.forEach(item => {
                 //   console.log('item id=',item.id);
                    id.push(item.id);
                });
            
                if(id.length > 0)
                {
                    $.ajax({
                        url:"{{ route('labdelall')}}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        method:"get",
                    
                        data:{id:id},
                        success:function(data)
                        {
                    //    console.log('ajax success:',data); // record deleted
                        swal("Success", "Lab Template(s) Deleted!", "success");
                        window.location.assign("labtmpl"); 
                        },
                        error: function(data) {
                            var errors = data.responseJSON;
                            console.log('ajax failed:',errors);
                            swal("Ajax", "see console log", "error");
                        }
                    });
                }
                else
                {
                    swal("Please select at least one checkbox");
                }
                    
                } else {
                    swal("Template(s) unchanged!");
                }// result.value
            }); //then
          //end swal      
    });

    // bulk-add
    $(document).on('click', '#bulk_add', function(){
        var id = [];
       
        var rdata = table
            .rows( function ( idx, data, node ) {
                return $(node).find('input[type="checkbox"][name="chkbx"]').prop('checked');
            } )
            .data()
            .toArray();
           // console.log(rdata);
         
          //swal
          swal({
            title: 'Are you sure?',
            text: "You will Add the selected templates to the Lab database",
            icon: 'warning',
            button: "Yes, Proceed!",
           
            }).then((result) => {
                if (result) {
                    rdata.forEach(item => {
                 //   console.log('item id=',item.id);
                    id.push(item.id);
                });
            
                if(id.length > 0)
                {
                    $.ajax({
                        url:"{{ route('labaddall')}}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        method:"get",
                    
                        data:{id:id},
                        success:function(data)
                        {
                    //    console.log('ajax success:',data); // record deleted
                        swal("Success", "Lab Template(s) Added!", "success");
                        window.location.assign("lab"); 
                        },
                        error: function(data) {
                            var errors = data.responseJSON;
                            console.log('ajax failed:',errors);
                            swal("Ajax", "see console log", "error");
                        }
                    });
                }
                else
                {
                    swal("Please select at least one checkbox");
                }
                    
                } else {
                    swal("Template(s) Not Added!");
                }// result.value
            }); //then
          //end swal      
    });

     // mod_date
     $(document).on('click', '#mod_date', function(){
        var id = [];
        $('#moddateModal').modal('show');
        $('#ok_button').click(function(){
          $('#moddateModal').modal('hide');
          var nDate = $('#newDate').val();
          var rdata = table
              .rows( function ( idx, data, node ) {
                  return $(node).find('input[type="checkbox"][name="chkbx"]').prop('checked');
              } )
              .data()
              .toArray();
              //console.log(rdata, nDate);
          
            //swal
            swal({
              title: 'Are you sure?',
              text: "You will modify the dates of the selected templates",
              icon: 'warning',
              button: "Yes, Proceed!",
            
              }).then((result) => {
                  if (result) {
                      rdata.forEach(item => {
                      //console.log('item id=',item.id);
                      id.push(item.id);
                  });
              
                  if(id.length > 0)
                  {
                      $.ajax({
                          url:"{{ route('labtmplmoddate')}}",
                          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                          method:"get",
                      
                          data:{id:id, nDate:nDate},
                          success:function(data)
                          {
                          //console.log('ajax success:',data); 
                          swal("Success", "Lab Template(s) Date Override!", "success");
                          window.location.assign("labtmpl"); 
                          },
                          error: function(data) {
                              var errors = data.responseJSON;
                              console.log('ajax failed:',errors);
                              swal("Ajax", "see console log", "error");
                          }
                      });
                  }
                  else
                  {
                      swal("Please select at least one checkbox");
                  }
                      
                  } else {
                      swal("No Date Override!");
                  }// result.value
              }); //then
            //end swal      
      });
    });

});

  

</script>
</html>  

@endsection