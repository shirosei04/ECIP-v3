<div class="modal fade" id="addSchedModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                        <form method="POST" action="{{url('save-schedule')}}">
                            @csrf
                            <div class="row ">
                                <div class="mb-3 ">
                                    <label class="form-label fw-bold">Days</label>
                                    <div class="btn-group d-grid gap-2 d-md-block" role="group" aria-label="Basic checkbox toggle button group">
                                        <input type="checkbox" class="btn-check" id="btncheck1" name="days[]" value="M" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck1">Monday</label>
                                      
                                        <input type="checkbox" class="btn-check" id="btncheck2" name="days[]" value="T" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck2">Tuesday</label>
                                      
                                        <input type="checkbox" class="btn-check" id="btncheck3" name="days[]" value="W"  autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck3">Wednesday</label>
    
                                        <input type="checkbox" class="btn-check" id="btncheck4" name="days[]" value="Th"  autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck4">Thursday</label>
    
                                        <input type="checkbox" class="btn-check" id="btncheck5" name="days[]" value="F"  autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck5">Friday</label>
    
                                        <input type="checkbox" class="btn-check" id="btncheck6" name="days[]" value="Sat"  autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck6">Saturday</label>
    
                                        <input type="checkbox" class="btn-check" id="btncheck7" name="days[]" value="Sun"  autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck7">Sunday</label>
                                      </div>
                                      @if($errors->has('days'))
                                      <span class="text-danger">{{ $errors->first('days') }}</span>
                                  @endif
                                </div>
                            </div>

                            <div class="row">
                            
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Subject Name</label>
                                    <select class="form-select" aria-label="Default select example" name="sub_id" required>
                                        <option value="" selected>Choose Subject</option>
                                        @foreach ($subjects as $sub)
                                        <option value="{{$sub->subject_id}}">{{$sub->subject_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                               
                        
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Semester</label>
                                    <select class="form-select" aria-label="Default select example" name="semester" required>
                                        <option value="" selected>Choose Semester</option>
                                        <option value="1st">1st</option>
                                        <option value="2nd">2nd</option>
                                        <option value="Not Applicable">Not Applicable</option>
                                    
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Time Start</label>
                                    <input type="time" class="form-control" name="time_start" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Time End</label>
                                    <input type="time" class="form-control"  name="time_end" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Teacher</label>
                                    <select class="form-select" aria-label="Default select example" name="id" required>
                                        <option value="" selected>Choose Teacher</option>
                                        @foreach ($teachers as $teacher)
                                        <option value="{{$teacher->id}}">{{$teacher->first_name . " " . $teacher->middle_name . " " . $teacher->last_name . " " . $teacher->suffix}}</option>
                                        @endforeach
                                        <option value="">No Assigned Teacher</option>
                                    </select>
                                </div>
    
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Section</label>
                                    <select class="form-select" aria-label="Default select example" name="sect_id" required>
                                        <option value="" selected>Choose Section</option>
                                        @foreach ($sections as $section)
                                        <option value="{{$section->section_id}}">{{$section->section_name}}</option>
                                        @endforeach
    
                                    </select>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    
                                    <label class="form-label fw-bold">School Year</label>
                                    <select class="form-select" aria-label="Default select example" name="year_id" required>
                                        <option value="" selected>Choose School Year</option>
                                        @foreach ($allsy as $year)
                                        <option value="{{$year->sy_id}}">{{$year->school_year}}</option>
                                        @endforeach
                                    </select>
                                </div>
    
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Room</label>
                                    <select class="form-select" aria-label="Default select example" name="room_id" required> 
                                        <option value="" selected>Choose Room</option>
                                        @foreach ($rooms as $room)
                                        <option value="{{$room->room_id}}">{{$room->room_number}}</option>
                                        @endforeach
                                        <option value="">No Assigned Room</option>
                                    </select>
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
