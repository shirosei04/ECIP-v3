<div class="modal fade" id="editAwardModal{{$award->award_id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Award</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Edit Award Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('edit-award/'.$award->award_id)}}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Award Name</label>
                                <input type="text" class="form-control" name="award_name" value="{{$award->award_name}}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Award Description</label>
                                <input type="text" class="form-control" name="award_desc" value="{{$award->award_desc}}" required>
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
               