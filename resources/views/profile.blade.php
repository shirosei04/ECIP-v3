@extends('layouts.master')
@section('content')
<style>
    body{
        color: #1a202c;
        text-align: left;
        /* background-color: #b4d8f9;     */
    }
    .main-body {
        padding: 15px;
    }
    .card {
        box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0 solid rgba(0,0,0,.125);
        border-radius: .25rem;
    }

    .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1rem;
    }

    .gutters-sm {
        margin-right: -8px;
        margin-left: -8px;
    }

    .gutters-sm>.col, .gutters-sm>[class*=col-] {
        padding-right: 8px;
        padding-left: 8px;
    }
    .mb-3, .my-3 {
        margin-bottom: 1rem!important;
    }

    .bg-gray-300 {
        background-color: #e2e8f0;
    }
    .h-100 {
        height: 100%!important;
    }
    .shadow-none {
        box-shadow: none!important;
    }

    .subCard{
        font-size: 15px;
    }   
</style>


    {{-- @if ($message = Session::get('success'))
    <div class="alert alert-success">
        {{ $message }}
    </div>
    @endif --}}

    @if (Auth::user()->role == 'Student' && Auth::user()->is_verified == 0 && !empty(Auth::user()->student))
      {{-- <div class="alert alert-warning">
         <strong> The AO is checking your details.  If you haven't already, please submit your required documents to the Admission Office via email or to the Admission Office directly.</strong>
      </div> --}}
      <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">You have successfully submitted your information form!</h4>
        <p>Please wait for the Admission Officer to verify your account. To get verified, please make sure to submit your required documents within 14 days to the Admissions Office via email or submitting to the office directly. Failure to do so can get your account archived. Thank you!</p>
        <hr>
        <em><small><p class="mb-0" style="color: red">Admissions Office email: ecip.admissions@gmail.com | Admission Office: B Building, 2nd Floor, Room 251 </p></em></small>
      </div>
    @elseif(Auth::user()->role == 'Student' && empty(Auth::user()->student))
      <div class="alert alert-danger">
        Step 2 out of 2. Please add student and parent information
      </div>
    @endif
    
        {{-- has no student detail --}}
        @if(empty(Auth::user()->student))
            <div>
              <div class="main-body">
                <div class="row gutters-sm">
                  <div class="col-md-4 mb-3">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                          @if(Auth::user()->sex == 'Male')
                              <img src="https://cdn2.iconfinder.com/data/icons/ios-7-icons/50/user_male2-512.png" alt="Admin" class="rounded-circle" width="150">
                          @else
                              <img src="https://cdn2.iconfinder.com/data/icons/ios-7-icons/50/user_female2-512.png" class="img-fluid ms-auto mx-auto mb-0 mt-2 logo-image">
                          @endif
                          <div class="mt-3 ">
                            <h4>{{Auth::user()->first_name . " " . Auth::user()->middle_name . " " .Auth::user()->last_name}}</h4>
                            {{-- <p class="text-secondary mb-1"><i class="fas fa-user-circle"></i> {{Auth::user()->sex}} </p>
                            <p class="text-secondary mb-1"><i class="fas fa-level-up-alt"></i> Grade {{Auth::user()->student->grade_lvl}} </p> --}}
                            @if(Auth::user()->role == 'Student')
                            <div class="row">
                              @if(Auth::user()->status == "0")
                              <p class="pt-1 " style="color: red">NOTE: Your account has already been archived and so you cannot add student information. Please message or email the school Admission Officer if you wish to unarchive your account.</p>
                              <p style="color: red">AO email: Insert AO email here</p>
                              @else
                              <div class="col-sm-12">
                                <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#studentDetailModal">Add Student Information</a>
                              </div>
                              <p class="pt-1 smlFont" style="color: red">No student information found. Please add.</p>
                              @endif
                            </div>
                            @endif
                            <p class="text-secondary mb-1 ">  {{Auth::user()->role}} </p>
                            <hr>
                            <p class="text-secondary fst-italic ">Joined {{date('F d, Y', strTotime(Auth::user()->date_of_registration))}} </p>
                          </div>
                        </div>
                        @include('profile.student-detail-form')
                      </div>
                    </div>
                    <div class="card mt-3 ">
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                          <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg> Facebook</h6>
                          <span class="text-secondary">{{Auth::user()->fb_acc}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                          <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"zoomAndPan="magnify" width="24" height="24" viewBox="0 0 30 30.000001" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="id1"><path d="M 3.460938 6.5625 L 26.539062 6.5625 L 26.539062 24.707031 L 3.460938 24.707031 Z M 3.460938 6.5625 " clip-rule="nonzero"/></clipPath></defs><g clip-path="url(#id1)"><path fill="rgb(6.269836%, 5.879211%, 5.099487%)" d="M 24.230469 11.101562 L 15 16.769531 L 5.769531 11.101562 L 5.769531 8.832031 L 15 14.503906 L 24.230469 8.832031 Z M 24.230469 6.5625 L 5.769531 6.5625 C 4.492188 6.5625 3.472656 7.578125 3.472656 8.832031 L 3.460938 22.441406 C 3.460938 23.695312 4.492188 24.707031 5.769531 24.707031 L 24.230469 24.707031 C 25.507812 24.707031 26.539062 23.695312 26.539062 22.441406 L 26.539062 8.832031 C 26.539062 7.578125 25.507812 6.5625 24.230469 6.5625 " fill-opacity="1" fill-rule="nonzero"/></g></svg> Email</h6>
                          <span class="text-secondary">{{Auth::user()->email}}</span>
                        </li>

                      </ul>
                    </div>
                  </div>
                  {{-- BASIC INFO --}}
                  <div class="col-md-8 subCard">
                    <div class="card mb-3">
                      <div class="card-body">
                          <h4>BASIC INFORMATION</h4>
                          <hr>
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Address</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              {{Auth::user()->region . ", " . Auth::user()->province . ", " . Auth::user()->city . ", " . Auth::user()->barangay . ", " . Auth::user()->house_no}}
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Nationality</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            {{Auth::user()->nationality}}
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Ethinicity</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              {{Auth::user()->ethnicity}}
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Religion</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              {{Auth::user()->religion}}
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Mother Tongue</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              {{Auth::user()->mother_tongue}}
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Birth Details</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              Born {{date('F d, Y', strTotime(Auth::user()->birth_date))}} in {{Auth::user()->birth_place}}
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Contact Information</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            <p class="mb-1"><i class="fas fa-mobile-alt"></i> {{Auth::user()->cell_no }} </p>
                            <p class="mb-0"><i class="fas fa-phone-alt"></i> {{Auth::user()->tel_no }} </p>
                          </div>
                        </div>
                        <hr>
                      </div>
                    </div>
                  </div>
                  @if(Auth::user()->role == 'Student')
                  {{-- PARENT DETAILS --}}
                  <div class="col-md-12 subCard">
                      <div class="card mb-3">
                        <div class="card-body">
                            <h4>PARENT INFORMATION</h4>
                            <div class="row">
                              <div class="col-sm-12">
                                {{-- <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#parentDetailModal">Add Parent Information</a> --}}
                              </div>
                              <p class="pt-1 smlFont" style="color: red">No parent/guardian information found. Please add.</p>
                              @include('profile.parent-detail-form')
                            </div>
                        </div>
                      </div>
                    </div>
                    @endif

                </div>
              </div>
            </div>
        @else
        <div class="">
            <div class="main-body">
                  <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex flex-column align-items-center text-center">
                            @if(Auth::user()->sex == 'Male')
                                <img src="https://cdn2.iconfinder.com/data/icons/ios-7-icons/50/user_male2-512.png" alt="Admin" class="rounded-circle" width="150">
                            @else
                                <img src="https://cdn2.iconfinder.com/data/icons/ios-7-icons/50/user_female2-512.png" width="150"> 
                            @endif
                            <div class="mt-3 align-items-center ">
                              <h4>{{Auth::user()->first_name . " " . Auth::user()->middle_name . " " .Auth::user()->last_name}}</h4>
                              {{-- <p class="text-secondary mb-1"><i class="fas fa-user-circle"></i> {{Auth::user()->sex}} </p>
                              <p class="text-secondary mb-1"><i class="fas fa-level-up-alt"></i> Grade {{Auth::user()->student->grade_lvl}} </p> --}}
                              <p class="text-secondary mb-1">  {{Auth::user()->role}} </p>
                                @if(Auth::user()->student->grade_lvl == 0)
                                  <p class="text-secondary mb-1"> Grade Level: Kinder   </p>
                                
                                @else
                                  <p class="text-secondary mb-1"> Grade Level: {{Auth::user()->student->grade_lvl}}  </p>
                                
                                @endif
                                <p class="text-secondary mb-1"> Track: {{Auth::user()->student->track}} </p>
                              <p class="text-secondary mb-1"> LRN: {{Auth::user()->student->lrn}} </p>
                              <hr>

                              <p class="text-secondary mb-1"> System ID: {{Auth::user()->id}} </p>
                              <p class="text-secondary fst-italic ">Joined {{date('F d, Y', strTotime(Auth::user()->date_of_registration))}} </p>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card mt-3 ">
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg> Facebook</h6>
                            <span class="text-secondary">{{Auth::user()->fb_acc}}</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"zoomAndPan="magnify" width="24" height="24" viewBox="0 0 30 30.000001" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="id1"><path d="M 3.460938 6.5625 L 26.539062 6.5625 L 26.539062 24.707031 L 3.460938 24.707031 Z M 3.460938 6.5625 " clip-rule="nonzero"/></clipPath></defs><g clip-path="url(#id1)"><path fill="rgb(6.269836%, 5.879211%, 5.099487%)" d="M 24.230469 11.101562 L 15 16.769531 L 5.769531 11.101562 L 5.769531 8.832031 L 15 14.503906 L 24.230469 8.832031 Z M 24.230469 6.5625 L 5.769531 6.5625 C 4.492188 6.5625 3.472656 7.578125 3.472656 8.832031 L 3.460938 22.441406 C 3.460938 23.695312 4.492188 24.707031 5.769531 24.707031 L 24.230469 24.707031 C 25.507812 24.707031 26.539062 23.695312 26.539062 22.441406 L 26.539062 8.832031 C 26.539062 7.578125 25.507812 6.5625 24.230469 6.5625 " fill-opacity="1" fill-rule="nonzero"/></g></svg> Email</h6>
                            <span class="text-secondary">{{Auth::user()->email}}</span>
                          </li>
                        </ul>
                      </div>
                    </div>
                    {{-- BASIC INFO --}}
                    <div class="col-md-8 subCard">
                      <div class="card mb-3">
                        <div class="card-body">
                            <h4 class="mb-0"><i class="fas fa-info"></i> BASIC INFO</h4>
                            <hr class="mt-0">
                          <div class="row">
                            <div class="col-sm-3">
                              <h6 class="mb-0">Address</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{Auth::user()->region . ", " . Auth::user()->province . ", " . Auth::user()->city . ", " . Auth::user()->barangay . ", " . Auth::user()->house_no}}
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-sm-3">
                              <h6 class="mb-0">Nationality</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                              {{Auth::user()->nationality}}
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-sm-3">
                              <h6 class="mb-0">Ethinicity</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{Auth::user()->ethnicity}}
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-sm-3">
                              <h6 class="mb-0">Religion</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{Auth::user()->religion}}
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-sm-3">
                              <h6 class="mb-0">Mother Tongue</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{Auth::user()->mother_tongue}}
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-sm-3">
                              <h6 class="mb-0">Birth Details</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                Born {{date('F d, Y', strTotime(Auth::user()->birth_date))}} in {{Auth::user()->birth_place}}
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-sm-3">
                              <h6 class="mb-0">Contact Information</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                              <p class="mb-1"><i class="fas fa-mobile-alt"></i> {{Auth::user()->cell_no }} </p>
                              <p class="mb-0"><i class="fas fa-phone-alt"></i> {{Auth::user()->tel_no }} </p>
                            </div>
                          </div>
                          {{-- <div class="row">
                            <div class="col-sm-12">
                              <a class="btn btn-info btn-sm">Edit</a>
                            </div>
                          </div> --}}
                          <hr>
                        </div>
                      </div>
                    </div>
                    @if(Auth::user()->role == 'Student')
                    {{-- AWARD DETAILS --}}
                    @if(count($awards) != 0)
                    <div class="col-md-12 subCard">
                        <div class="card mb-3">
                          <div class="card-body">
                              <h4 class="mb-0"><i class="fas fa-trophy"></i> AWARDS</h4>
                              <hr class="mb-0 mt-0">
                              <div class="table-responsive">
                                <table class="table table-sm table-borderless" >
                                    <thead>
                                      <tr>
                                        <th>Award</th>
                                        <th>Description</th>
                                        <th>Attained at</th>
                                        <th>Date Awarded</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($awards as $award)
                                    <tr>
                                        <td class="mt-0 mb-0">{{$award->award_name}}</td>
                                        <td class="mt-0 mb-0">{{$award->award_desc}}</td>
                                        <td class="mt-0 mb-0">Grade {{$award->grade_lvl}}</td>
                                        <td class="mt-0 mb-0">{{date('F d, Y', strtotime($award->date_awarded))}}</td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>  
                              </div>
                          </div>
                        </div>
                    </div>
                    @endif
                    {{-- PARENT DETAILS --}}
                    <div class="col-md-12 subCard">
                      <div class="card mb-3">
                        <div class="card-body">
                            <h4 class="mb-0"><i class="fas fa-users"></i> PARENT INFO</h4>
                            <hr class="mb-2 mt-0">
                            @foreach($users as $user)
                              
                              <div class="row">
                                @foreach($user->parents as $parent)
                                  <div class="col parentBox">
                                    <p class="text-uppercase mb-0 mt-0 fs-5"><strong>{{$parent->relationship}}</strong></p>
                                    <hr class="mb-1 mt-0">
                                    <p> <strong>Full Name: </strong> {{$parent->first_name}} {{$parent->middle_name}} {{$parent->last_name}} {{$parent->suffix}}</p>
                                    <p><strong>Occupation </strong>{{$parent->occupation}} </p>
                                    <p><strong>Contact No: </strong>{{$parent->contact_no}} </p>
                                    <p><strong>Email: </strong>{{$parent->email}} </p>
                                    <p><strong>Facebook: </strong>{{$parent->fb_account}} </p>
                                  </div>
                                  @endforeach
                                  
                              </div>
                            @endforeach
                        </div>
                      </div>
                    </div>
                    @endif
                  </div>
                </div>
            </div>
        @endif
    
        <div class="loader fs-1 text-white fw-bold">
          ECIP
      </div>



@endsection

@section('scripts')
<script>
  $(document).ready(function(){
    var i = 0;
    $('.addParentBtn').click(function(e){
      e.preventDefault();
      ++i;
      //add another parent detail rows
      $('#parentDiv').prepend(`     <div>
                                    <button type="button" class="btn btn-danger mt-2 removeParentBtn">Remove</button>
                                    
                                    <div class="row">
                                      <input type="hidden" class="form-control" value={{Auth::user()->id}} name="inputs[`+i+`][id]">
                                        <div class="col-md-3">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('First Name') }}</label>
                                            <input id="" type="text" class="form-control" name="inputs[`+i+`][first_name]" value=""  >
                                        </div>
            
                                        <div class="col-md-2">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('Middle Name') }}</label>
                                            <input id="" type="text" class="form-control" name="inputs[`+i+`][middle_name]" value=""  >
                                        </div>
            
                                        <div class="col-md-3">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('Last Name') }}</label>
                                            <input id="" type="text" class="form-control" name="inputs[`+i+`][last_name]" value=""  >
                                            <div id="cellHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> If mother, put maiden name</div>
                                        </div>

                                        <div class="col-md-1">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('Suffix') }}</label>
                                            <input id="" type="text" class="form-control" name="inputs[`+i+`][suffix]" value=""  >
                                        </div>

                                        <div class="col-md-3">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('Relationship') }}</label>
                                            <select class="form-select" aria-label="Default select example" name="inputs[`+i+`][relationship]" >
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
                                            <input id="" type="text" class="form-control" name="inputs[`+i+`][occupation]" value="">
                                        </div>
            
                                        <div class="col-md-3">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('Contact Number') }}</label>
                                            <input id="" type="text" class="form-control" name="inputs[`+i+`][contact_no]" value="" maxLength="11">
                                        </div>
            
                                        <div class="col-md-3">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('Email Address') }}</label>
                                            <input id="email" type="text" class="form-control" name="inputs[`+i+`][email]" value=""  >
                                        </div>
            
                                        <div class="col-md-3">
                                            <label for="" class="col-12 col-form-label text-start">{{ __('Facebook Account') }}</label>
                                            <input id="" type="text" class="form-control" name="inputs[`+i+`][fb_account]" value="" >
                                        </div>
                                    </div>
                                    <hr>
                                </div>`);
    });

    //remove parent row
    $(document).on('click', '.removeParentBtn', function(e){
      e.preventDefault();
  

      let row_item = $(this).parent();
      $(row_item).remove();
    });

    // ajax request to insert all the form data
    // $("#studentDetailForm").submit(function(e){
    //     e.preventDefault();
    //     $("#addBtn").val('Adding...');
    //     $.ajax({
    //       url: 'addProfileDetail',
    //       method: 'POST',
    //       data: $('#studentDetailForm').serialize(),
    //       success:function(response){
            
    //         window.location.href = '/profile';
    //       }
    //     });
    // });

    $('#studentDetailForm').submit(function (e) {
            e.preventDefault();
            // var spinner  = '<div class="loader fs-3 fw-bold">Please wait...</div>';
            // var delete_id = $(this).closest("div").find('.delete_val').val();
            var data = $('#studentDetailForm').serialize()
            // alert(delete_id);
            swal({
            title: "Are you sure?",
            text: "Once you submitted, you cannot edit your information anymore?",
            icon: "warning",
            dangerMode: true,
            buttons: true,
            })
            .then(willDelete => {
            if (willDelete) {
                // $('.rejectTarget').html(spinner)
                $.ajax({
                    type: "POST",
                    url: 'addProfileDetail',
                    data: data,
                    success: function (response) {
                        swal('Student Information Submitted Successfully' , {
                            icon: "success",
                        }) 
                        .then((result) => {
                            window.location.href = '/profile';
                        });
                    },
                    error: function (reject) {
                        if(reject.status == 422){
                            swal('Some information are wrong. Please re-enter your inputs.' , {
                            icon: "error",
                            }) 
                            .then((result) => {
                              window.location.href = '/profile';
                            });
                        }
                        else{
                            swal('Something Went Wrong. Please Try Again' , {
                            icon: "error",
                            }) 
                            .then((result) => {
                              window.location.href = '/profile';
                            });
                        }
                    }
                });
            }
        });
           
    }); 

   
  });
</script>
@endsection