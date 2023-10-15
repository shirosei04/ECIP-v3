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

        @if(Auth::user()->role == "Student")
        <form action="{{ url('filtered-grades') }}">
            <div class="row p-3" >
                <div class="col-md-3">
                    <input type="hidden" value="{{$studId}}" name="id">
                    <select class="form-select" aria-label="Default select example" name="select_year" required>
                        <option value="" selected>Select School Year</option>
                        @foreach($grades as $grade)
                        <option value="{{$grade->year_id}}" >{{$grade->school_year}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" aria-label="Default select example" name="select_sem" required> 
                        <option value="" selected>Select Semester</option>
                        <option value="1st" >1st</option>
                        <option value="2nd" >2nd</option>
                        <option value="Not Applicable" >Not Applicable</option>
                    </select>
                </div>
                <div class="col-3">
                    <button type="submit"  class="btn btn-success"><i class="fas fa-filter"></i></button>
                </div>
            </div>
        </form>
        @else
        <form action="{{ url('ao-filtered-grades') }}">
            <div class="row p-3" >
                <div class="col-md-3">
                    <input type="hidden" value="{{$studId}}" name="id">
                    <select class="form-select" aria-label="Default select example" name="select_year" required> 
                        <option value="" selected>Select School Year</option>
                        @foreach($grades as $grade)
                        <option value="{{$grade->year_id}}" >{{$grade->school_year}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select class="form-select" aria-label="Default select example" name="select_sem" required> 
                        <option value="" selected>Select Semester</option>
                        <option value="1st" >1st</option>
                        <option value="2nd" >2nd</option>
                        <option value="Not Applicable" >Not Applicable</option>
                    </select>
                </div>

                <div class="col-3">
                    <button type="submit"  class="btn btn-success"><i class="fas fa-filter"></i></button>
                </div>
            </div>
        </form>

        @endif
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
                  @if(Auth::user()->role == "Admission Officer")
                  @include('modals.enroll-subject')
                  @include('modals.transfer-section')
                  @endif
                  <form action="{{url('grade-report')}}" method="POST">
                      @csrf
                      <div class="me-3">
                          <button type="submit" class="btn btn-outline-danger float-end mt-3 mb-3"><i class="fas fa-file-export"></i> Generate Report</button>
                      </div>
                  <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body">
                            @if(Auth::user()->role == "Admission Officer")
                                <a data-bs-toggle="modal" data-bs-target="#addNewSubjectModal" class="btn btn-success float-start">Add a subject</a>
                                <a data-bs-toggle="modal" data-bs-target="#transferModal" class="btn btn-warning float-start ms-2">Transfer Section</a>
                                <table class="table table-hover  table-borderless">
                                <thead>
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $averages = 0;
                                    $c = 0;
                                    $average = 0;
                                    $fave = 0;
                                    @endphp
                                     @foreach ($mygrades as $mygrade)
                                     <tr>
                                        <input type="hidden" class="delete_val" id="delete_val" name="id[]" value="{{$mygrade->sg_id}}">
                                        <td>{{$mygrade->section_name}}</td>
                                        <td>{{$mygrade->subject_name}}</td>
                                        <td>{{$mygrade->frst_grade}}</td>
                                        <td>{{$mygrade->scnd_grade}}</td>
                                        {{-- IF SUBJECT IS NOT FOR GRADE 11 OR 12 --}}
                                        @if($gradelvl->subject_grade_lvl != "Grade 11" && $gradelvl->subject_grade_lvl != "Grade 12")
                                            <td>{{$mygrade->thrd_grade}}</td>
                                            <td>{{$mygrade->frth_grade}}</td>
                                            @if(!empty($mygrade->frth_grade))
                                            <td>{{$average = round(($mygrade->frth_grade + $mygrade->frst_grade + $mygrade->thrd_grade + $mygrade->scnd_grade) / 4)}}</td>
                                            @endif
                                            @php
                                            $averages = $averages + $average;
                                            $c++;
                                            @endphp
                                            @if(!empty($mygrade->frth_grade))
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
                                                <td>{{$average = round(($mygrade->frst_grade + $mygrade->scnd_grade) / 2) }}</td>
                                                @php
                                                $averages = $averages + $average;
                                                $c++;
                                               @endphp
                                                    @if(round(($mygrade->frst_grade + $mygrade->scnd_grade) / 2) >= 75)
                                                    <td>PASSED</td>
                                                    @else
                                                    <td>FAILED</td>
                                                    @endif
                                            @else
                                                <td></td>
                                                <td></td>
                                            @endif
                                        @endif
                                        <td> <a type="button" class="btn btn-danger deleteBtn"><span class="btn-label"><i class="fas fa-trash"></i></span></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <br><br>  <p><small class="fw-bold">General Weighted Average:
                                    @if($c == count($mygrades)) {{ ($fave = $averages / $c) }} @endif</small></p>
                                <input type="hidden" name="average" value={{$fave}}>
                                </table>    
                            @elseif(Auth::user()->role == "Student")
                                <table class="table table-hover table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Section</th>
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
                                        @php
                                        $averages = 0;
                                        $c = 0;
                                        $fave = 0;
                                        @endphp
                                        @foreach ($mygrades as $mygrade)
                                        <tr>
                                           <input type="hidden" class="delete_val" id="delete_val" name="id[]"  value="{{$mygrade->sg_id}}">
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
                                               <td>{{$average = round(($mygrade->frth_grade + $mygrade->frst_grade + $mygrade->thrd_grade + $mygrade->scnd_grade) / 4) }}</td>
                                               @php
                                                  $averages = $averages + $average;
                                                  $c++;
                                               @endphp
                                         
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
                                                   <td>{{$average = round(($mygrade->frst_grade + $mygrade->scnd_grade) / 2) }}</td>
                                                   @php
                                                   $averages = $averages + $average;
                                                   $c++;
                                                  @endphp
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
                                 
                           
                                    {{-- <p><small class="fw-bold">General Weighted Average:@if ($c == count($mygrades)) {{ ($fave = $averages / $c) }} </small></p>
                                    <input type="hidden" name="average" value={{$fave}}>
                                    @endif --}}
                                    <p><small class="fw-bold">General Weighted Average:
                                        @if($c == count($mygrades)) {{ ($fave = $averages / $c) }} @endif</small></p>
                                    <input type="hidden" name="average" value={{$fave}}>
                                    {{-- <td>{{$c . $fave}}</td> --}}
                                </table>
                                {{-- @php
                                    echo($averages / $c)
                                    
                                @endphp --}}
                                
                             
                            @endif
                            </form>
                        </div>
                  </div>

                </div>
            </div>
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

        $('.deleteBtn').click(function (e) {
            e.preventDefault();

            var delete_id = $(this).closest("tr").find('.delete_val').val();
            // alert(delete_id);
            var id = document.getElementById("student_id").value;
            alert(delete_id);
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
                            url: 'delete-grade/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('Grade Deleted Successfully' , {
                                    icon: "success",
                                })
                                .then((result) => {
                                    window.location.href = "ao-grades/"+id;
                                });
                            },

                        });
                    } else {
                        swal("No Changes Made :)");
                    }
            });
        });

        //transfer section
        $('.transferBtn').click(function (e) {
            e.preventDefault();
            // alert(delete_id);

            var data = $('#transferForm').serialize();
            // alert(data);
                swal({
                title: "Are you sure?",
                text: "Once deleted, you cannot undo it",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "POST",
                            url: 'transfer-section',
                            data: data,
                            success: function (response) {
                                swal('Section Transfer Success' , {
                                    icon: "success",
                                })
                                .then((result) => {
                                    location.href();
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