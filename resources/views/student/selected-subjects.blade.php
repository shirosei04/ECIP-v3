@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header tableCardHeader">
            <h3><i class="fas fa-calendar-alt"></i> Enrollment</h3>
        </div>
            @if (session('alert'))
            <div class="alert alert-success" role="alert">{{ session('alert') }}</div>
            @endif
        {{-- <form action="{{ url('select-section') }}">
            <div class="row p-3" >
                <div class="col-md-3">

                    <select class="form-select" aria-label="Default select example" name="select_section">
                        <option value=""  selected>Select Section</option>
                        @foreach($sections as $section)
                        <option value="{{$section->section_id}}" >{{$section->section_name}}</option>
                        @endforeach
                    </select>
                    <label for="" class="col-form-label text-start fw-bold" style="color: red">Step 1: Select a section</label>
                </div>
                <div class="col-3">
                    <button type="submit"  class="btn btn-success"><i class="fas fa-filter"></i></button>
                </div>
            </div>
        </form> --}}
            {{-- @if (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
            @endif

            @if(empty($ifActiveSy))
            <div class="alert alert-danger" role="alert" >The principal has not activated the enrollment yet</div>
            @endif --}}

        @if(count($scheds) != 0)
            <div class="card-body table-responsive">
                {{-- <div class="row ">
                    <div class="col">
                        <button type="submit"  class="btn btn-success float-end btn-lg mb-3"><i class="fas fa-arrow-right"></i> Proceed to Enroll</button>
                    </div>
                </div> --}}
                {{-- <label for="" class="col-6 col-form-label text-start fw-bold" style="color: red">Step 2: VIEW and SELECT the subjects to be enrolled</label> --}}
          
                <h3 class="text-center fw-bold pb-3">YOU ARE ABOUT TO ENROLL THESE SELECTED SUBJECTS</h3>
                <label for="" class="col-6 col-form-label text-start fw-bold" style="color: red">Step 3: Review the subjects selected</label>
                <table class="table table-sm">
                    <thead class="table-primary">
                        <tr>
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
                        <form action="{{ url('enroll-student') }}" method="POST" id="enrollmentForm">
                            @csrf
                            {{-- @method('PUT') --}}
                        @if (empty($scheds) || count($scheds) == 0)
                            <tr>
                                <div class="alert alert-danger">No schedules found. Please select a section.</div>
                            </tr>
                        @else
                            @foreach ($scheds as $sched => $value)
                            <tr>
                            <input type="hidden" value="{{Auth::user()->id}}" name="stud_id">
                            <input type="hidden" value="{{$selectedSection}}" name="selected_section">
                            <input type="hidden" value="{{$value[0]->sched_id}}" name="inputs[]sched_id">
                            <td>{{$value[0]->schoolYear->school_year}}</td>
                            <td>{{$value[0]->section->section_name}}</td>
                            @if(!empty($value[0]->subject))
                            <td>{{$value[0]->subject->subject_name}}</td>
                            @endif
                            <td>{{$value[0]->semester}}</td>
                            <td>{{$value[0]->days}}</td>
                            <td>{{$value[0]->time_start}}</td>
                            <td>{{$value[0]->time_end}}</td>
                                @if(!empty($value[0]->teacher))
                                <td>{{$value[0]->teacher->first_name . " " . $value[0]->teacher->middle_name . " " . $value[0]->teacher->last_name . " " . $value[0]->teacher->suffix}}</td>
                                @else
                                <td>No Assigned Teacher</td>
                                @endif
                                @if(!empty($value[0]->room))
                                <td>{{$value[0]->room->room_number}}</td>
                                @else
                                <td>No Assigned Room</td>
                                @endif
                            </tr>
                            @endforeach
                        @endif
                       

                    </tbody>
                </table>
                <hr>
                <h3 class="text-center fw-bold">PLOTTED SCHEDULE VIEW</h3>
                <div id="calendar">
             
                </div>
                {{-- <div class="row">
                    <div class="col-md-6">
                        <label for="" class="col-6 col-form-label text-start fw-bold">Step 3: Select a payment type</label>
                        <select class="form-select form-select-sm" aria-label="Default select example" name="role" required>
                            <option value="" selected>Choose Payment Type</option>
                            <option value="Staggered" selected>Staggered Payment</option>
                            <option value="Full Payment" >Full Payment</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <button type="submit"  class="btn btn-success float-end btn-lg mt-3"><i class="fas fa-arrow-right"></i> Proceed to Next Step</button>
                    </div>
                </div> --}}
     
                <div class="d-flex mt-3">

                    <a type="button" href="javascript:history.back()" class="col-3 btn btn-primary btn-lg me-2 me-auto"><i class="fas fa-arrow-left"></i> Back to Offered Subjects List</a><br>

                    <button type="submit"  class="col-3 btn btn-success float-end btn-lg me-2 enrollBtn "><i class="fas fa-arrow-right"></i> Enroll Subjects</button><br>
        
                  
                </div>
                
            
                   
            </div>
            </form>
        @endif
        
    </div>  
@endsection
@section('scripts')

    <script src="{{ asset('calendar\index.global.js') }}"></script>

    <script type="text/javascript">
    @if(!empty($scheds))
        var events = new Array();
       
        @foreach($scheds as $sched => $value)
        var days;
        var schedDays = [];
            days = '{{ $value[0]->days }}';
            // days = "M,T,W,Th,F,Sat";
            var splitDays = days.split(",");
            for (var i = 0; i < splitDays.length; i++) {
                    switch(splitDays[i]){
                        case "M":
                            schedDays.push(1)
                            break;
                        case "T":
                            schedDays.push(2)   
                            break;
                        case "W":
                            schedDays.push(3)  
                            break;
                        case "Th":
                            schedDays.push(4)  
                            break;
                        case "F":
                            schedDays.push(5)
                            break;  
                        case "Sat":
                            schedDays.push(6) 
                            break; 
                        case "Sun":
                            schedDays.push(0)  
                            break;
                        default: 
                            console.log('default');
                        break;
                        // console.log(schedDays)
                    }
                }
           

            events.push({
                //how will i get all these data per schedule
                title: '{{ $value[0]->subject->subject_name }}',
                daysOfWeek: schedDays, 
                startTime: '{{ $value[0]->time_start }}',
                endTime: '{{ $value[0]->time_end }}',
                // extendedProps: {
                //     Teacher: 'brh'
                // },
                // description: 'bruh',
            });
        @endforeach

        var calendarID = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarID, {
            headerToolbar: {
                left: '',
                right: 'timeGridWeek,timeGridDay',
               
            },
            dayHeaderFormat: {
                weekday: 'long', 
            },
            slotDuration: '00:30',
            events: events,
            initialView: 'timeGridWeek',
            expandRows: true,
            slotMinTime: '07:00:00',
            slotMaxTime: '19:00:00',
            allDaySlot: false,
          

            
        });

        calendar.render();
    @endif
    //enroll button
     $('.enrollBtn').click(function (e) {
             e.preventDefault();
             // var delete_id = $(this).closest("div").find('.delete_val').val();
             var data = $('#enrollmentForm').serialize();
            // alert(data);
            // alert(delete_id);
             swal({
             title: "Are you sure?",
             text: "Please make sure you have selected all the required subjects in your grade level as you cannot change this afterwards",
             icon: "warning",
            dangerMode: true,
             buttons: true,
             })
             .then(willDelete => {
             if (willDelete) {
               
                 $.ajax({
                    type: "POST",
                     url: 'enroll-student',
                     data: data,
                     success: function (response) {
                         swal('User Enrolled Successfully' , {
                             icon: "success",
                         }) 
                         .then((result) => {
                             window.location.href = '/enrollment';
                         });
                     },
                    error: function (reject) {
                         if(reject.status == 422){
                             swal('Message Cannot be Empty! Please try again.' , {
                             icon: "error",
                             }) 
                             .then((result) => {
                                 window.location.href = '/view-details/'+delete_id;
                             });
                         }
                         else{
                             swal('Something Went Wrong. Please Try Again' , {
                             icon: "error",
                             }) 
                             .then((result) => {
                                 window.location.href = '/view-details/'+delete_id;
                             });
                         }
                     }
                 });
             }
         });
           
     });  
    </script>

@endsection