<div class="modal fade" id="editSubjectModal{{$subject->subject_id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Subject</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Edit Subject Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('edit-subject/'.$subject->subject_id)}}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Subject Name</label>
                                    <input type="float" class="form-control" value="{{$subject->subject_name}}" name="subject_name" required>
                                    
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Curriculum</label>
                                    <select class="form-select" name="curriculumId" required>
                                        <option value="" selected>Choose Curriculum</option>
                                        @foreach($curriculums as $curriculum)
                                        <option value="{{$curriculum->curriculum_id}}" {{ ($subject->curriculumId == $curriculum->curriculum_id)? "selected" : "" }}>{{$curriculum->curriculum}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">For Grade Level</label>
                                    <select class="form-select" name="subject_grade_lvl" required> 
                                        <option value="" selected>Choose Grade Level</option>
                                        <option value="Kinder" {{ ($subject->subject_grade_lvl=="Kinder")? "selected" : "" }}>Kinder</option>
                                        <option value="Grade 1" {{ ($subject->subject_grade_lvl=="Grade 1")? "selected" : "" }}>Grade 1</option>
                                        <option value="Grade 2" {{ ($subject->subject_grade_lvl=="Grade 2")? "selected" : "" }}>Grade 2</option>
                                        <option value="Grade 3" {{ ($subject->subject_grade_lvl=="Grade 3")? "selected" : "" }}>Grade 3</option>
                                        <option value="Grade 4" {{ ($subject->subject_grade_lvl=="Grade 4")? "selected" : "" }}>Grade 4</option>
                                        <option value="Grade 5" {{ ($subject->subject_grade_lvl=="Grade 5")? "selected" : "" }}>Grade 5</option>
                                        <option value="Grade 6" {{ ($subject->subject_grade_lvl=="Grade 6")? "selected" : "" }}>Grade 6</option>
                                        <option value="Grade 7" {{ ($subject->subject_grade_lvl=="Grade 7")? "selected" : "" }}>Grade 7</option>
                                        <option value="Grade 8" {{ ($subject->subject_grade_lvl=="Grade 8")? "selected" : "" }}>Grade 8</option>
                                        <option value="Grade 9" {{ ($subject->subject_grade_lvl=="Grade 9")? "selected" : "" }}>Grade 9</option>
                                        <option value="Grade 10" {{ ($subject->subject_grade_lvl=="Grade 10")? "selected" : "" }}>Grade 10</option>
                                        <option value="Grade 11" {{ ($subject->subject_grade_lvl=="Grade 11")? "selected" : "" }}>Grade 11</option>
                                        <option value="Grade 12" {{ ($subject->subject_grade_lvl=="Grade 12")? "selected" : "" }}>Grade 12</option>
                                    </select>
                                </div>
                               
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Track</label>
                                    <select class="form-select" name="track" required>
                                        <option value="" selected>Choose Track</option>
                                        <option value="ABM" {{ ($subject->track=="ABM")? "selected" : "" }}>ABM</option>
                                        <option value="GAS" {{ ($subject->track=="GAS")? "selected" : "" }}>GAS</option>
                                        <option value="STEM" {{ ($subject->track=="STEM")? "selected" : "" }}>STEM</option>
                                        <option value="HUMSS" {{ ($subject->track=="HUMSS")? "selected" : "" }}>HUMSS</option>
                                        <option value="TVL" {{ ($subject->track=="TVL")? "selected" : "" }}>TVL</option>
                                        <option value="General Subject(SHS)" {{ ($subject->track=="General Subject(SHS)")? "selected" : "" }}>General Subject(SHS)</option>
                                        <option value="Not Applicable" {{ ($subject->track=="Not Applicable")? "selected" : "" }}>Not Applicable</option>
                                    </select>
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
               