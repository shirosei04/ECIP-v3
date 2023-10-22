<div class="modal fade" id="addSectionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Add Section</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                            <h5>New Section</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('save-section')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">For Grade Level</label>
                                    <select class="form-select" name="section_grade_lvl" required>
                                        <option value="" selected>Choose Grade Level</option>
                                        <option value="0">Kinder</option>
                                        <option value="1">Grade 1</option>
                                        <option value="2">Grade 2</option>
                                        <option value="3">Grade 3</option>
                                        <option value="4">Grade 4</option>
                                        <option value="5">Grade 5</option>
                                        <option value="6">Grade 6</option>
                                        <option value="7">Grade 7</option>
                                        <option value="8">Grade 8</option>
                                        <option value="9">Grade 9</option>
                                        <option value="10">Grade 10</option>
                                        <option value="11">Grade 11</option>
                                        <option value="12">Grade 12</option>
                                    </select>
                                </div>
                               
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Section Name</label>
                                    <input type="float" class="form-control" name="section_name" required> 
                                    @if($errors->has('section_name'))
                                    <span class="text-danger">{{ $errors->first('section_name') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Capacity</label>
                                    <input type="number" class="form-control" name="capacity" required>
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
