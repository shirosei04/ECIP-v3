<div class="modal fade" id="parentDetailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Add Your Parent/Guardian Information</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container align-items-left">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Parent/Guardian Information</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            @csrf

                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start">{{ __('First Name') }}</label>
                                    <input id="" type="text" class="form-control" name="" value=""  >
                                </div>
    
                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start">{{ __('Middle Name') }}</label>
                                    <input id="" type="text" class="form-control" name="" value=""  >
                                </div>
    
                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start">{{ __('Last Name') }}</label>
                                    <input id="" type="text" class="form-control" name="" value=""  >
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start">{{ __('Relationship') }}</label>
                                    <input id="" type="text" class="form-control" name="" value=""  >
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start">{{ __('Occupation') }}</label>
                                    <input id="" type="text" class="form-control" name="" value="">
                                </div>
    
                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start">{{ __('Contact Number') }}</label>
                                    <input id="" type="text" class="form-control" name="" value=""  >
                                </div>
    
                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start">{{ __('Email Address') }}</label>
                                    <input id="memail" type="text" class="form-control" name="" value=""  >
                                </div>
    
                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start">{{ __('Facebook Account') }}</label>
                                    <input id="" type="text" class="form-control" name="" value="" >
                                </div>
                            </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary mt-2 float-end">Add Another Parent/Guardian</button>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success"><span class="btn-label"><i class="fas fa-plus"></i></span> Add</button>
          </div>
        </div>
      </div>
    </div>
</form>
