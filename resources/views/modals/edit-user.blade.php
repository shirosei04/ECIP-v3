<div class="modal fade" id="editUserModal{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Edit User Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="editUserForm" action="{{url('edit-user')}}">
                            @csrf
                            @method('PUT')
                          
                            <p class="text-center fs-5 fw-bold regDivider">BASIC INFORMATION</p>
                            <input type="hidden" value="{{$user->id}}" name="user_id">
                            <div class="row smlFont">
                                <div class="col-md-4">
                                    {{-- date of registration --}}
                                    <fieldset disabled>
                                        <label for="" class="col-6 col-form-label text-start fw-bold">{{ __('Date of Registration') }}</label>
                                        <input id="" type="text" class="form-control form-control-sm" value="{{$user->date_of_registration}}" >
                                    </fieldset>
                                </div>

                                {{-- role --}}
                                @if($user->role == 'Student')
                                <div class="col-md-4">
                                  <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Role') }}</label>
                                  <select class="form-select form-select-sm" aria-label="Default select example" name="role">
                                      <option selected>Choose Role</option>
                                      <option value="Admission Officer" {{ ($user->role=="Admission Officer")? "selected" : "" }}>Admission Officer</option>
                                      <option value="Principal" {{ ($user->role=="Principal")? "selected" : "" }}>Principal</option>
                                      <option value="Student" {{ ($user->role=="Student")? "selected" : "" }}>Student</option>
                                      <option value="Teacher" {{ ($user->role=="Teacher")? "selected" : "" }}>Teacher</option>
                                  </select>
                                </div>
                                @else
                                <div class="col-md-4">
                                    <input type="hidden" name="role" value="{{$user->role}}">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Role') }}</label>
                                    <input type="text" class="form-control form-control-sm"  value="{{$user->role}}" disabled>
                                </div>
                                @endif

                                {{-- Sex --}}
                                <div class="col-md-4">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Sex') }}</label>
                                    <input class="form-check-input" type="radio" name="sex" id="inlineRadio" value="Male" {{ ($user->sex=="Male")? "checked" : "" }}>
                                    <label class="form-check-label" for="inlineRadio" >Male</label>

                                    <input class="form-check-input" type="radio" name="sex" id="inlineRadio" value="Female" {{ ($user->sex=="Female")? "checked" : "" }}>
                                    <label class="form-check-label" for="inlineRadio">Female</label>
                                    <div class="form-text"><i class="fas fa-exclamation-circle"></i> Sex at birth</div>

                                    @if($errors->has('sex'))
                                        <span class="text-danger">{{ $errors->first('sex') }}</span>
                                    @endif

                                </div>
                            </div>
                            
                            {{-- Name --}}
                            <div class="row smlFont">
                                <div class="col-md-3">
                                    <label for="" class="col-md-6 col-form-label text-start fw-bold" >{{ __('First Name') }}</label>
                                    <input type="text" class="form-control form-control-sm" id="firstname" oninput="getValue()" name="first_name" aria-describedby="nameHelp" value="{{$user->first_name}}">
                                    @if($errors->has('first_name'))
                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-md-6 col-form-label text-start fw-bold">{{ __('Middle Name') }}</label>
                                    <input id="mname" type="text" class="form-control form-control-sm" aria-describedby="mnameHelp" name="middle_name" value="{{$user->middle_name}}" >
                                    <div id="mnameHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> If none, input dot (.)</div>
                                    @if($errors->has('middle_name'))
                                        <span class="text-danger">{{ $errors->first('middle_name') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-md-6 col-form-label text-start fw-bold" >{{ __('Family Name') }}</label>
                                    <input type="text" class="form-control form-control-sm" id="lastname" oninput="getValue()" name="last_name"  value="{{$user->last_name}}">
                                    @if($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-md-4 col-form-label text-start fw-bold">{{ __('Suffix') }}</label>
                                    <input id="lname" type="text" class="form-control form-control-sm" name="suffix" maxLength="10" aria-describedby="extensionHelp" value="{{$user->suffix}}">
                                    <div id="extensionHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> Fill out if applicable</div>
                                    @if($errors->has('suffix'))
                                        <span class="text-danger">{{ $errors->first('suffix') }}</span>
                                    @endif
                                </div>
                            </div> 

                            {{-- BIRTH DETAILS --}}
                            <div class="row mb-3 smlFont">
                                <div class="col-md-6">
                                    <label for="bdate" class="col-md-4 col-form-label text-start fw-bold">{{ __('Birth Date') }}</label>
                                    <input id="bdate" type="date" class="form-control form-control-sm" name="bdate" value="{{$user->birth_date}}" autocomplete="">
                                    @if($errors->has('bdate'))
                                        <span class="text-danger">{{ $errors->first('bdate') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label for="bplace" class="col-md-4 col-form-label text-start fw-bold">{{ __('Birth Place') }}</label>
                                    <input id="bplace" type="input" class="form-control form-control-sm" name="bplace" value="{{$user->birth_place}}" autocomplete="">
                                    @if($errors->has('bplace'))
                                        <span class="text-danger">{{ $errors->first('bplace') }}</span>
                                    @endif
                                </div>
                            </div>
                            

                            {{-- Address --}}
                            <div class="row mb-3 smlFont">
                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Region') }}</label>
                                    {{-- <select class="form-select form-select-sm" name="region" id="region"></select> --}}
                                    <input id="" type="string" class="form-control form-control-sm" name="region" value="{{$user->region}}" autocomplete="">
                                    <div id="emailHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> 1st</div>
                                    @if($errors->has('region'))
                                        <span class="text-danger">{{ $errors->first('region') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-2">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Province') }}</label>
                                    {{-- <select class="form-select form-select-sm" name="province" id="province">
                                    </select> --}}
                                    <input id="" type="string" class="form-control form-control-sm" name="province" value="{{$user->province}}" autocomplete="">
                                    <div id="emailHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> 2nd</div>
                                    @if($errors->has('province'))
                                        <span class="text-danger">{{ $errors->first('province') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-2">
                                    <label for="city" class="col-12 col-form-label text-start fw-bold">{{ __('City') }}</label>
                                    {{-- <select class="form-select form-select-sm" name="city" id="city">
                                    </select> --}}
                                    <input id="" type="string" class="form-control form-control-sm" name="city" value="{{$user->city}}" autocomplete="">
                                    <div id="emailHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> 3rd</div>
                                    @if($errors->has('city'))
                                        <span class="text-danger">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-2">
                                    <label for="city" class="col-12 col-form-label text-start fw-bold">{{ __('Barangay') }}</label>
                                    {{-- <select class="form-select form-select-sm" name="barangay" id="barangay">
                                    </select> --}}
                                    <input id="" type="string" class="form-control form-control-sm" name="barangay" value="{{$user->barangay}}"  autocomplete="">
                                    <div id="emailHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> 4th</div>
                                    @if($errors->has('barangay'))
                                        <span class="text-danger">{{ $errors->first('barangay') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('House #/Building/Street/Sitio/Purok') }}</label>
                                    <input id="building" type="text" class="form-control form-control-sm" name="street" value="{{$user->house_no}}" >
                                    @if($errors->has('street'))
                                        <span class="text-danger">{{ $errors->first('street') }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Nationality & Religion --}}
                            <div class="row smlFont">
                                <div class="col-md-3">
                                    <label for="" class="col-6 col-form-label text-start fw-bold">{{ __('Nationality') }}</label>
                                    <input id="ethnic" type="text" class="form-control form-control-sm" name="nationality" value="{{$user->nationality}}"  >
                                    @if($errors->has('nationality'))
                                        <span class="text-danger">{{ $errors->first('nationality') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Religion') }}</label>
                                    <input id="ethnic" type="text" class="form-control form-control-sm" name="religion"  value="{{$user->religion}}" >
                                    @if($errors->has('religion'))
                                        <span class="text-danger">{{ $errors->first('religion') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-6 col-form-label text-start fw-bold">{{ __('Ethnicity') }}</label>
                                    <input id="ethnic" type="text" class="form-control form-control-sm" name="ethnicity" value="{{$user->ethnicity}}"  >
                                    @if($errors->has('ethnicity'))
                                        <span class="text-danger">{{ $errors->first('ethnicity') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Mother Tongue') }}</label>
                                    <input id="mtongue" type="text" class="form-control form-control-sm" name="mother_tongue" value="{{$user->mother_tongue}}"  >
                                    <div id="cellHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> First language or dialect</div>
                                    @if($errors->has('mother_tongue'))
                                        <span class="text-danger">{{ $errors->first('mother_tongue') }}</span>
                                    @endif
                                </div>
                            </div>


                            {{-- Telephone  & CP Number --}}
                            <div class="row smlFont">
                                <div class="col-md-3">
                                    <label for="" class="col-6 col-form-label text-start fw-bold">{{ __('Telephone Number') }}</label>
                                    <input id="tpno" type="text" class="form-control form-control-sm" name="tel_no" maxLength="10"  minLength="10" aria-describedby="telHelp" value="{{$user->tel_no}}"   >
                                    <div id="telHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> If none, leave blank</div>
                                    @if($errors->has('tel_no'))
                                        <span class="text-danger">{{ $errors->first('tel_no') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Cellphone Number') }}</label>
                                    <input id="cpno" type="text" class="form-control form-control-sm" aria-describedby="cellHelp" maxLength="11"  minLength="11" name="cell_no" value="{{$user->cell_no}}"   >
                                    <div id="cellHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> If none, leave blank</div>
                                    @if($errors->has('cell_no'))
                                        <span class="text-danger">{{ $errors->first('cell_no') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-6 col-form-label text-start fw-bold">{{ __('Email Address') }}</label>
                                    <input id="email" type="email" class="form-control form-control-sm" aria-describedby="emailHelp" name="email" value="{{$user->email}}"  >
                                    <div id="emailHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> If none, leave blank</div>
                                    @if($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Facebook Account') }}</label>
                                    <input id="" type="text" class="form-control form-control-sm" name="fb_acc" aria-describedby="fbHelp"  value="{{$user->fb_acc}}"  >
                                    <div id="fbHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> If none, leave blank</div>
                                    @if($errors->has('fb_acc'))
                                        <span class="text-danger">{{ $errors->first('fb_acc') }}</span>
                                    @endif
                                </div>
                            </div>
                            @if($user->role == 'Student')
                            <p class="text-center fs-5 fw-bold regDivider">STUDENT INFORMATION</p>
                            <div class="row smlFont">
                              <div class="col-md-4">
                                <input type="hidden" name="detail_id" id="" value="{{$user->detail_id}}">
                                <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('LRN') }}</label>
                                <input type="number" class="form-control form-control-sm" value="{{$user->student->lrn}}" name="lrn" required>
                              </div>
  
                              <div class="col-md-4">
                                <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Grade Level') }}</label>
                                  <select class="form-select form-select-sm" aria-label="Default select example" name="grade_lvl">
                                      <option selected>Choose Grade Level</option>
                                      <option value="0" {{ ($user->student->grade_lvl=="0")? "selected" : "" }}>Kinder</option>
                                      <option value="1" {{ ($user->student->grade_lvl=="1")? "selected" : "" }}>Grade 1</option>
                                      <option value="2" {{ ($user->student->grade_lvl=="2")? "selected" : "" }}>Grade 2</option>
                                      <option value="3" {{ ($user->student->grade_lvl=="3")? "selected" : "" }}>Grade 3</option>
                                      <option value="4" {{ ($user->student->grade_lvl=="4")? "selected" : "" }}>Grade 4</option>
                                      <option value="5" {{ ($user->student->grade_lvl=="5")? "selected" : "" }}>Grade 5</option>
                                      <option value="6" {{ ($user->student->grade_lvl=="6")? "selected" : "" }}>Grade 6</option>
                                      <option value="7" {{ ($user->student->grade_lvl=="7")? "selected" : "" }}>Grade 7</option>
                                      <option value="8" {{ ($user->student->grade_lvl=="8")? "selected" : "" }}>Grade 8</option>
                                      <option value="9" {{ ($user->student->grade_lvl=="9")? "selected" : "" }}>Grade 9</option>
                                      <option value="10" {{ ($user->student->grade_lvl=="10")? "selected" : "" }}>Grade 10</option>
                                      <option value="11" {{ ($user->student->grade_lvl=="11")? "selected" : "" }}>Grade 11</option>
                                      <option value="12" {{ ($user->student->grade_lvl=="12")? "selected" : "" }}>Grade 12</option>
                                  </select>
                              </div>
                              <div class="col-md-4">
                                  <label for="" class="form-check-label fw-bold">Do you have an available guardian for remote learning?</label>
                                  <div class="row"> 
                                      <div class="col-md-6">
                                          <input class="form-check-input" type="radio" name="hgfrl" id="inlineRadio4" value="1" {{ ($user->student->hgfrl=="1")? "checked" : "" }}>
                                          <label class="form-check-label" for="inlineRadio4">Yes</label>
                                      </div>
                                  </div>
                                  <div class="row smlFont"> 
                                      <div class="col-md-6">
                                          <input class="form-check-input" type="radio" name="hgfrl" id="inlineRadio4" value="0" {{ ($user->student->hgfrl=="0")? "checked" : "" }}>
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
                         <div class="row smlFont">
                              <div class="col-md-4">
                                  <label class="form-label fw-bold">Past School</label>
                                  <input type="text" class="form-control form-control-sm" value="{{$user->student->past_school}}" name="past_school">
                              </div>

                              <div class="col-md-4">
                                  <label class="form-label fw-bold">Past School Address</label>
                                  <input type="text" class="form-control form-control-sm" value="{{$user->student->past_school_address}}" name="past_school_add">
                                  <div id="cellHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> Province/City/Barangay</div>
                              </div>

                              <div class="col-md-4">
                                  <label class="form-label fw-bold">Past School ID</label>
                                  <input type="text" class="form-control form-control-sm" value="{{$user->student->past_school_id}}" name="past_school_id">
                              </div>
                          </div>
                          <hr>
                          <h6>Health Information</h6>
                          <div class="row smlFont">
                              <div class="col-md-4">
                                      <label for="" class="form-check-label fw-bold">Do you have comorbidity?</label>
                                      <div class="row"> 
                                          <div class="col-md-3">
                                              <input class="form-check-input" type="radio" name="has_comorbidity" id="inlineRadio7" value="1" {{ ($user->student->has_comorbidity=="1")? "checked" : "" }} >
                                              <label class="form-check-label" for="inlineRadio7">Yes</label>
                                          </div>
                                      </div>
                                      <div class="row"> 
                                          <div class="col-md-3">
                                              <input class="form-check-input" type="radio" name="has_comorbidity" id="inlineRadio7" value="0" {{ ($user->student->has_comorbidity=="0")? "checked" : "" }}>
                                              <label class="form-check-label" for="inlineRadio7">No</label>
                                          </div>
                                          <label for=""></label>
                                          <input id="" type="text" class="form-control mt-1 mb-3 comorbidity" name="illnesses" value="{{$user->student->illnesses}}" placeholder="If yes, please specify">
                                      </div>
                              </div>

                              <div class="col-md-4">
                                  <label for="" class="form-check-label fw-bold">{{ __('Vaccination Status') }}</label>
                                  <div class="row">
                                      <div class="">
                                          <input class="form-check-input" type="radio" name="vaccine_status" id="inlineRadio6" value="Unvaccinated" {{ ($user->student->vaccine_status=="Unvaccinated")? "checked" : "" }}>
                                          <label class="form-check-label" for="inlineRadio6">Unvaccinated</label>
                                      </div>
                                  </div>
                                  <div class="row ">
                                      <div class="">
                                          <input class="form-check-input" type="radio" name="vaccine_status" id="inlineRadio6" value="Partial" {{ ($user->student->vaccine_status=="Partial")? "checked" : "" }}>
                                          <label class="form-check-label" for="inlineRadio6">Partial</label>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="">
                                          <input class="form-check-input" type="radio" name="vaccine_status" id="inlineRadio6" value="Full" {{ ($user->student->vaccine_status=="Full")? "checked" : "" }}>
                                          <label class="form-check-label" for="inlineRadio6">Full</label>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="">
                                          <input class="form-check-input" type="radio" name="vaccine_status" id="inlineRadio6" value="Boosted" {{ ($user->student->vaccine_status=="Boosted")? "checked" : "" }}>
                                          <label class="form-check-label" for="inlineRadio6">Boosted</label>
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-4">
                                  <label for="" class="col-12 form-check-label text-start fw-bold">{{ __('How do you go to school?') }}</label>
                                  <div class="row">
                                      <div class="col-md-12">
                                          <input class="form-check-input" type="radio" name="mogts" id="inlineRadio3" value="Walking" {{ ($user->student->mogts=="Walking")? "checked" : "" }}>
                                          <label class="form-check-label" for="inlineRadio3">Walking</label>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-12">
                                          <input class="form-check-input" type="radio" name="mogts" id="inlineRadio3" value="Personal Vehicle" {{ ($user->student->mogts=="Personal Vehicle")? "checked" : "" }}>
                                          <label class="form-check-label" for="inlineRadio3">Personal Vehicle</label>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-12">
                                          <input class="form-check-input" type="radio" name="mogts" id="inlineRadio3" value="Public Utility Vehicle (PUV)" {{ ($user->student->mogts=="Public Utility Vehicle (PUV)")? "checked" : "" }}>
                                          <label class="form-check-label" for="inlineRadio3">Public Utility Vehicle (PUV)</label>
                                      </div>
                                  </div>

                               
                              </div>
                          </div>
                          <hr>
                          <h6>Extra Information</h6>
                          <div class="row smlFont">
                             <div class="col-md-6">
                                  <label for="" class="col-12 form-check-label text-start fw-bold">{{ __('Are you a 4Ps Beneficiary?') }}</label>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <input class="form-check-input" type="radio" name="is_4ps_member" id="inlineRadio1" value="1" {{ ($user->student->is_4ps_member=="1")? "checked" : "" }}> 
                                          <label class="form-check-label" for="inlineRadio1">Yes</label>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <input class="form-check-input" type="radio" name="is_4ps_member" id="inlineRadio1" value="0" {{ ($user->student->is_4ps_member=="0")? "checked" : "" }}>
                                          <label class="form-check-label" for="inlineRadio1">No</label>
                                      </div>
                                  </div>
                             </div>
                             <div class="col-md-6">
                              <label for="" class="col-12 form-check-label text-start fw-bold">{{ __('Enrolled in Madrasah? (For Muslims ONLY)') }}</label>
                              <div class="row">
                                  <div class="col-md-6">
                                      <input class="form-check-input" type="radio" name="is_madrasah_enrolled" id="inlineRadio2" value="1" {{ ($user->student->is_madrasah_enrolled=="1")? "checked" : "" }}>
                                      <label class="form-check-label" for="inlineRadio2">Yes</label>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-6">
                                      <input class="form-check-input" type="radio" name="is_madrasah_enrolled" id="inlineRadio2" value="0" {{ ($user->student->is_madrasah_enrolled=="0")? "checked" : "" }}>
                                      <label class="form-check-label" for="inlineRadio2">No</label>
                                  </div>
                              </div>
                         </div>
                          </div>
                          <hr>
                          <h6>Parent/Guardian Information</h6>
                          <?php
                           $c  = 0;
                          ?>
                          @foreach($user->parents as $parent)
                           <?php
                           $c++;
                           ?>
                          <div id="parentDiv">
                              <div>
                                  <div class="row">
                                      <input type="hidden" class="form-control" value={{$parent->pg_id}} name="inputs[{{$c}}][parent_id]">
                                      <div class="col-md-3">
                                          <label for="" class="col-12 col-form-label text-start">{{ __('First Name') }}</label>
                                          <input id="" type="text" class="form-control form-control-sm" name="inputs[{{$c}}][first_name]" value="{{$parent->first_name}}" >
                                      </div>
          
                                      <div class="col-md-2">
                                          <label for="" class="col-12 col-form-label text-start">{{ __('Middle Name') }}</label>
                                          <input id="" type="text" class="form-control form-control-sm" name="inputs[{{$c}}][middle_name]" value="{{$parent->middle_name}}"   >
                                      </div>
          
                                      <div class="col-md-3">
                                          <label for="" class="col-12 col-form-label text-start">{{ __('Last Name') }}</label>
                                          <input id="" type="text" class="form-control form-control-sm" name="inputs[{{$c}}][last_name]" value="{{$parent->last_name}}"   >
                                          <div id="cellHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> If mother, put maiden name</div>
                                      </div>

                                      <div class="col-md-1">
                                          <label for="" class="col-12 col-form-label text-start">{{ __('Suffix') }}</label>
                                          <input id="" type="text" class="form-control form-control-sm" name="inputs[{{$c}}][suffix]" value="{{$parent->suffix}}"   >
                                      </div>

                                      <div class="col-md-3">
                                          <label for="" class="col-12 col-form-label text-start">{{ __('Relationship') }}</label>
                                          <select class="form-select form-select-sm" aria-label="Default select example" name="inputs[{{$c}}][relationship]"  >
                                              <option value="" selected>Choose Relationship</option>
                                              <option value="Mother" {{ ($parent->relationship=="Mother")? "selected" : "" }} >Mother</option>
                                              <option value="Father" {{ ($parent->relationship=="Father")? "selected" : "" }} >Father</option>
                                              <option value="Guardian" {{ ($parent->relationship=="Guardian")? "selected" : "" }} >Guardian</option>
                                          </select>
                                      </div>
                                  </div>
          
                                  <div class="row">
                                      <div class="col-md-3">
                                          <label for="" class="col-12 col-form-label text-start">{{ __('Occupation') }}</label>
                                          <input id="" type="text" class="form-control form-control-sm" name="inputs[{{$c}}][occupation]" value="{{$parent->occupation}}" >
                                      </div>
          
                                      <div class="col-md-3">
                                          <label for="" class="col-12 col-form-label text-start">{{ __('Contact Number') }}</label>
                                          <input id="" type="number" class="form-control form-control-sm" name="inputs[{{$c}}][contact_no]" value="{{$parent->contact_no}}">
                                      </div>
          
                                      <div class="col-md-3">
                                          <label for="" class="col-12 col-form-label text-start">{{ __('Email Address') }}</label>
                                          <input id="memail" type="email" class="form-control form-control-sm" name="inputs[{{$c}}][email]" value="{{$parent->email}}">
                                      </div>
          
                                      <div class="col-md-3">
                                          <label for="" class="col-12 col-form-label text-start">{{ __('Facebook Account') }}</label>
                                          <input id="" type="text" class="form-control form-control-sm" name="inputs[{{$c}}][fb_account]" value="{{$parent->fb_account}}"  >
                                      </div>
                                  </div>
                       
                                  <hr>
                              </div>
                          </div>
                          @endforeach
                          @endif
       
                             
              </div>


            
                            
            </div>
        </div>
    
    <div class="modal-footer">
        <input type="hidden" class="delete_val" id="delete_id"  value="{{$user->id}}">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-warning editBtn"><span class="btn-label"><i class="fas fa-edit"></i></span> Edit</button>
      </div>
    </div>
  </div>
</div>
</form>
               