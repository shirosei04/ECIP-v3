@extends('layouts.master')
@section('content')
    <div class="card vh-100">
        <div class="card-header tableCardHeader">
            <h3><i class="fas fa-calendar-alt"></i> Enrollment</h3>
        </div>
        @if($allFees > 5)
            <div class="alert alert-danger">
                <h5>For old students with outstanding balance, please settle your previous balance. For new student, and old student with no outstanding balance who have paid the downpayment for the incoming semester/short term, please proceed to the Schedule tab on your portal to check your enrolled subjects. Thank you </h5>
            </div>
            
        @else
        @if ($ifActiveSy->enrollment == "0")
        <div class="alert alert-danger" role="alert" >The principal has not opened the enrollment yet</div>
        @else
            @if(Auth::user()->student->enrollment_status == '0')
                <form action="{{ url('select-section') }}">
                <div class="row p-3" >
                    <div class="col-md-3">
                        <select class="form-select" aria-label="Default select example" name="select_section" required>
                            <option value=""  selected>Select Section</option>
                            @foreach($sections as $section)
                            <option value="{{$section->section_id}}" {{ $selsection==$section->section_id ? "selected" : "" }}>{{$section->section_name}}</option>
                            @endforeach
                        </select>
                        <label for="" class="col-form-label text-start fw-bold" style="color: red">Step 1: Select a section</label>
                    </div>
                 

                    @if(Auth::user()->student->grade_lvl == '11' | Auth::user()->student->grade_lvl == '12')
                        @if (!empty(Auth::user()->student->track))
                            <div class="col-md-3">
                                <input type="hidden" class="form-control" name="select_track"  value="{{ Auth::user()->student->track }}">
                                <input type="text" class="form-control" value="{{ Auth::user()->student->track }}" disabled>
                            </div>
                        @else
                        <div class="col-md-3">
                            <select class="form-select" aria-label="Default select example" name="select_track" required>
                                <option value=""  selected>Select Track</option>
                                <option value="ABM" {{ ($track=="ABM")? "selected" : "" }}>ABM</option>
                                <option value="STEM" {{ ($track=="STEM")? "selected" : "" }}>STEM</option>
                                <option value="TVL" {{ ($track=="TVL")? "selected" : "" }}>TVL</option>
                                <option value="HUMSS" {{ ($track=="HUMSS")? "selected" : "" }}>HUMSS</option>
                                <option value="GAS" {{ ($track=="GAS")? "selected" : "" }}>GAS</option>
                            </select>
                            <label for="" class="col-form-label text-start fw-bold" style="color: red">Step 1.b: Select a track</label>
                        </div>
                        @endif
                    @endif
                    <div class="col-3">
                        <button type="submit"  class="btn btn-success"><i class="fas fa-filter"></i></button>
                    </div>
                </div>
            </form>
                @if (session('message'))
                <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                @endif

                @if (session('alert'))
                <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
                @endif

            @if(count($scheds) != 0)
                <div class="card-body table-responsive">
                    {{-- <div class="row ">
                        <div class="col">
                            <button type="submit"  class="btn btn-success float-end btn-lg mb-3"><i class="fas fa-arrow-right"></i> Proceed to Enroll</button>
                        </div>
                    </div> --}}
                    <label for="" class="col-6 col-form-label text-start fw-bold" style="color: red">Step 2: VIEW and SELECT the subjects to be enrolled</label>
                    <h3 class="text-center fw-bold pb-3">LIST OF SUBJECTS TO ENROLL</h3>
                    <table class="table table-sm">
                        <thead class="table-primary">
                            <tr>
                                <th>Selection</th>
                                <th>School Year</th>
                                <th>Section</th>
                                <th>Subject Name</th>
                                <th>Semester</th>
                                <th>Days</th>
                                <th>Time Start</th>
                                <th>Time End</th>
                                <th>Teacher</th>
                                <th>Room</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                            <form action="{{ url('select-subject') }}" method="POST">
                                @csrf
                            @if (empty($scheds) || count($scheds) == 0)
                                <tr>
                                    <div class="alert alert-danger">No schedules found. Please select a section.</div>
                                </tr>
                            @else
                                @foreach ($scheds as $sched)
                                <tr>
                                    <input type="hidden" value="{{$selectedSection}}" name="selected_section">
                                    <input type="hidden" value="{{Auth::user()->id}}" name="stud_id">
                                    <input type="hidden" value="{{$sched->section->section_id}}" name="section_id">
                                    <input type="hidden" value="{{$track}}" name="track">
                                    <td><div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{$sched->sched_id}}" name="inputs[]selectedSub" id="selectedSubs" >
                            
                                    </div></td>
                                <td>{{$sched->schoolYear->school_year}}</td>
                                <td>{{$sched->section->section_name}}</td>
                                @if(!empty($sched->subject))
                                <td>{{$sched->subject->subject_name}}</td>
                                @endif
                                <td>{{$sched->semester}}</td>
                                <td>{{$sched->days}}</td>
                                <td>{{$sched->time_start}}</td>
                                <td>{{$sched->time_end}}</td>
                                    @if(!empty($sched->teacher))
                                    <td>{{$sched->teacher->first_name . " " . $sched->teacher->middle_name . " " . $sched->teacher->last_name . " " . $sched->teacher->suffix}}</td>
                                    @else
                                    <td>No Assigned Teacher</td>
                                    @endif
                                    @if(!empty($sched->room))
                                    <td>{{$sched->room->room_number}}</td>
                                    @else
                                    <td>No Assigned Room</td>
                                    @endif
                                </tr>
                                @endforeach
                            @endif
                        

                        </tbody>
                    </table>
                    <hr>
                    <button type="submit" class="btn btn-success float-end btn-lg mt-3"><i class="fas fa-arrow-right"></i> Proceed to Next Step</button>
                </div>
                </form>
            @endif
            @else
            <div class="alert alert-success" role="alert" >You are already enrolled. Kindly check the account and assessments tab for the total summation of your fees.</div>
            @endif
            @endif
        @endif
    </div>  
@endsection
@section('scripts')

  

@endsection