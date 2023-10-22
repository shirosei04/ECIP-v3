<div class="modal fade" id="studentDetailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Add Your Student Information</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container align-items-left">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Student Information Form</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('addProfileDetail')}}" id="studentDetailForm">
                             @csrf
                            <h6>Student Information</h6>
                           <div class="row">
                            <input type="hidden" value="{{Auth::user()->id}} " name="user_id">
                            <div class="col-md-4">
                                <label class="form-label">LRN</label>
                                <input type="number" class="form-control" value="" name="lrn" required>
                                @if($errors->has('lrn'))
                                <span class="text-danger">{{ $errors->first('lrn') }}</span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Grade Level</label>
                                <select class="form-select" aria-label="Default select example" name="grade_lvl">
                                    <option selected>Choose Grade Level</option>
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
                            <div class="col-md-4">
                                <label for="" class="form-check-label">Do you have an available guardian for remote learning?</label>
                                <div class="row"> 
                                    <div class="col-md-6">
                                        <input class="form-check-input" type="radio" name="hgfrl" id="inlineRadio4" value="1">
                                        <label class="form-check-label" for="inlineRadio4">Yes</label>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-6">
                                        <input class="form-check-input" type="radio" name="hgfrl" id="inlineRadio4" value="0">
                                        <label class="form-check-label" for="inlineRadio4">No</label>
                                    </div>
                                </div>
                            </div>
                       </div>
                            <hr>
                            <h6>Past School Information</h6>
                            <div class="alert alert-warning justify-content-center" role="alert">
                             FOR TRANSFEREES ONLY: <em>If the last attended school is not Educare College Inc.</em>
                              </div>
                           <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Past School</label>
                                    <input type="text" class="form-control" value="" name="past_school">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Past School Address</label>
                                    <input type="text" class="form-control" value="" name="past_school_add">
                                    <div id="cellHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> Province/City/Barangay</div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Past School ID</label>
                                    <input type="text" class="form-control" value="" name="past_school_id">
                                </div>
                            </div>
                            <hr>
                            <h6>Health Information</h6>
                            <div class="row">
                                <div class="col-md-4">
                                        <label for="" class="form-check-label">Do you have comorbidity?</label>
                                        <div class="row"> 
                                            <div class="col-md-3">
                                                <input class="form-check-input" type="radio" name="has_comorbidity" id="inlineRadio7" value="1">
                                                <label class="form-check-label" for="inlineRadio7">Yes</label>
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            <div class="col-md-3">
                                                <input class="form-check-input" type="radio" name="has_comorbidity" id="inlineRadio7" value="0">
                                                <label class="form-check-label" for="inlineRadio7">No</label>
                                            </div>
                                            <label for=""></label>
                                            <input id="" type="text" class="form-control mt-1 mb-3 comorbidity" name="illnesses" value="" placeholder="If yes, please specify">
                                        </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="" class="form-check-label">{{ __('Vaccination Status') }}</label>
                                    <div class="row">
                                        <div class="">
                                            <input class="form-check-input" type="radio" name="vaccine_status" id="inlineRadio6" value="Unvaccinated">
                                            <label class="form-check-label" for="inlineRadio6">Unvaccinated</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="">
                                            <input class="form-check-input" type="radio" name="vaccine_status" id="inlineRadio6" value="Partial">
                                            <label class="form-check-label" for="inlineRadio6">Partial</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="">
                                            <input class="form-check-input" type="radio" name="vaccine_status" id="inlineRadio6" value="Full">
                                            <label class="form-check-label" for="inlineRadio6">Full</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="">
                                            <input class="form-check-input" type="radio" name="vaccine_status" id="inlineRadio6" value="Boosted">
                                            <label class="form-check-label" for="inlineRadio6">Boosted</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="" class="col-12 form-check-label text-start">{{ __('How do you go to school?') }}</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input class="form-check-input" type="radio" name="mogts" id="inlineRadio3" value="Walking">
                                            <label class="form-check-label" for="inlineRadio3">Walking</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input class="form-check-input" type="radio" name="mogts" id="inlineRadio3" value="Personal Vehicle">
                                            <label class="form-check-label" for="inlineRadio3">Personal Vehicle</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input class="form-check-input" type="radio" name="mogts" id="inlineRadio3" value="Public Utility Vehicle (PUV)">
                                            <label class="form-check-label" for="inlineRadio3">Public Utility Vehicle (PUV)</label>
                                        </div>
                                    </div>

                                 
                                </div>
                            </div>
                            <hr>
                            <h6>Extra Information</h6>
                            <div class="row">
                               <div class="col-md-6">
                                    <label for="" class="col-12 form-check-label text-start">{{ __('Are you a 4Ps Beneficiary?') }}</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input class="form-check-input" type="radio" name="is_4ps_member" id="inlineRadio1" value="1">
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input class="form-check-input" type="radio" name="is_4ps_member" id="inlineRadio1" value="0">
                                            <label class="form-check-label" for="inlineRadio1">No</label>
                                        </div>
                                    </div>
                               </div>
                               <div class="col-md-6">
                                <label for="" class="col-12 form-check-label text-start">{{ __('Enrolled in Madrasah? (For Muslims ONLY)') }}</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-check-input" type="radio" name="is_madrasah_enrolled" id="inlineRadio2" value="1">
                                        <label class="form-check-label" for="inlineRadio2">Yes</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-check-input" type="radio" name="is_madrasah_enrolled" id="inlineRadio2" value="0">
                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>
                                </div>
                           </div>
                            </div>
                            <hr>
                            <h6>Parent/Guardian Information</h6>
                            <div id="parentDiv">
                                <div>
                                    <button type="button" class="btn btn-primary mt-2 addParentBtn">Add Another Parent/Guardian</button>
                                    <div class="row">
                                        <input type="hidden" class="form-control" value={{Auth::user()->id}} name="inputs[0][id]">
                                        <div class="col-md-3">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('First Name') }}</label>
                                            <input id="" type="text" class="form-control" name="inputs[0][first_name]"  >
                                        </div>
            
                                        <div class="col-md-2">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('Middle Name') }}</label>
                                            <input id="" type="text" class="form-control" name="inputs[0][middle_name]" value=""  >
                                        </div>
            
                                        <div class="col-md-3">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('Last Name') }}</label>
                                            <input id="" type="text" class="form-control" name="inputs[0][last_name]" value=""  >
                                            <div id="cellHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> If mother, put maiden name</div>
                                        </div>

                                        <div class="col-md-1">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('Suffix') }}</label>
                                            <input id="" type="text" class="form-control" name="inputs[0][suffix]" value=""  >
                                        </div>

                                        <div class="col-md-3">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('Relationship') }}</label>
                                            {{-- <input id="" type="text" class="form-control" name="inputs[0][relationship]" value=""  > --}}
                                            <select class="form-select" aria-label="Default select example" name="inputs[0][relationship]" >
                                                <option value="" selected>Choose Relationship</option>
                                                <option value="Mother">Mother</option>
                                                <option value="Father">Father</option>
                                                <option value="Guardian">Guardian</option>
                                            </select>
                                        </div>
                                    </div>
            
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('Occupation') }}</label>
                                            <input id="" type="text" class="form-control" name="inputs[0][occupation]" value="">
                                        </div>
            
                                        <div class="col-md-3">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('Contact Number') }}</label>
                                            <input id="" type="text" class="form-control" name="inputs[0][contact_no]" value="" maxLength="11">
                                        </div>
            
                                        <div class="col-md-3">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('Email Address') }}</label>
                                            <input id="memail" type="email" class="form-control" name="inputs[0][email]" value=""  >
                                        </div>
            
                                        <div class="col-md-3">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('Facebook Account') }}</label>
                                            <input id="" type="text" class="form-control" name="inputs[0][fb_account]" value="" >
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                    </div>

                    {{-- <div class="card-body">
                            <form method="POST" action="{{url('addProfileDetail')}}" id="studentDetailForm">
                            @csrf 
                            
                    </div> --}}
                </div>

               
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success addBtn" id="addBtn"><span class="btn-label"><i class="fas fa-plus"></i></span> Add</button>
          </div>
        </div>
      </div>
    </div>
</form>
