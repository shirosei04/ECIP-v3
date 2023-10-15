@extends('layouts.master')
@section('title', 'Scheduling')

@section('content')
{{-- <div class="container-fluid"> --}}
        <div class="card">
            <div class="card-header tableCardHeader">
                <h3><i class="fas fa-calendar-alt"></i> View Plotted Schedules</h3>
            </div>

            <form action="{{url('filter-plot-schedules')}}">
                <div class="row p-3" >
                        <div class="col-2">
                            <select class="form-select" aria-label="Default select example" name="sy_filter">
                                <option value="" selected>Choose School Year</option>
                                @foreach($allsy as $sy)
                                <option value="{{$sy->school_year}}">{{$sy->school_year}}</option>
                                @endforeach
                            </select>
                        </div>
                  
                        <div class="col-2">
                            <select class="form-select" aria-label="Default select example" name="section_filter">
                                <option value=""  selected>Filter Section</option>
                                @foreach($sections as $section)
                                <option value="{{$section->section_name}}">{{$section->section_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-2">
                            <select class="form-select" name="track_filter">
                                <option value="" selected>Filter by Track</option>
                                <option value="ABM">ABM</option>
                                <option value="GAS">GAS</option>
                                <option value="HUMSS">HUMSS</option>
                                <option value="STEM">STEM</option>
                                <option value="TVL">TVL</option>
                                <option value="Not Applicable">Not Applicable</option>
                            </select>
                        </div>
                        
                        <div class="col-2">
                            <select class="form-select" name="semester_filter">
                                <option value="" selected>Filter by Semester</option>
                                <option value="1st">1st</option>
                                <option value="2nd">2nd</option>
                                <option value="Not Applicable">Not Applicable</option>
                            </select>
                        </div>

                        <div class="col-1">
                          <button type="submit"  class="btn btn-success"><i class="fas fa-filter"></i></button>
                          <a type="button" href="{{url('/viewplotsched')}}"  class="btn btn-primary"><i class="fas fa-sync-alt"></i></a>
                        </div>

                        <div class="col-3">
                            <a href="{{url('set-schedules')}}" type="button"  class="btn btn-success float-end"><i class="fas fa-calendar-alt"></i> View Schedules List</a>
                        </div>

                </div>
            </form>

            @if (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
            @endif

            @if (session('alert'))
                <div class="alert alert-danger">{{ session('alert') }}</div>
            @endif
        
            <div class="card-body table-responsive">
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
                        @if (count($scheds) == 0)
                            <tr>
                                <div class="alert alert-danger">Please select a filter  </div>
                            </tr>
                        @else
                        <form action="{{url('schedule-report')}}" method="POST">
                            @csrf
                           
                            @if($syfilter != "")
                            <div class="alert alert-success" role="al ert">Filter result(s) for "<strong style="color: red">{{"S.Y:  " . $syfilter . ", Section: " . $sectionfilter . ", Track: " . $trackfilter . ", Semester: " . $semesterfilter }}"</strong></div>
                            @endif

                            <button type="submit" class="btn btn-outline-danger float-end mt-3 mb-3"><i class="fas fa-file-export"></i> Generate Report</button>

                                @foreach ($scheds as $sched)
                                <tr>
                                <input type="hidden" class="delete_val" name="id[]"  value="{{$sched->sched_id}}">
                                <td>{{$sched->schoolYear->school_year}}</td>
                                <td>{{$sched->section->section_name}}</td>
                                <td>{{$sched->subject->subject_name}}</td>
                                <td>{{$sched->semester}}</td>
                                <td>{{$sched->days}}</td>
                                <td>{{$sched->time_start}}</td>
                                <td>{{$sched->time_end}}</td>
                                @if(!empty($sched->teacher))
                                <td>{{$sched->teacher->first_name . " " . $sched->teacher->middle_name . " " . $sched->teacher->last_name . " " . $sched->teacher->suffix}}</td>
                                @else
                                <td>No Assigned Teacher</td>
                                @endif
                                {{-- <td>{{$sched->teacher->first_name}}</td> --}}
                                @if(!empty($sched->room))
                                <td>{{$sched->room->room_number}}</td>
                                @else
                                <td>No Assigned Room</td>
                                @endif
                                @endforeach
                            @endif
                       
                        </form>
                    </tbody>
                </table>
                {{-- calendar --}}
                
                <div id="calendar">
             
                </div>
            </div>

       
    </div>
    
{{-- </div> --}}
@endsection

@section('scripts')

    {{-- <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $('.deleteButton').click(function (e) {
                e.preventDefault();
                
                var delete_id = $(this).closest("tr").find('.delete_val').val();
                // alert(delete_id);
                    swal({
                    title: "Are you sure?",
                    text: "Once deleted, you cannot undo it",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {

                            var data = {
                                "_token": $('input[name="_token"]').val(),
                                "id": delete_id,
                            };
                            $.ajax({
                                type: "DELETE",
                                url: '/delete-sched/'+delete_id,
                                data: data,
                                success: function (response) {
                                    swal('Schedule Deleted Successfully' , {
                                        icon: "success",
                                    }) 
                                    .then((result) => {
                                        // window.location.reload();
                                        window.location.href = '/set-schedules';
                                    });
                                }
                            });

                            
                        } else {
                            swal("No Changes Made :)");
                        }
                });
            });
                            
        });


        
    </script> --}}
    <script src="{{ asset('calendar\index.global.js') }}"></script>

    <script type="text/javascript">
        var events = new Array();
       
        @foreach($scheds as $sched)
        var days;
        var schedDays = [];
            days = '{{ $sched->days }}';
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
            // @if($sched->days == "M,T,W,Th,F")
            //     schedDays.push(1,2,3,4,5)
            // @elseif($sched->days == "M")
            //     schedDays.push(1)
            // @elseif($sched->days == "T")
            //     schedDays.push(2)
            // @elseif($sched->days == "W")
            //     schedDays.push(3)
            // @elseif($sched->days == "Th")
            //     schedDays.push(4)
            // @elseif($sched->days == "F")
            //     schedDays.push(5)
            // @elseif($sched->days == "M,T")
            //     schedDays.push(1,2)
            // @elseif($sched->days == "M,T,W")
            //     schedDays.push(1,2,3)
            // @elseif($sched->days == "M,T,W,Th")
            //     schedDays.push(1,2,3,4)
            // @elseif($sched->days == "M,W")
            //     schedDays.push(1,3)
            // @elseif($sched->days == "M,T")
            //     schedDays.push(1,2)
            // @elseif($sched->days == "M,Th")
            //     schedDays.push(1,4)
            // @elseif($sched->days == "M,F")
            //     schedDays.push(1,5)
            // @elseif($sched->days == "W,Th")
            //     schedDays.push(3,4)
            // @endif

            events.push({
                //how will i get all these data per schedule
                title: '{{ $sched->subject->subject_name }}',
                daysOfWeek: schedDays, 
                startTime: '{{ $sched->time_start }}',
                endTime: '{{ $sched->time_end }}',
                extendedProps: {
                    Teacher: 'brh'
                },
                description: 'bruh',
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
    </script>

@endsection