@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header tableCardHeader">
            <h3><i class="fas fa-calendar-alt"></i> Schedule</h3>
        </div>
            @if(Auth::user()->student->enrollment_status == '1')

            <table class="table table-sm">
                <thead class="table-primary">
                    <tr>
                        <th>Section</th>
                        <th>Subject Name</th>
                        <th>Semester</th>
                        <th>Days</th>
                        <th>Time Start</th>
                        <th>Time End</th>
                        <th>Room</th>
                    
                    </tr>
                </thead>
                <tbody>
                    <form action="{{url('schedule-report')}}" method="POST">
                        @csrf
                        <div class="me-3">
                            <button type="submit" class="btn btn-outline-danger float-end mt-3 mb-3"><i class="fas fa-file-export"></i> Generate Report</button>
                        </div>
                       
                        @foreach ($scheds as $sched)
                        <tr>
                            <input type="hidden" class="delete_val" name="id[]"  value="{{$sched->sched_id}}">
                        <td>{{$sched->section_name}}</td>
                        <td>{{$sched->subject_name}}</td>
                        <td>{{$sched->semester}}</td>
                        <td>{{$sched->days}}</td>
                        <td>{{$sched->time_start}}</td>
                        <td>{{$sched->time_end}}</td>
                        @if(!empty($sched->room))
                        <td>{{$sched->room->room_number}}</td>
                        @else
                        <td>No Assigned Room</td>
                        @endif
                        </tr>
                        @endforeach
                    </form>
                </tbody>
            </table>
            <div class="m-3" id="calendar">
                
            </div>
            @else
            <div class="alert alert-warning">
                You are not currently enrolled.
            </div>
      
            @endif
    </div>  
@endsection
@section('scripts')

    <script src="{{ asset('calendar\index.global.js') }}"></script>

    <script type="text/javascript">
    @if(!empty($scheds))
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
           

            events.push({
            
                title: '{{ $sched->subject_name }}',
                daysOfWeek: schedDays, 
                startTime: '{{ $sched->time_start }}',
                endTime: '{{ $sched->time_end }}',
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
   
    </script>

@endsection