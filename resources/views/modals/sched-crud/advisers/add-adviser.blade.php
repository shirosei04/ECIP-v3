<div class="modal fade" id="addAdviserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Assign Class Adviser</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Class Adviser Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('save-adviser')}}">
                            @csrf
                            <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">Teacher</label>
                                        <select class="form-select" aria-label="Default select example" name="teacher_id" required>
                                            <option value="" selected>Choose Teacher</option>
                                            @foreach ($teachers as $teacher)
                                            <option value="{{$teacher->id}}">{{$teacher->first_name . " " . $teacher->middle_name . " " . $teacher->last_name . " " . $teacher->suffix}}</option>
                                            @endforeach
                                        </select>
                                    </div>
        
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">School Year</label>
                                        <select class="form-select" aria-label="Default select example" name="tyear_id" required>
                                            <option value="" selected>Choose School Year</option>
                                            @foreach ($years as $year)
                                            <option value="{{$year->sy_id}}">{{$year->school_year}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">Section</label>
                                        <select class="form-select" aria-label="Default select example" name="tsection_id" required>
                                            <option value="" selected>Choose Section</option>
                                            @foreach ($sections as $section)
                                            <option value="{{$section->section_id}}">{{$section->section_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success"><span class="btn-label"><i class="fas fa-save"></i></span> Assign</button>
        </div>
        </div>
      </div>
    </div>
</form>
