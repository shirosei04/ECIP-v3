<div class="modal fade" id="dupSchedModal{{$sched->sched_id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Duplicate Subject Schedule</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Duplicate Subject Schedule Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ url('save-schedule') }}">
                            @csrf
            
                            <div class="row ">
                                <div class="mb-3 ">
                                    <label class="form-label fw-bold">Days</label>
                                    {{-- <div class="btn-group d-grid gap-2 d-md-block" role="group" aria-label="Basic checkbox toggle button group">
                                        <input type="checkbox" class="btn-check" id="btncheck1" name="days[]" value="M" {{ (str_contains($sched->days, "M"))? "checked" : "" }} autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck1">Monday</label>
                                      
                                        <input type="checkbox" class="btn-check" id="btncheck2" name="days[]" value="T" {{ (str_contains($sched->days, "T"))? "checked" : "" }} autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck2">Tuesday</label>
                                      
                                        <input type="checkbox" class="btn-check" id="btncheck3" name="days[]" value="W" {{ (str_contains($sched->days, "W"))? "checked" : "" }}  autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck3">Wednesday</label>
    
                                        <input type="checkbox" class="btn-check" id="btncheck4" name="days[]" value="Th" {{ (str_contains($sched->days, "Th"))? "checked" : "" }}  autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck4">Thursday</label>
    
                                        <input type="checkbox" class="btn-check" id="btncheck5" name="days[]" value="F" {{ (str_contains($sched->days, "F"))? "checked" : "" }}   autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck5">Friday</label>
    
                                        <input type="checkbox" class="btn-check" id="btncheck6" name="days[]" value="Sat" {{ (str_contains($sched->days, "Sat"))? "checked" : "" }}   autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck6">Saturday</label>
    
                                        <input type="checkbox" class="btn-check" id="btncheck7" name="days[]" value="Sun" {{ (str_contains($sched->days, "Sun"))? "checked" : "" }}  autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btncheck7">Sunday</label>
                                      </div> --}}

                                      
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="days[]" value="M" {{ (str_contains($sched->days, "M"))? "checked" : "" }} id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                        Monday
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="days[]" value="T" {{ (strpos($sched->days,"T"))? "checked" : "" }} id="flexCheckDefault1">
                                        <label class="form-check-label" for="flexCheckDefault1">
                                       Tuesday
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="days[]" value="W" {{ (str_contains($sched->days, "W"))? "checked" : "" }} id="flexCheckDefault2">
                                        <label class="form-check-label" for="flexCheckDefault2">
                                        Wednesday
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="days[]" value="Th" {{ (str_contains($sched->days, "Th"))? "checked" : "" }} id="flexCheckDefault3">
                                        <label class="form-check-label" for="flexCheckDefault3">
                                        Thursday
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="days[]" value="F" {{ (str_contains($sched->days, "F"))? "checked" : "" }} id="flexCheckDefault4">
                                        <label class="form-check-label" for="flexCheckDefault4">
                                        Friday
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="days[]" value="Sat" {{ (str_contains($sched->days, "Sat"))? "checked" : "" }} id="flexCheckDefault5">
                                        <label class="form-check-label" for="flexCheckDefault5">
                                        Saturday
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="days[]" value="Sun" {{ (str_contains($sched->days, "Sun"))? "checked" : "" }} id="flexCheckDefault6">
                                        <label class="form-check-label" for="flexCheckDefault6">
                                        Sunday
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Subject Name</label>
                                    <select class="form-select" aria-label="Default select example" name="sub_id" required>
                                        <option value="" selected>Choose Subject</option>
                                        @if(!empty($sched->subject))
                                        @foreach ($subjects as $sub)
                                        <option value="{{$sub->subject_id}}" {{ ($sched->subject->subject_name==$sub->subject_name)? "selected" : "" }}>{{$sub->subject_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                               
                        
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Semester</label>
                                    <select class="form-select" aria-label="Default select example" name="semester" required>
                                        <option value="" selected>Choose Semester</option>
                                        <option value="1st" {{ ($sched->semester=="1st")? "selected" : "" }}>1st</option>
                                        <option value="2nd" {{ ($sched->semester=="2nd")? "selected" : "" }}>2nd</option>
                                        <option value="Not Applicable" {{ ($sched->semester=="Not Applicable")? "selected" : "" }}>Not Applicable</option>
                                    
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Time Start</label>
                                    <input type="time" class="form-control" name="time_start" value="{{$sched->time_start}}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Time End</label>
                                    <input type="time" class="form-control"  name="time_end" value="{{$sched->time_end}}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Teacher</label>
                                    <select class="form-select" aria-label="Default select example" name="id">
                                        {{-- @foreach ($teachers as $teacher)
                                        <option value="{{$teacher->id}}" {{ ($sched->teacher->id==$teacher->id)? "selected" : "" }}>{{$teacher->first_name . " " . $teacher->middle_name . " " . $teacher->last_name . " " . $teacher->suffix}} </option>
                                        @endforeach --}}
                                        @if(is_null($sched->teacher))
                                        {{-- if null --}}
                                            <option value="">No Assigned Teacher</option>
                                            @foreach ($teachers as $teacher)
                                            <option value="{{$sched->id}}">{{$teacher->first_name . " " . $teacher->middle_name . " " . $teacher->last_name . " " . $teacher->suffix}}</option>
                                            @endforeach
                                        @else
                                            <option value="">No Assigned Teacher</option>
                                            @foreach ($teachers as $teacher)
                                            <option value="{{$teacher->id}}" {{ ($sched->teacher->id==$teacher->id)? "selected" : "" }}>{{$teacher->first_name . " " . $teacher->middle_name . " " . $teacher->last_name . " " . $teacher->suffix}} </option>
                                            @endforeach
                                        @endif
                         
                                    </select>
                                </div>
    
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Section</label>
                                    <select class="form-select" aria-label="Default select example" name="sect_id" required>
                                        <option value="" selected>Choose Section</option>
                                        @foreach ($sections as $section)
                                        <option value="{{$section->section_id}}" {{ ($sched->section->section_name==$section->section_name)? "selected" : "" }}>{{$section->section_name}}</option>
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
                                        <option value="{{$year->sy_id}}" {{ ($sched->schoolYear->school_year==$year->school_year)? "selected" : "" }}>{{$year->school_year}}</option>
                                        @endforeach
                                    </select>
                                </div>
    
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Room</label>
                                    <select class="form-select" aria-label="Default select example" name="room_id"> 
                                        
                                    @if(is_null($sched->room))
                                        <option value="" selected >No Assigned Room</option>
                                        {{-- if null --}}
                                        @foreach ($rooms as $room)
                                        <option value="{{$room->room_id}}">{{$room->room_number}}</option>
                                        @endforeach
                                        
                                    @else
                                        @foreach ($rooms as $room)
                                        <option value="{{$room->room_id}}" {{ ($sched->room->room_number==$room->room_number)? "selected" : "" }}>{{$room->room_number}}</option>
                                        @endforeach
                                    @endif
                                       
                                    </select>
                                </div>
                            </div>
            </div>
        </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info"><span class="btn-label"><i class="fas fa-clone"></i></span> Duplicate</button>
      </div>
    </div>
  </div>
</div>
</form>
               