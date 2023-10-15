<div class="modal fade" id="addAwardModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Add Award</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                            <h5>New Award</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('save-award')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" placeholder="Award Name" name="award_name" required>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" placeholder="Award Description" name="award_desc" required>
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
