@extends('layouts.master')
@section('title', 'Student List')
@section('content')
{{-- <div class="container-fluid"> --}}
    <div class="card vh-100">
        <div class="card-header tableCardHeader">
            <h3><i class="fas fa-user-graduate"></i> Students</h3>
        </div>
            @if (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
             @endif
             @if (session('alert'))
             <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
              @endif

              
            <div class="card m-3">
                <div class="card-header">
                    <h6>Subject: English 1</h6>
                    <h6>Section: K1A</h6>
                    <H6>Number of Students: {{count($students)}}</H6>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Post Grades by Bulk
                      </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <form action="{{url('bulk-post-grades')}}" method="POST">
                            @csrf
                            <div class="row ps-3 pe-3 pt-3 pb-3">
                        
                                <div class="col-11">
                                    @foreach ($students as $student )
                                    <input type="hidden" class="delete_val" id="delete_val" name="inputs[]delete_val" value="{{$student->sg_id}}">
                                    @endforeach
                                    <div class="input-group input-group-sm mb-3">
                                        <input type="text" name="grades_long" class="form-control">
                                    </div>
                                    
                                </div>
                
                                <div class="col-1">
                                    <button type="submit" class="btn btn-success float-end btn-sm"><span class="btn-label"><i class="fas fa-edit"></i></span> Post</button>
                                </div>
           
                            </div>
                        </form>
                    </div>
                  </div>
                
                <div class="table-responsive m-3">
                    <table class="table table-sm table-borderless">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>LRN</th>
                            <th>Name</th>
                            <th>1st</th>
                            <th>2nd</th>
                            @if($gradelvl->subject_grade_lvl != "Grade 11" && $gradelvl->subject_grade_lvl != "Grade 12")
                            <th>3rd</th>
                            <th>4th</th>
                            @endif
                            <th>Final</th>
                            <th>Status</th>
                            <th>Released</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($students) == 0)
                            <div class="alert alert-danger">No students found.</div>
                        @else
                            @php
                                $c = 1;
                            @endphp
                            @foreach ($students as $student)
                                    <tr>
                                        <form action="{{url('post-grades')}}" method="POST">
                                        @csrf
                                        <input type="hidden" class="delete_val" id="delete_val" name="inputs[]delete_val" value="{{$student->sg_id}}">
                                        <td>{{$c}}</td>
                                        <td>{{ $student->lrn}}</td>
                                        <td>{{ $student->last_name . ", " . $student->first_name . " " . $student->middle_name . " " . $student->suffix}}</td>
                                    
                                        {{-- FIRST TERM --}}
                                            {{-- KUNG INOPEN NG PRINCIPAL ANG FIRST TERM, DAPAT VIEWABLE + EDITABLE UNG GRADE --}}
                                            @if($frst->status == "1")
                                            {{-- VIEW + EDIT--}}
                                            <td><input style="width: 40px; text-align:center" name="frst[]frst" type="text" value="{{$student->frst_grade}}"></td>
                                            @else
                                            {{-- KUNG CLOSED ANG ONE, DAPAT VIEWABLE LANG UNG GRADE --}}
                                            <input style="width: 40px; text-align:center" name="frst[]frst" type="hidden" value="{{$student->frst_grade}}">
                                            <td>{{$student->frst_grade}}</td>
                                            @endif
                                        
                                        {{-- SECOND TERM --}}
                                            {{-- KUNG INOPEN NG PRINCIPAL ANG SECOND TERM, DAPAT VIEWABLE + EDITABLE UNG GRADE --}}
                                            @if($scnd->status == "1")
                                            <td><input style="width: 40px; text-align:center" name="scnd[]scnd" type="text" value="{{$student->scnd_grade}}"></td>
                                            @else
                                            <input style="width: 40px; text-align:center" name="scnd[]scnd" type="hidden" value="{{$student->scnd_grade}}">
                                            <td>{{$student->scnd_grade}}</td>
                                            @endif
                                        
                                        {{-- KUNG HINDI PANG GRADE 11 OR TWELVE UNG SUB --}}
                                        @if($gradelvl->subject_grade_lvl != "Grade 11" && $gradelvl->subject_grade_lvl != "Grade 12")
                                        {{-- THIRD TERM --}}
                                            {{-- KUNG INOPEN NG PRINCIPAL ANG THIRD TERM, DAPAT VIEWABLE + EDITABLE UNG GRADE --}}
                                            @if($thrd->status == "1")
                                            <td><input style="width: 40px; text-align:center" name="thrd[]" type="text" value="{{$student->thrd_grade}}"></td>
                                            @else
                                            <input style="width: 40px; text-align:center" name="thrd[]" type="hidden" value="{{$student->thrd_grade}}">
                                            <td>{{$student->thrd_grade}}</td>
                                            @endif

                                        {{-- FOURTH TERM --}}
                                            {{-- KUNG INOPEN NG PRINCIPAL ANG FOURTH TERM, DAPAT VIEWABLE + EDITABLE UNG GRADE --}}
                                            @if($frth->status == "1")
                                            <td><input style="width: 40px; text-align:center" name="frth[]" type="text" value="{{$student->frth_grade}}"></td>
                                            @else
                                            <input style="width: 40px; text-align:center" name="frth[]" type="hidden" value="{{$student->frth_grade}}">
                                            <td>{{$student->frth_grade}}</td>
                                            @endif

                                        {{-- AVERAGE CALCULATION PARA SA NOT 11 AND 12 PARIN --}}
                                            @if (!empty($student->frth_grade & $student->frst_grade & $student->thrd_grade & $student->scnd_grade))
                                                @if($student->frth_grade == "INC" | $student->frst_grade == "INC" | $student->thrd_grade == "INC" | $student->scnd_grade == "INC")
                                                <td>INC</td>
                                                @elseif($student->frth_grade == "NG" | $student->frst_grade == "NG" | $student->thrd_grade == "NG" | $student->scnd_grade == "NG")
                                                <td>NG</td>
                                                @else
                                                <td>{{round(($student->frst_grade + $student->scnd_grade + $student->thrd_grade + $student->frth_grade) / 4)}}</td>
                                                @endif
                                            @else
                                            {{-- KUNG WALA PANG FOURTH GRADE, TD MUNA --}}
                                                <td></td>
                                            @endif

                                        {{-- STATUS CALCULATION PARA SA NOT 11 AND 12 PARIN --}}
                                            @if(!empty($student->frth_grade) & !empty($student->frst_grade) & !empty($student->scnd_grade) & !empty($student->thrd_grade))
                                                @if($student->frth_grade == "INC" | $student->frst_grade == "INC" | $student->thrd_grade == "INC" | $student->scnd_grade == "INC")
                                                <td>INC</td>
                                                @elseif($student->frth_grade == "NG" | $student->frst_grade == "NG" | $student->thrd_grade == "NG" | $student->scnd_grade == "NG")
                                                <td>NG</td>
                                                @else
                                                @if(round(($student->frst_grade + $student->scnd_grade + $student->thrd_grade + $student->frth_grade) / 4) >= 75)
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
                                        {{-- PARA NAMAN SA GRADE 11 AND 12  --}}
                                            {{-- DITO PARIN TO PARA DI MAG ERROR --}}
                                            <input style="width: 40px; text-align:center" name="thrd[]" type="hidden" value="{{$student->thrd_grade}}">
                                            <input style="width: 40px; text-align:center" name="frth[]" type="hidden" value="{{$student->frth_grade}}">
                                            {{-- SINCE TWO TERMS LANG ANG SHS, PAG MAY SCND GRADE NA, CALCULATE AVERAGE --}}
                                            @if(!empty($student->scnd_grade) & !empty($student->frst_grade))
                                                @if($student->frst_grade == "INC" | $student->scnd_grade == "INC")
                                                <td>INC</td>
                                                @elseif($student->frst_grade == "NG" | $student->scnd_grade == "NG")
                                                <td>NG</td>
                                                @else
                                                <td>{{$average = round(($student->frst_grade + $student->scnd_grade) / 2) }}</td>
                                                @endif
                                                @if(!empty($student->frst_grade) & !empty($student->scnd_grade))
                                                    @if($student->frst_grade == "INC" | $student->scnd_grade == "INC")
                                                    <td>INC</td>
                                                    @elseif($student->frst_grade == "NG" | $student->scnd_grade == "NG")
                                                    <td>NG</td>
                                                    @else
                                                        @if(round(($student->frst_grade + $student->scnd_grade) / 2) >= 75)
                                                        <td>PASSED</td>
                                                        @else
                                                        <td>FAILED</td>
                                                        @endif 
                                                    @endif
                                                @endif
                                            @else
                                                <td></td>
                                                <td></td>
                                            @endif
                                        {{-- @endif --}}
                                        @endif



                                        {{-- RELEASED PARA SA LAHAT NG GRADE LEVEL --}}
                                        @if($student->view_status == 1)
                                        <td>Yes</td>
                                        @else
                                        <td>No</td>
                                        @endif
                                    </tr>
                                    @php
                                    $c++;
                                @endphp
                            @endforeach
                            </tbody>
                    
                        </table>
                        <tr>
                            <button type="submit" class="btn btn-success float-end btn-sm"><span class="btn-label"><i class="fas fa-edit"></i></span> Post</button>
                        </tr>
                    </div>
                    </form>
                @endif
                </div>
    </div>


