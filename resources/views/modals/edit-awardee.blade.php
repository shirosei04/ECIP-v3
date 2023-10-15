<div class="modal fade" id="editAwardeeModal{{$awardee->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Awardee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Edit Awardee Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('edit-awardee/'.$awardee->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <input type="hidden" name="id" value="{{$awardee->id}}">
                                <input type="hidden" name="grade_lvl" value="{{$awardee->student->grade_lvl}}">
                                <input type="hidden" name="date_awarded" value="{{now()->toDateTimeString()}}">
                                <label class="form-label">Award Name</label>
                                {{-- <option value="{{$awardee->award_name}}" selected></option> --}}
                                {{-- <input type="text" class="form-control" value="{{$awardee->award_name}}"> --}}
                                <select class="form-select" aria-label="Awards" name="award" required>
                                    <option value="{{$awardee->award_id}}" selected>{{$awardee->award_name}}</option>
                                      @foreach ($awards as $award)
                                      <option value="{{$award->award_id}}">{{$award->award_name}}</option>
                                      @endforeach
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
               