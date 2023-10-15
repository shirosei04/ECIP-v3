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
    {{-- <h5 class="mt-1">School Year {{$year}}</h5> --}}
    
    {{-- @if(Auth::user()->role != "Principal" )    
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
    @endif --}}
    @if (Auth::user()->role == "Student")
    Student Name: {{Auth::user()->last_name . ", " . Auth::user()->first_name . " " . Auth::user()->middle_name . " " . Auth::user()->suffix}}
    
    @else
    Student Name: {{$gradelvl->last_name . ", " . $gradelvl->first_name . " " . $gradelvl->middle_name . " " . $gradelvl->suffix}}
 
    @endif
    <h6>General Average: {{$average}}</h6>
    <h6>{{$gradelvl->school_year}}</h6>

    <div style="background-color: blue"></div>

    <div class="card-body" style="margin-top: 15px;">
        <table class="table">
            <thead class="table-primary">
                <tr>
                    <td>Section</td>
                    <th width="50%">Subject</th>
                    <th>1st</th>
                    <th>2nd</th>
                    {{-- IF SUBJECT IS NOT FOR GRADE 11 OR 12 --}}
                    @if($gradelvl->subject_grade_lvl != "Grade 11" && $gradelvl->subject_grade_lvl != "Grade 12")
                    <th>3rd</th>
                    <th>4th</th>
                    @endif
                    <th>Average</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($grades as $mygrade)
                    <tr>
                       <td>{{$mygrade->section_name}}</td>
                       <td>{{$mygrade->subject_name}}</td>
                    @if ($mygrade->view_status == 1)
                       <td>{{$mygrade->frst_grade}}</td>
                       <td>{{$mygrade->scnd_grade}}</td>
                       {{-- IF SUBJECT IS NOT FOR GRADE 11 OR 12 --}}
                       @if($gradelvl->subject_grade_lvl != "Grade 11" && $gradelvl->subject_grade_lvl != "Grade 12")
                           <td>{{$mygrade->thrd_grade}}</td>
                           <td>{{$mygrade->frth_grade}}</td>
                           {{-- IF MAY FOURTH GRADE NA, CALCULATE AVERAGE --}}
                           @if(!empty($mygrade->frth_grade))
                           <td>{{round(($mygrade->frth_grade + $mygrade->frst_grade + $mygrade->thrd_grade + $mygrade->scnd_grade) / 4) }}</td>
                           @endif
                             {{-- IF MAY FOURTH GRADE NA, CALCULATE UNG STATUS --}}
                           @if(!empty($mygrade->frth_grade))
                             {{-- IF HIGHER OR LOWER LANG NG 75 --}}
                               @if(round(($mygrade->frst_grade + $mygrade->scnd_grade + $mygrade->thrd_grade + $mygrade->frth_grade) / 4) >= 75)
                               <td>PASSED</td>
                               @else
                               <td>FAILED</td>
                               @endif
                           @else
                               <td></td>
                               <td></td>
                           @endif
                       @else
                            {{-- IF SUBJECT IS FOR GRADE 11 OR 12 --}}
                           @if(!empty($mygrade->scnd_grade))
                               <td>{{round(($mygrade->frst_grade + $mygrade->scnd_grade) / 2) }}</td>
                                   @if(round(($mygrade->frst_grade + $mygrade->scnd_grade) / 2) >= 75)
                                   <td>PASSED</td>
                                   @else
                                   <td>FAILED</td>
                                   @endif
                           @endif
                           <td></td>
                           <td></td>
                       @endif
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        @if($gradelvl->subject_grade_lvl != "Grade 11" && $gradelvl->subject_grade_lvl != "Grade 12")
                        <td></td>
                        <td></td>
                        @endif
                    @endif
                   </tr>
                   @endforeach
            </tbody>
        </table>
    </div>
</body>


</html>

   