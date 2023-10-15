@extends('layouts.master')
@section('title', 'Student List')
@section('content')
{{-- <div class="container-fluid"> --}}
    <div class="card spinnerTarget">
        <div class="card-header tableCardHeader">
            <h3><i class="fas fa-user-graduate"></i> Students of @foreach($subject as $sub){{$sub->subject_name}}@endforeach</h3>
        </div>
            @if (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
             @endif
             @if (session('alert'))
             <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
              @endif
              
            <div class="table-responsive ">
                <table class="table table-sm table-hover">
                <thead class="table-primary">
                    <tr>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                                <tr>
                                    <form action="{{url('release-grades')}}" method="POST">
                                        @csrf
                                        {{-- <input type="hidden" name="grade[]" value="{{$student->sg_id}}"> --}}
                                    <input type="hidden" class="delete_val" id="delete_val" name="inputs[]delete_val" value="{{$student->sg_id}}">
                                    <td>{{ $student->lrn}}</td>
                                    <td>{{ $student->last_name . ", " . $student->first_name . " " . $student->middle_name . " " . $student->suffix}}</td>
                                    <td>{{$student->frst_grade}}</td>
                                    <td>{{$student->scnd_grade}}</td>
                                    {{-- KUNG HINDI GRADE 11 OR 12 --}}
                                    @if($gradelvl->subject_grade_lvl != "Grade 11" && $gradelvl->subject_grade_lvl != "Grade 12")
                                        <td>{{$student->thrd_grade}}</td>
                                        <td>{{$student->frth_grade}}</td>

                                        @if (!empty($student->frth_grade))
                                        <td>{{round(($student->frst_grade + $student->scnd_grade + $student->thrd_grade + $student->frth_grade) / 4)}}</td>
                                        @else
                                        {{-- KUNG WALA PANG FOURTH GRADE, TD MUNA --}}
                                        <td></td>
                                        @endif

                                        @if(!empty($student->frth_grade) & !empty($student->frst_grade) & !empty($student->scnd_grade) & !empty($student->thrd_grade))
                                        @if(round(($student->frst_grade + $student->scnd_grade + $student->thrd_grade + $student->frth_grade) / 4) >= 75)
                                        <td>PASSED</td>
                                        @else
                                        <td>FAILED</td>
                                        @endif
                                        {{-- KUNG WALA PANG FOURTH GRADE, TD MUNA --}}
                                        @else
                                            <td></td>
                                        @endif
                                    {{-- KUNG GRADE 11 OR 12 --}}
                                    @else
                                        @if (!empty($student->scnd_grade))
                                        <td>{{round(($student->frst_grade + $student->scnd_grade) / 2)}}</td>
                                        @else
                                        {{-- KUNG WALA PANG SECOND GRADE, EDI TD MUNA --}}
                                        <td></td>
                                        @endif
                                        {{-- SINCE TWO TERMS LANG ANG SHS, PAG MAY SCND GRADE NA, CALCULATE STATUS --}}
                                        @if(!empty($student->frst_grade) & !empty($student->scnd_grade))
                                            @if(round(($student->frst_grade + $student->scnd_grade ) / 2) >= 75)
                                            <td>PASSED</td>
                                            @else
                                            <td>FAILED</td>
                                            @endif
                                        @else
                                            <td></td>
                                        @endif
                                    @endif
                                    
                                    {{-- @foreach($frst as $f)
                                        <td>{{$student->frst_grade}}</td>
                                    @endforeach
                                    @foreach($scnd as $sc)
                                        <td>{{$student->scnd_grade}}</td>
                                    @endforeach
                                    @if($gradelvl->subject_grade_lvl != "Grade 11" && $gradelvl->subject_grade_lvl != "Grade 12")
                                        @foreach($thrd as $th)
                                            <td>{{$student->thrd_grade}}</td>
                                        @endforeach
                                        @foreach($frth as $fr)
                                            <td>{{$student->frth_grade}}</td>
                                        @endforeach
                                        @if (!empty($student->frth_grade))
                                        <td>{{round(($student->frst_grade + $student->scnd_grade + $student->thrd_grade + $student->frth_grade) / 4)}}</td>
                                        @else
                                        <td></td>
                                        @endif
                                        @if(!empty($student->frth_grade) & !empty($student->frst_grade) & !empty($student->scnd_grade) & !empty($student->thrd_grade))
                                            @if(round(($student->frst_grade + $student->scnd_grade + $student->thrd_grade + $student->frth_grade) / 4) >= 75)
                                            <td>PASSED</td>
                                            @else
                                            <td>FAILED</td>
                                            @endif
                                        @else
                                            <td></td>
                                        @endif
                                    @else
                                        @if (!empty($student->scnd_grade))
                                        <td>{{round(($student->frst_grade + $student->scnd_grade) / 2)}}</td>
                                        @else
                                        <td></td>
                                        @endif
                                        @if(!empty($student->frst_grade) & !empty($student->scnd_grade))
                                            @if(round(($student->frst_grade + $student->scnd_grade ) / 2) >= 75)
                                            <td>PASSED</td>
                                            @else
                                            <td>FAILED</td>
                                            @endif
                                        @else
                                            <td></td>
                                        @endif
                                    @endif
                                </tr> --}}

                        @endforeach
          
              
                
                    </tbody>
              
                </table>

                     <button type="submit" class="btn btn-success float-end btn-sm m-3 releaseBtn"> Release</button>
                    </form>
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