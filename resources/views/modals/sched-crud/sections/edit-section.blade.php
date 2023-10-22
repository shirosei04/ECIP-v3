<div class="modal fade" id="editSectionModal{{$section->section_id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Section</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Edit Section Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('edit-section/'.$section->section_id)}}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">For Grade Level</label>
                                    <select class="form-select" name="section_grade_lvl">
                                        <option selected>Choose Grade Level</option>
                                        <option value="0" {{ ($section->section_grade_lvl=="0")? "selected" : "" }}>Kinder</option>
                                        <option value="1" {{ ($section->section_grade_lvl=="1")? "selected" : "" }}>Grade 1</option>
                                        <option value="2" {{ ($section->section_grade_lvl=="2")? "selected" : "" }}>Grade 2</option>
                                        <option value="3" {{ ($section->section_grade_lvl=="3")? "selected" : "" }}>Grade 3</option>
                                        <option value="4" {{ ($section->section_grade_lvl=="4")? "selected" : "" }}>Grade 4</option>
                                        <option value="5" {{ ($section->section_grade_lvl=="5")? "selected" : "" }}>Grade 5</option>
                                        <option value="6" {{ ($section->section_grade_lvl=="6")? "selected" : "" }}>Grade 6</option>
                                        <option value="7" {{ ($section->section_grade_lvl=="7")? "selected" : "" }}>Grade 7</option>
                                        <option value="8" {{ ($section->section_grade_lvl=="8")? "selected" : "" }}>Grade 8</option>
                                        <option value="9" {{ ($section->section_grade_lvl=="9")? "selected" : "" }}>Grade 9</option>
                                        <option value="10" {{ ($section->section_grade_lvl=="10")? "selected" : "" }}>Grade 10</option>
                                        <option value="11" {{ ($section->section_grade_lvl=="11")? "selected" : "" }}>Grade 11</option>
                                        <option value="12" {{ ($section->section_grade_lvl=="12")? "selected" : "" }}>Grade 12</option>
                                    </select>
                                </div>
                               
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Section Name</label>
                                    <input type="float" class="form-control" name="section_name" value="{{ $section->section_name }}">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Capacity</label>
                                    <input type="number" class="form-control" name="capacity" value="{{ $section->capacity }}">
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
               