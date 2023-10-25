<div class="modal fade" id="rejectModal{{$enrollee->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md rejectTarget">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Reject Message</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Reject User Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="messageForm"  action="{{ url('/view-details/reject-user/'.$enrollee->id) }}">
                            @csrf
                            <div class="mb-3">
                              <label for="exampleFormControlInput1" class="form-label">To:</label>
                              <input type="email" class="form-control" 
                               value="{{$enrollee->email}}" disabled>
                            </div>
                            <div class="mb-3">
                              <label for="exampleFormControlInput1" class="form-label">Subject</label>
                              <input type="text" class="form-control" value="Educare College Inc. Registry Verification" disabled>
                            </div>
                            <div class="mb-3">
                              <label for="exampleFormControlTextarea1" class="form-label">Message</label>
                              <textarea class="form-control message" name="message" rows="5" required></textarea>
                              @if($errors->has('message'))
                              <span class="text-danger">{{ $errors->first('message') }}</span>
                              @endif
                            </div> 
            </div>
        </div>
    <div class="modal-footer">
        <input type="hidden" class="delete_val" id="delete_val" value="{{$enrollee->id}}">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-warning sendBtn"><span class="btn-label"><i class="fas fa-edit"></i></span> Send</button>
      </div>
    </form>
    </div>
  </div>
</div>

               