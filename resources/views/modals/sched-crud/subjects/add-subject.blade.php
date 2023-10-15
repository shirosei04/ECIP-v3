<div class="modal fade" id="addSubjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">New Subject</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Subject Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('save-subject')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Subject Name</label>
                                    <input type="float" class="form-control" name="subject_name" required>
                                    
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Curriculum</label>
                                    <select class="form-select" name="curriculumId" required>
                                        <option value="" selected>Choose Curriculum</option>
                                        @foreach($curriculums as $curriculum)
                                        <option value="{{$curriculum->curriculum_id}}">{{$curriculum->curriculum}}</option>
                                        @endforeach
                                    </select>
                                </div>
             

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">For Grade Level</label>
                                    <select class="form-select" name="subject_grade_lvl" required>
                                        <option value=""  selected>Choose Grade Level</option>
                                        <option value="Kinder">Kinder</option>
                                        <option value="Grade 1">Grade 1</option>
                                        <option value="Grade 2">Grade 2</option>
                                        <option value="Grade 3">Grade 3</option>
                                        <option value="Grade 4">Grade 4</option>
                                        <option value="Grade 5">Grade 5</option>
                                        <option value="Grade 6">Grade 6</option>
                                        <option value="Grade 7">Grade 7</option>
                                        <option value="Grade 8">Grade 8</option>
                                        <option value="Grade 9">Grade 9</option>
                                        <option value="Grade 10">Grade 10</option>
                                        <option value="Grade 11">Grade 11</option>
                                        <option value="Grade 12">Grade 12</option>
                                    </select>
                                </div>
                               
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Track</label>
                                    <select class="form-select" name="track" required>
                                        <option value="" selected>Choose Track</option>
                                        <option value="ABM">ABM</option>
                                        <option value="GAS">GAS</option>
                                        <option value="HUMSS">HUMSS</option>
                                        <option value="STEM">STEM</option>
                                        <option value="TVL">TVL</option>
                                        <option value="General Subject(SHS)">General Subject(SHS)</option>
                                        <option value="Not Applicable">Not Applicable</option>
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
