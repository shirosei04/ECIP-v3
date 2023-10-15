<div class="modal fade" id="editFeeModal{{ $fee->tf_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Fee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Edit Fee Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('edit-fee/'.$fee->tf_id)}}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">For Grade Level</label>
                                    @if ($fee->for_grade_lvl == '0')
                                    <input type="hidden" name="for_grade_lvl" value="0">
                                    <input type="text" class="form-control"  value="Kinder" disabled>
                                    @else
                                    <input type="hidden" name="for_grade_lvl" name="for_grade_lvl" value="{{ $fee->for_grade_lvl }}">
                                    <input type="text" class="form-control" value="Grade {{ $fee->for_grade_lvl }}" disabled>
                                    @endif
                                  
                                </div>
                               
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tuition Fee</label>
                                    <input type="float" class="form-control" name="tuition_fee" value="{{ $fee->tuition_fee }}" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Miscellaneous Fee</label>
                                    <input type="float" class="form-control" name="misc_fee" value="{{ $fee->misc_fee }}" required>
                                </div>
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
               