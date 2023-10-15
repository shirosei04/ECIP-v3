<div class="modal fade" id="paymentModal{{$fee->studfee_id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Payment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Manage Payment</h5>
                        {{-- <p class="mb-0"><small>LRN: {{$fee->lrn}}</small></p>
                        <p class="mb-0"><small>Name: {{$fee->first_name . " " . $fee->middle_name . " " . $fee->last_name . " " . $fee->suffix}}</small></p>
                        <p class="mb-0"><small>SY: {{$fee->school_year}}</small></p> --}}
                        <p class="mb-0"><small>Fee ID: {{$fee->studfee_id}}</small></p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('process-assessment/'.$fee->studfee_id)}}">
                          @csrf
                          @method('PUT')
                          <div class="mb-3">
                            <label class="form-label">Transaction Description</label>
                            <input type="text" class="form-control" value="" name="description" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Transaction Type</label>
                            <select class="form-select" aria-label="Default select example" name="type" required> 
                                <option value="" selected>Choose Type</option>
                                <option value="Add">Add</option>
                                <option value="Deduct">Deduct</option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="float" class="form-control" value="" name="amount" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" value="{{  now()->toDateString('Y-m-d') }}" disabled>
                        </div>
            </div>
        </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success proceedBtn"><span class="btn-label"><i class="fas fa-edit"></i></span> Proceed</button>
      </div>
    </div>
  </div>
  </div>
  </form>