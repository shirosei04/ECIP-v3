<div class="modal fade" id="editSyModal{{$year->sy_id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit School Year</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Edit School Year Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('edit-sy/'.$year->sy_id)}}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">School Year</label>
                                <input type="text" class="form-control" name="school_year" value="{{$year->school_year}}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <select class="form-select" name="type" required>
                                    <option value="" selected>Choose Type</option>
                                    <option value="Regular" {{ ($year->type=="Regular")? "selected" : "" }}>Regular</option>
                                    <option value="Summer" {{ ($year->type=="Summer")? "selected" : "" }}>Summer</option>
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
               