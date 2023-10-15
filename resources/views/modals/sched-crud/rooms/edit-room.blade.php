<div class="modal fade" id="editRoomModal{{$room->room_id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Room</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Edit Room Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('edit-room/'.$room->room_id)}}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Room Number</label>
                                <input type="text" class="form-control" name="room_number" value="{{$room->room_number}}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Room Type</label>
                                <select class="form-select" name="room_type" required>
                                    <option value="" selected>Choose Type</option>
                                    <option value="Laboratory Room" {{ ($room->room_type=="Laboratory Room")? "selected" : "" }}>Laboratory Room</option>
                                    <option value="Lecture Room" {{ ($room->room_type=="Lecture Room")? "selected" : "" }}>Lecture Room</option>
                                </select>
                            </div>
            </div>
        </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-warning"><span class="btn-label"><i class="fas fa-edit"></i></span> Save</button>
      </div>
    </div>
  </div>
</div>
</form>
               