{{-- <div class="modal fade" id="giveAwardModal{{$student->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Give Award</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                            <h5>Select Award to Give</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('give-award')}}">
                            @csrf
                                <div class="col">
                                  <input type="hidden" name="id" value="{{$student->id}}">
                                  <input type="hidden" name="grade_lvl" value="{{$student->student->grade_lvl}}">
                                  <input type="hidden" name="date_awarded" value="{{now()->toDateTimeString()}}">
                                    <label class="form-label">Award</label>
                                    <select class="form-select" aria-label="Awards" name="award" required>
                                        <option value="" selected>Choose Award</option>
                                          @foreach ($awards as $award)
                                          <option value="{{$award->award_id}}">{{$award->award_name}}</option>
                                          @endforeach
                            </div>
                    </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success"><span class="btn-label"><i class="fas fa-save"></i></span> Save</button>
          </div>
        </div>
      </div>
    </div>
</form> --}}
<div class="modal fade" id="giveAwardModal{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Give Award</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="container">
              <div class="card mt-4">
                  <div class="card-header">
                      <h5>Select Award to Give</h5>
                  </div>
                  <div class="card-body">
                      <form method="POST" action="{{url('give-award')}}">
                        @csrf
                        <div class="col">
                          <input type="hidden" name="id" value="{{$user->id}}">
                          <input type="hidden" name="grade_lvl" value="{{$user->student->grade_lvl}}">
                          <input type="hidden" name="date_awarded" value="{{now()->toDateTimeString()}}">
                            <label class="form-label">Award</label>
                            <select class="form-select" aria-label="Awards" name="award" required>
                                <option value="" selected>Choose Award</option>
                                  @foreach ($awards as $award)
                                  <option value="{{$award->award_id}}">{{$award->award_name}}</option>
                                  @endforeach
                            </select>
                        </div>
                      
                          
          </div>
      </div>
  
  <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-warning"><span class="btn-label"><i class="fas fa-edit"></i></span> Award</button>
    </div>
  </div>
</div>
</div>
</form>
             