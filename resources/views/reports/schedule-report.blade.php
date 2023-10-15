<!DOCTYPE html>
<html lang="en">
<head>
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery_3.6.0_jquery.min.js') }}"></script> --}}

    {{-- Font --}}
    {{-- <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet"> --}}

    {{-- Styles --}}
    <link href="{{public_path('css/bootstrap.min.css')}}" rel="stylesheet">
    <style>
        body{
            font-family: 'Sans-serif';
        }
  
        th, td {
            padding: 8px;
            text-align: left;
           
        }

        thead{
            background-color: rgb(131, 166, 219);
        }

        .logo{
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            margin-top: -20px;
        }

    </style>
</head>
<body>
    <div class="logo" style="margin: 0"></span>
    <span style="font-size: 40px;  " class="fw-bold"><img style="width: 100px; " class="ms-auto me-auto" src="{{ public_path('img/logo4.png') }}" alt="">
    Educare College Inc.</span>
    <p style="margin: 0 0 3px 0">Irisan, Baguio City</p>
    </div>
    <div style="background-color: blue"></div>
    <h5 class="mt-1">School Year {{$year}}</h5>
    
    @if(Auth::user()->role != "Principal" )    
        @if(Auth::user()->role == "Teacher" )  
        Teacher Name: {{Auth::user()->last_name . ", " . Auth::user()->first_name . " " . Auth::user()->middle_name . " " . Auth::user()->suffix}}
        @else
        Student Name: {{Auth::user()->last_name . ", " . Auth::user()->first_name . " " . Auth::user()->middle_name . " " . Auth::user()->suffix}}
        <h6>{{$glvl}}</h6>
        <h6>{{$section}}</h6>
        @endif
    @else
        <h6>{{$glvl}}</h6>
        <h6>{{$section}}</h6>
    @endif
    <div style="background-color: blue"></div>

    <div class="card-body" style="margin-top: 15px;">
        <table class="table">
            <thead class="table-primary">
                <tr>
                    <th>Subject Name</th>
                    <th>Section</th>
                    <th>Days</th>
                    <th>Time Start</th>
                    <th>Time End</th>
                    <th>Teacher</th>
                    <th>Room</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($generals as $sched)
                    <tr>
                    <td>{{$sched->section_name}}</td>
                    <td>{{$sched->subject_name}}</td>
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
                    @endforeach
            </tbody>
        </table>
        <div class="m-3" id="calendar">

        </div>
    </div>
</body>


</html>

   