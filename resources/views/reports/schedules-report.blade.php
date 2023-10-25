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
        body {
            font-family: 'Open Sans', sans-serif;
            /* background-color: #f2f2f2; */
            margin: 0;
        }

        .logo {
            text-align: center;
            margin: 0;

        }

        .logo img {
            width: 100px;
        }

        .school-name {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            color: #4784e8;
        }

        .school-address {
        }

        .header {
            background-color: #4784e8;
            padding: 10px;
            text-align: center;
        }

        h5 {
            text-align: center;
            margin: 10px;
        }

        .user-info {
            text-align: center;
        }

        .user-info h6 {
            font-weight: 600;
            margin: 5px 0;
        }

        .table {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .table th,
        .table td {
            padding: 10px;
        }

        .table th {
            background-color: #4784e8;
            color: #fff;
        }

        .table td {
            background-color: #f9f9f9;
        }

        .m-3 {
            margin: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="logo">
        <img src="{{ public_path('img/logo4.png') }}" alt="Educare College Inc. Logo">
        <p class="school-name">Educare College Inc.</p>
        <p class="school-address">Irisan, Baguio City, Philippines, 2600</p>
    </div>
    
    <b>School Year: </b>{{ $year }} <br>

    @if(Auth::user()->role != "Principal" )
    @if(Auth::user()->role == "Teacher" )
    Teacher Name: {{Auth::user()->last_name . ", " . Auth::user()->first_name . " " . Auth::user()->middle_name . " " . Auth::user()->suffix}}
    @else
    <b> Student Name: </b> {{Auth::user()->last_name . ", " . Auth::user()->first_name . " " . Auth::user()->middle_name . " " . Auth::user()->suffix}} <br>
    <b>Grade Level: </b>{{$glvl}} <br>
    <b>Section: </b>{{$section}}
    @endif
    @else
    <b>Grade Level: </b>{{$glvl}} <br>
    <b>Section: </b>{{$section}}
    @endif
    <!-- <div style="background-color: blue"></div> -->
    <div class=" text-uppercase text-center"><b>Student Enrolled Subjects</b></div>

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