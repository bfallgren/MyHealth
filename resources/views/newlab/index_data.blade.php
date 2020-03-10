  @foreach($data as $row)
      <tr>
         <td>{{ $row->patientName}}</td>
         <td>{{ $row->testDate}}</td>
         <td>{{ $row->component}}</td>
         <td>{{ $row->measuredValue}}</td>
         <td>{{ $row->goodRange}}</td>
         <td><textarea readonly type="text" rows="2" cols="15" class="form-control" name="comments">{{$row->comments}}</textarea></td>
             <!-- EDIT button -->
         <td align="left"><a title='Edit Lab Test' data-toggle='tooltip' href="{{action('LabController@edit', $row->id)}}" span class='fas fa-edit'style='font-size: 18px; color:orange'></span></a></td>
        
        <!-- DELETE button -->
         <td align="left">
         <a href="{{ url('lab',$row->id) }}" class='fas fa-trash-alt'style='font-size: 18px; color:red'
           data-tr="tr_{{$row->id}}"
           title="Delete Lab Test"
           data-toggle="confirmation"
           data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-remove"
           data-btn-ok-class="btn btn-sm btn-danger"
           data-btn-cancel-label="Cancel"
           data-btn-cancel-icon="fa fa-chevron-circle-left"
           data-btn-cancel-class="btn btn-sm btn-default"
           data-title="Are you sure you want to delete ?"
           data-placement="left" data-singleton="true">
            
        </a>
      </td>       
    </tr>
  @endforeach
     
