<div class="modal fade" id="newUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Add A New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                            <h5>New User Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('add-user')}}">
                            @csrf
                            <p class="text-center fs-5 fw-bold regDivider">BASIC INFORMATION</p>
                            <div class="row smlFont">
                                <div class="col-md-4">
                                    {{-- date of registration --}}
                                    <fieldset disabled>
                                        <label for="" class="col-6 col-form-label text-start fw-bold">{{ __('Date of Registration') }}</label>
                                        <input id="" type="text" class="form-control form-control-sm" value="{{  now()->toDateString('Y-m-d') }}" >
                                    </fieldset>
                                </div>

                                {{-- spacing --}}
                                <div class="col-md-4">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Role') }}</label>
                                    <select class="form-select form-select-sm" aria-label="Default select example" name="role" required>
                                        <option value="" selected>Choose Role</option>
                                        <option value="Admission Officer" >Admission Officer</option>
                                        <option value="Principal" >Principal</option>
                                        <option value="Teacher" >Teacher</option>
                                    </select>
                                    @if($errors->has('role'))
                                        <span class="text-danger">{{ $errors->first('role') }}</span>
                                    @endif
                                </div>

                                {{-- Sex --}}
                                <div class="col-md-4">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Sex') }}</label>
                                    <input class="form-check-input" type="radio" name="sex" id="inlineRadio" value="Male" {{ old('sex')=="Male" ? 'checked='.'"checked"' : '' }}>
                                    <label class="form-check-label" for="inlineRadio" >Male</label>

                                    <input class="form-check-input" type="radio" name="sex" id="inlineRadio" value="Female" {{ old('sex')=="Female" ? 'checked='.'"checked"' : '' }}>
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
                                    <input type="text" class="form-control form-control-sm" id="firstname" oninput="getValue()" name="first_name" aria-describedby="nameHelp" value="{{old('first_name')}}">
                                    @if($errors->has('first_name'))
                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-md-6 col-form-label text-start fw-bold">{{ __('Middle Name') }}</label>
                                    <input id="mname" type="text" class="form-control form-control-sm" aria-describedby="mnameHelp" name="middle_name" value="{{old('middle_name')}}" >
                                    <div id="mnameHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> If none, input dot (.)</div>
                                    @if($errors->has('middle_name'))
                                        <span class="text-danger">{{ $errors->first('middle_name') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-md-6 col-form-label text-start fw-bold" >{{ __('Family Name') }}</label>
                                    <input type="text" class="form-control form-control-sm" id="lastname" oninput="getValue()" name="last_name"  value="{{old('last_name')}}">
                                    @if($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-md-4 col-form-label text-start fw-bold">{{ __('Suffix') }}</label>
                                    <input id="lname" type="text" class="form-control form-control-sm" name="suffix" maxLength="10" aria-describedby="extensionHelp" value="{{old('suffix')}}">
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
                                    <input id="bdate" type="date" class="form-control form-control-sm" name="bdate" value="{{old('bdate')}}"autocomplete="">
                                    @if($errors->has('bdate'))
                                        <span class="text-danger">{{ $errors->first('bdate') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label for="bplace" class="col-md-4 col-form-label text-start fw-bold">{{ __('Birth Place') }}</label>
                                    <input id="bplace" type="input" class="form-control form-control-sm" name="bplace" value="{{old('bplace')}}"  autocomplete="">
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
                                    <input id="" type="string" class="form-control form-control-sm" name="region" value="{{old('region')}}"autocomplete="">
                                    <div id="emailHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> 1st</div>
                                    @if($errors->has('region'))
                                        <span class="text-danger">{{ $errors->first('region') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-2">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Province') }}</label>
                                    {{-- <select class="form-select form-select-sm" name="province" id="province">
                                    </select> --}}
                                    <input id="" type="string" class="form-control form-control-sm" name="province" value="{{old('province')}}"autocomplete="">
                                    <div id="emailHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> 2nd</div>
                                    @if($errors->has('province'))
                                        <span class="text-danger">{{ $errors->first('province') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-2">
                                    <label for="city" class="col-12 col-form-label text-start fw-bold">{{ __('City') }}</label>
                                    {{-- <select class="form-select form-select-sm" name="city" id="city">
                                    </select> --}}
                                    <input id="" type="string" class="form-control form-control-sm" name="city" value="{{old('city')}}"autocomplete="">
                                    <div id="emailHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> 3rd</div>
                                    @if($errors->has('city'))
                                        <span class="text-danger">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-2">
                                    <label for="city" class="col-12 col-form-label text-start fw-bold">{{ __('Barangay') }}</label>
                                    {{-- <select class="form-select form-select-sm" name="barangay" id="barangay">
                                    </select> --}}
                                    <input id="" type="string" class="form-control form-control-sm" name="barangay" value="{{old('barangay')}}"autocomplete="">
                                    <div id="emailHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> 4th</div>
                                    @if($errors->has('barangay'))
                                        <span class="text-danger">{{ $errors->first('barangay') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('House #/Building/Street/Sitio/Purok') }}</label>
                                    <input id="building" type="text" class="form-control form-control-sm" name="street" value="{{old('street')}}">
                                    @if($errors->has('street'))
                                        <span class="text-danger">{{ $errors->first('street') }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Nationality & Religion --}}
                            <div class="row smlFont">
                                <div class="col-md-3">
                                    <label for="" class="col-6 col-form-label text-start fw-bold">{{ __('Nationality') }}</label>
                                    <input id="ethnic" type="text" class="form-control form-control-sm" name="nationality" value="{{old('nationality')}}" >
                                    @if($errors->has('nationality'))
                                        <span class="text-danger">{{ $errors->first('nationality') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Religion') }}</label>
                                    <input id="ethnic" type="text" class="form-control form-control-sm" name="religion"  value="{{old('religion')}}">
                                    @if($errors->has('religion'))
                                        <span class="text-danger">{{ $errors->first('religion') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-6 col-form-label text-start fw-bold">{{ __('Ethnicity') }}</label>
                                    <input id="ethnic" type="text" class="form-control form-control-sm" name="ethnicity" value="{{old('ethnicity')}}" >
                                    @if($errors->has('ethnicity'))
                                        <span class="text-danger">{{ $errors->first('ethnicity') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Mother Tongue') }}</label>
                                    <input id="mtongue" type="text" class="form-control form-control-sm" name="mother_tongue" value="{{old('mother_tongue')}}" >
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
                                    <input id="tpno" type="text" class="form-control form-control-sm" name="tel_no" maxLength="10"  minLength="10" aria-describedby="telHelp" value="{{old('tel_no')}}"  >
                                    <div id="telHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> If none, leave blank</div>
                                    @if($errors->has('tel_no'))
                                        <span class="text-danger">{{ $errors->first('tel_no') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Cellphone Number') }}</label>
                                    <input id="cpno" type="text" class="form-control form-control-sm" aria-describedby="cellHelp" maxLength="11"  minLength="11" name="cell_no" value="{{old('cell_no')}}"  >
                                    <div id="cellHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> If none, leave blank</div>
                                    @if($errors->has('cell_no'))
                                        <span class="text-danger">{{ $errors->first('cell_no') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-6 col-form-label text-start fw-bold">{{ __('Email Address') }}</label>
                                    <input id="email" type="email" class="form-control form-control-sm" aria-describedby="emailHelp" name="email" value="{{old('email')}}" >
                                    <div id="emailHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> If none, leave blank</div>
                                    @if($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Facebook Account') }}</label>
                                    <input id="" type="text" class="form-control form-control-sm" name="fb_acc" aria-describedby="fbHelp"  value="{{old('fb_acc')}}" >
                                    <div id="fbHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> If none, leave blank</div>
                                    @if($errors->has('fb_acc'))
                                        <span class="text-danger">{{ $errors->first('fb_acc') }}</span>
                                    @endif
                                </div>
                            </div>
                    
                            <p class="text-center fs-5 fw-bold regDivider">ACCOUNT INFORMATION</p>
                            <div class="row smlFont">
                                <div class="col-md-4">
                                    <input type="hidden" class="form-control form-control-sm" name="username" id="susername" value="{{old('username')}}">
                                    <fieldset disabled>
                                        <label for="" class="col-6 col-form-label text-start fw-bold" >{{ __('Username') }}</label>
                                        <input type="text" class="form-control form-control-sm" id="username" value="{{old('username')}}">
                                        <div id="emailHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> Username is automatically set as lastname_firstname</div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <label for="" class="col-6 col-form-label text-start fw-bold">{{ __('Password') }}</label>
                                    <input type="password" class="form-control form-control-sm" name="password">
                                    <x-input-error :messages="$errors->get('password')" class="mt-1 errorMsg" />
                                </div>

                                <div class="col-md-4">
                                    <label for="" class="col-12 col-form-label text-start fw-bold">{{ __('Confirm Password') }}</label>
                                    <input id="" type="password" class="form-control form-control-sm" name="password_confirmation" aria-describedby="confirmHelp" >
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    {{-- <div id="emailHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> Must have the exact same input as password</div> --}}
                                    @if($errors->has('password_confirmation'))
                                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
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
