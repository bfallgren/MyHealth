            @foreach($doc as $row)

            <tr>
                <td>{{ $row->name}}</td>
                <td>{{ $row->specialty}}</td>
                <td>
                <td>
                    <!-- EDIT button -->
                <td align="left">
                <a title='Edit Doctor' data-toggle='tooltip' href="{{action('DoctorController@edit', $row->id)}}" span class='fas fa-edit'style='font-size: 18px; color:orange'></span></a></td>
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
                            <form action="{{ route('doctor.destroy', $row->id) }}" method="POST">
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

            </td>       <!-- DELETE BUTTON -->
                
            </tr> 
            @endforeach

            <tr colspan="3">
                <td   {{ $doc->appends(compact('items'))->links() }} </td>
            </tr>

      
    