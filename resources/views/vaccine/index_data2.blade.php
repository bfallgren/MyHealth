  @foreach($shot as $row)
      <tr>
         <td>{{ $row->patientName}}</td>
         <td>{{ $row->vDate}}</td>
         <td>{{ $row->vaccine}}</td>
         <td><textarea readonly type="text" rows="2" cols="15" class="form-control" name="comments">{{$row->comments}}</textarea></td>
             <!-- EDIT button -->
         <td align="left"><a title='Edit Immunization' data-toggle='tooltip' href="{{action('VaccineController@edit', $row->id)}}" span class='fas fa-edit'style='font-size: 18px; color:orange'></span></a></td>
        
        <!-- DELETE button -->
             
    </tr>
  @endforeach
     
