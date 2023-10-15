@extends('layouts.master')
@section('content')
    <div class="card vh-100">
        <div class="card-header tableCardHeader">
            @if (Auth::user()->role == "Student")
                <h3><i class="fas fa-dollar-sign"></i> Grades</h3>
                @else
                    @foreach ($student as $stud )
                    <input type="hidden" class="student_id" id="student_id"  value="{{$stud->id}}">
                    <h3><i class="fas fa-dollar-sign"></i> Grades of {{$stud->first_name . " " . $stud->middle_name . " " . $stud->last_name . " " . $stud->suffix}} </h3>
                    @endforeach
                @endif
        </div>
        
            @if (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
            @endif

            @if (session('alert'))
            <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
            @endif
        
         @if(!empty($selectedSy))
         <div class="alert alert-success m-3">
            @foreach($selectedSy as $year)
            <h5>S.Y {{$year->school_year}}</h5>
            
           @endforeach
           <h5>Grade Lvl: {{$gradelvl->subject_grade_lvl}}</h5>
         </div>
        @endif
       
         @if(!empty($mygrades))
            <div class="accordion p-3" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        Subjects & Grades
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body">
                            <table class="table table-hover table-borderless">
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
                                    @endphp
                                    @foreach ($mygrades as $mygrade)
                                    <tr>
                                        <input type="hidden" value="{{$gradelvl->semester}}" id="grade_lvl" name="grade_lvl" lass="delete_val">
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
                                                @if(!empty($mygrade->frth_grade))
                                                    <td>{{$average = round(($mygrade->frth_grade + $mygrade->frst_grade + $mygrade->thrd_grade + $mygrade->scnd_grade) / 4) }}</td>
                                                    @php
                                                        $averages = $averages + $average;
                                                        $c++;
                                                    @endphp
                                                @else
                                                    <td></td>
                                                @endif
                                                @if(!empty($mygrade->frth_grade))
                                                    @if(round(($mygrade->frst_grade + $mygrade->scnd_grade + $mygrade->thrd_grade + $mygrade->frth_grade) / 4) >= 75)
                                                    <td>PASSED</td>
                                                    @else
                                                    <td>FAILED</td>
                                                    @endif
                                                @else
                                                    <td></td>
                                                @endif
                                            @else
                                                @if(!empty($mygrade->scnd_grade))
                                                <td>{{$average = round(($mygrade->frst_grade + $mygrade->scnd_grade) / 2) }}</td>
                                                    @php
                                                        $averages = $averages + $average;
                                                        $c++;
                                                    @endphp
                                                    @if(round(($mygrade->frst_grade + $mygrade->scnd_grade ) / 2) >= 75)
                                                    <td>PASSED</td>
                                                    @else
                                                    <td>FAILED</td>
                                                    @endif
                                                @else
                                                <td></td>
                                                <td></td>
                                                @endif
                                            @endif
                            
                                    </tr>
                                    @endforeach
                                </tbody>
                                <p><small class="fw-bold">General Weighted Average:
                                    @if($c == count($mygrades)) {{ ($fave = $averages / $c) }} @endif</small></p>
                                <input type="hidden" name="average" value={{$fave}}>
                            </table>
                            {{-- @php
                                echo(implode(" ",$averages));
                            @endphp --}}
                            
                            <a type="button" class="btn btn-success btn-lg mt-3 promoteBtn"> Promote</a>
                            <a type="button" class="btn btn-warning btn-lg mt-3 retainBtn"> Retain</a>
                            <a type="button" class="btn btn-danger btn-lg mt-3 demoteBtn"> Demote</a>
                            
                        </div>
                  </div>
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
            // alert(gl);
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