@foreach($appt as $row)
    <tr> 
        
        <td>{{$row->patientName}}</td>
        <td>{{$row->apptDate}}</td>
        <td>{{$row->doctorName}}</td>
        <td>{{$row->doctorSpecialty}}</td>
        <td>${{number_format($row->fee,2)}}</td>
        
        <td width="75px" data-container="body" data-toggle="popover" data-trigger="hover" title="Reason"  data-content="{!! $row->reason !!}" span class='fas fa-glasses'></span></td>
        
        <td data-container="body" data-toggle="popover" data-trigger="hover" title="Diagnosis"  data-content="{!! $row->diagnosis !!}" span class='fas fa-glasses'></span></td>
        
        <td>{{$row->vitalsWeight}}</td>
        <td>{{$row->vitalsBP}}</td>

        
            <!-- EDIT button -->
        <td align="left"><a title='Edit Appt.' data-toggle='tooltip' href="{{action('HealthController@edit', $row->id)}}" span class='fas fa-edit'style='font-size: 18px; color:orange'></span></a></td>
        
        <!-- DELETE button -->
        <td> 
          <!-- Button trigger modal -->
            <a role="button" style="background-color:red" class="btn btn-primary btn-xs fas fa-trash-alt" data-toggle="modal" data-target="#deletemyModal">
            </a>

            <!-- Modal -->
            <div class="modal fade" id="deletemyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                  </div>
                  <div class="modal-body">
                   <h2 style="color:red">Delete Confirmation</h2>
                  </div>
                  <div class="modal-footer">
                    <form action="{{ route('myHealth.destroy', $row->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" class="btn btn-danger btn-sm" title="Delete">Delete</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

       </td>
        
    </tr>
  @endforeach

  
    <tr>
      <td colspan="3" >
      {{ $appt->appends(compact('items'))->links() }}   
      </td>
    </tr>   


  <script>
    $('[data-toggle="popover"]').popover({
              placement : 'center',
              html : true
      }) 
  </script>