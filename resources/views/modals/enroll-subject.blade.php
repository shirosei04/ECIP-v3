<div class="modal fade" id="addNewSubjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">New Schedule</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Schedule Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('enroll-new-sub') }}" >
                            @csrf
                            <div class="row ">
                                <div class="mb-3 ">
                                    <input type="hidden" name="student_id" value="{{$stud->id}}">
                                    <label class="form-label fw-bold">Subject</label>
                                    <select class="form-select" aria-label="Default select example" name="sched_id" required>
                                        <option value="" selected>Choose Subject</option>
                                        @foreach ($schedules as $sub)
                                        <option value="{{$sub->sched_id}}">{{$sub->subject_name}}</option>
                                        @endforeach
                                    </select>
                                      @if($errors->has('days'))
                                      <span class="text-danger">{{ $errors->first('days') }}</span>
                                  @endif
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
