<div class="modal fade" id="transferModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                        <form method="POST" action="{{url('transfer-section')}}" id="transferForm">
                            @csrf
                            <div class="row ">
                                <div class="mb-3 ">
                                    <input type="hidden" name="student_id" value="{{$stud->id}}">
                                    <label class="form-label fw-bold">Sections</label>
                                    <select class="form-select" aria-label="Default select example" name="section_id" required>
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
            <button type="submit" class="btn btn-success transferBtn"><span class="btn-label"><i class="fas fa-save"></i></span> Transfer</button>
        </div>
        </div>
      </div>
    </div>
</form>
