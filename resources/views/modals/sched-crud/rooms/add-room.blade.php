<div class="modal fade" id="addRoomModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Add Room</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                            <h5>New Room</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('save-room')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" placeholder="Room Number" name="room_number" required>
                                    @if($errors->has('room_number'))
                                    <span class="text-danger">{{ $errors->first('room_number') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-7">
                                    <select class="form-select" name="room_type" required>
                                        <option value="" selected>Choose Type</option>
                                        <option value="Laboratory Room">Laboratory Room</option>
                                        <option value="Lecture Room">Lecture Room</option>
                                    </select>
                                 
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success"><span class="btn-label"><i class="fas fa-save"></i></span> Save</button>
          </div>
        </div>
      </div>
    </div>
</form>
