@extends('layouts.master')
@section('content')
    <div class="card vh-100">
        <div class="card-header tableCardHeader">
                <h3><i class="fas fa-dollar-sign"></i> Grades</h3>
        </div>
        
            @if (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
            @endif

            @if (session('alert'))
            <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
            @endif
        

        @if(!empty($mygrades))
        <div class="card m-3">
            <div class="card-header">
                <h6>Student: {{$student->last_name . ", " . $student->first_name . " " . $student->middle_name . " " . $student->suffix }}</h6>
                <h6>School Year: {{$selectedSy->school_year}}</h6>
                <h6>Semester: {{$semester}}</h6>
                <h6>Grade: @if($student->student->grade_lvl == 0)Kinder @else {{$student->student->grade_lvl}}@endif</h6>
                <h6>Section: {{$section}}</h6>
            </div>
            <div class="card-body">

      
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <td>Section</td>
                        <th width="50%">Subject</th>
                        <th>1st</th>
                        <th>2nd</th>
                        @if($gradelvl->subject_grade_lvl != "Grade 11" && $gradelvl->subject_grade_lvl != "Grade 12")
                        <th>3rd</th>
                        <th>4th</th>
                        @endif
                        <th>Average</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $averages = 0;
                        $c = 0;
                        $fave = 0;
                        $fails = 0;
                    @endphp
                    @foreach ($mygrades as $mygrade)
                    <tr>
                        <input type="hidden" value="{{$mygrade->semester}}" id="grade_lvl" name="grade_lvl" class="delete_val">
                        <input type="hidden" value="{{$student->id}}" id="student_id">
                        <input type="hidden" value="{{$mygrade->sg_id}}" class="delete_val">
                        <td>{{$mygrade->section_name}}</td>
                        <td>{{$mygrade->subject_name}}</td>
                            {{-- if grade = approved --}}
                        <td>{{$mygrade->frst_grade}}</td>
                        <td>{{$mygrade->scnd_grade}}</td>
                            {{-- FOR GRADE 1 - 10 --}}
                            @if($gradelvl->subject_grade_lvl != "Grade 11" && $gradelvl->subject_grade_lvl != "Grade 12")
                                <td>{{$mygrade->thrd_grade}}</td>
                                <td>{{$mygrade->frth_grade}}</td>
                            
                                @if (!empty($mygrade->frth_grade & $mygrade->frst_grade & $mygrade->thrd_grade & $mygrade->scnd_grade))
                                    @if($mygrade->frth_grade == "INC" | $mygrade->frst_grade == "INC" | $mygrade->thrd_grade == "INC" | $mygrade->scnd_grade == "INC")
                                    <td>{{$status="INC"}}</td>
                                    @php
                                        $fails++;
                                    @endphp
                                    @elseif($mygrade->frth_grade == "NG" | $mygrade->frst_grade == "NG" | $mygrade->thrd_grade == "NG" | $mygrade->scnd_grade == "NG")
                                    <td>{{$status="NG"}}</td>
                                    @php
                                    $fails++;
                                    @endphp
                                    @else
                                    <td>{{$average = round(($mygrade->frst_grade + $mygrade->scnd_grade + $mygrade->thrd_grade + $mygrade->frth_grade) / 4)}}</td>
                                    @php
                                    if($average < 75){
                                        $fails++;
                                    }
                                    $averages = $averages + $average;
                                    $c++;
                                    @endphp
                                    @endif
                                 
                                    @else
                                    {{-- KUNG WALA PANG FOURTH GRADE, TD MUNA --}}
                                        <td></td>
                                @endif

                                @if(!empty($mygrade->frth_grade) & !empty($mygrade->frst_grade) & !empty($mygrade->scnd_grade) & !empty($mygrade->thrd_grade))
                                    @if($mygrade->frth_grade == "INC" | $mygrade->frst_grade == "INC" | $mygrade->thrd_grade == "INC" | $mygrade->scnd_grade == "INC")
                                    <td>{{$status}}</td>
                                    @php
                                    $fails++;
                                     @endphp
                                    @elseif($mygrade->frth_grade == "NG" | $mygrade->frst_grade == "NG" | $mygrade->thrd_grade == "NG" | $mygrade->scnd_grade == "NG")
                                    <td>{{$status}}</td>
                                    @php
                                    $fails++;
                                    @endphp
                                    @else
                                        @if(round(($mygrade->frst_grade + $mygrade->scnd_grade + $mygrade->thrd_grade + $mygrade->frth_grade) / 4) >= 75)
                                        <td>PASSED</td>
                                        @else
                                        <td>FAILED</td>
                                        @endif 
                                    @endif
                                {{-- KUNG WALA PANG FOURTH GRADE, TD MUNA --}}
                                @else
                                    <td></td>
                                @endif
                            @else
                                    @if(!empty($mygrade->frst_grade) & !empty($mygrade->scnd_grade))
                                    @if($mygrade->frst_grade == "INC" | $mygrade->scnd_grade == "INC")
                                    <td>INC</td>
                                    @elseif($mygrade->frst_grade == "NG" | $mygrade->scnd_grade == "NG")
                                    <td>NG</td>
                                    @else
                                    <td>{{$average = round(($mygrade->frst_grade + $mygrade->scnd_grade) / 2) }}</td>
                                        @php
                                          if($average < 75){
                                            $fails++;
                                          }
                                        $averages = $averages + $average;
                                        $c++;
                                      
                                        @endphp
                                    @endif
                                @else
                                {{-- KUNG WALA PANG SECOND GRADE, EDI TD MUNA --}}
                                <td></td>
                                @endif
                                {{-- SINCE TWO TERMS LANG ANG SHS, PAG MAY SCND GRADE NA, CALCULATE STATUS --}}
                                @if(!empty($mygrade->frst_grade) & !empty($mygrade->scnd_grade))
                                    @if($mygrade->frst_grade == "INC" | $mygrade->scnd_grade == "INC")
                                    <td>INC</td>
                                    @elseif($mygrade->frst_grade == "NG" | $mygrade->scnd_grade == "NG")
                                    <td>NG</td>
                                    @else
                                        @if(round(($mygrade->frst_grade + $mygrade->scnd_grade) / 2) >= 75)
                                        <td>PASSED</td>
                                        @else
                                        <td>FAILED</td>
                                        @endif 
                                    @endif
                                @else
                                    <td></td>
                                @endif
                            @endif
            
                    </tr>
                    @endforeach
                </tbody>
                <p><small class="fw-bold">General Weighted Average:
                    @if($c == count($mygrades)) {{ number_format(($fave = $averages / $c), 2) }} @endif</small></p>
                <input type="hidden" name="average" value={{$fave}}>
            </table>
                {{-- @php
                    echo($c . " != " . count($mygrades) );
                    
                @endphp --}}
            @if($c != count($mygrades))
                <button type="button" class="btn btn-success btn-lg mt-3 promoteBtn" disabled> Promote</button>
            @else
                @if($fails >= 1)
                    <a type="button" class="btn btn-warning btn-lg mt-3 retainBtn"> Retain</a>
                @else
                    <a type="button" class="btn btn-success btn-lg mt-3 promoteBtn"> Promote</a>
                @endif
            @endif
            <a type="button" class="btn btn-danger btn-lg mt-3 float-end demoteBtn"> Demote</a>
        </div>
        </div>
        {{-- </form> --}}
        @endif
        
    </div>  
@endsection
@section('scripts')
<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //promote student
        $('.promoteBtn').click(function (e) {
            e.preventDefault();
            var id = document.getElementById("student_id").value;
            var gl = document.getElementById("grade_lvl").value;
            alert(gl);
                swal({
                title: "Are you sure?",
                text: "This student will be promoted to the next grade level/semester",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var data = {
                            // "_token": $('input[name="_token"]').val(),
                            "id": id,
                            "gl": gl,
                        };
                        $.ajax({
                            type: "POST",
                            url: 'promote-student/'+id+'/'+gl,
                            data: data,
                            success: function (response) {
                                swal('Student Promoted Successfully' , {
                                    icon: "success",
                                })
                                .then((result) => {
                                //    window.location.href = '/class-list';
                                history.go(-1);
                                });
                            },
                            
                        });
                    } else {
                        swal("No Changes Made :)");
                    }
            });
        });

        //demote student
        $('.demoteBtn').click(function (e) {
            e.preventDefault();
            var id = document.getElementById("student_id").value;
            alert(id);
                swal({
                title: "Are you sure?",
                text: "This student will go 1 grade level down",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var data = {
                            "_token": $('input[name="_token"]').val(),
                            "id": id,
                        };
                        $.ajax({
                            type: "GET",
                            url: 'demote-student/'+id,
                            data: data,
                            success: function (response) {
                                swal('Student Demoted Successfully' , {
                                    icon: "success",
                                })
                                .then((result) => {
                                history.go(-1);
                                });
                            },
                            
                        });
                    } else {
                        swal("No Changes Made :)");
                    }
            });
        });

        $('.retainBtn').click(function (e) {
            e.preventDefault();
            var id = document.getElementById("student_id").value;
            alert(id);
                swal({
                title: "Are you sure?",
                text: "This student will retain his/her current grade level",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var data = {
                            "_token": $('input[name="_token"]').val(),
                            "id": id,
                        };
                        $.ajax({
                            type: "GET",
                            url: 'retain-student/'+id,
                            data: data,
                            success: function (response) {
                                swal('Student Retained Successfully' , {
                                    icon: "success",
                                })
                                .then((result) => {
                                history.go(-1);
                                });
                            },
                            
                        });
                    } else {
                        swal("No Changes Made :)");
                    }
            });
        });
                        
    });
</script>
@endsection