@endsection
{{-- @section('scripts')
<script>
    $(document).ready(function () {
    
    // edit USER
    // $('.editBtn').click(function (e) {
    //         e.preventDefault();
    //         var delete_id = $(this).closest("div").find('.delete_val').val();
    //         var data = $('#editUserForm').serialize();
    //         alert(data);
    //         // alert(delete_id);
    //             swal({
    //             title: "Are you sure?",
    //             text: "This specific user details will be changed",
    //             icon: "warning",
    //             buttons: true,
    //             dangerMode: true,
    //             })
    //             .then((willEdit) => {
    //                 if (willEdit) {
    //                     $.ajax({
    //                         type: "PUT",
    //                         url: 'edit-user',
    //                         data: data,
    //                         success: function (response) {
    //                             swal('User Edited Successfully' , {
    //                                 icon: "success",
    //                             }) 
    //                             .then((result) => {
    //                                 window.location.href = '/student-list';
    //                             });
    //                         }
    //                     });
    //                 } else {
    //                     swal("No Changes Made :)");
    //                 }
    //         });
    //     });

        $('.archiveBtn').click(function (e) {
            e.preventDefault();
            // var spinner  = '<div class="loader fs-3 fw-bold">Please wait...</div>';
            var delete_id = $(this).closest("tr").find('.delete_val').val();
            // alert(delete_id);
                swal({
                title: "Are you sure?",
                text: "Once archived, you cannot undo it",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willArchive) => {
                    if (willArchive) {
                        // $('.spinnerTarget').html(spinner)
                        var data = {
                            "_token": $('input[name="_token"]').val(),
                            "id": delete_id,
                        };
                        $.ajax({
                            type: "GET",
                            url: 'principal-archive-user/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('User Archived Successfully' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/student-list';
                                });
                            }
                        });
                    } else {
                        swal("No Changes Made :)");
                    }
            });
        });

        $('.resetBtn').click(function (e) {
            e.preventDefault();
            var spinner  = '<div class="loader fs-3 fw-bold">Please wait...</div>';
            var delete_id = $(this).closest("tr").find('.delete_val').val();
            alert(delete_id);
                swal({
                title: "Are you sure?",
                text: "Once reset, you cannot undo it",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willReset) => {
                    if (willReset) {
                        $('.spinnerTarget').html(spinner)
                        var data = {
                            "_token": $('input[name="_token"]').val(),
                            "id": delete_id,
                        };
                        $.ajax({
                            type: "PUT",
                            url: 'reset-password/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('User Password Reset Successfully' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/student-list';
                                });
                            }
                        });
                    } else {
                        swal("No Changes Made :)");
                    }
            });
        });


     });
</script>
@endsection --}}