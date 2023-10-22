@extends('layouts.master')
@section('title', 'Subjects')
@section('content')
{{-- <div class="container-fluid"> --}}
    <div class="card vh-100">
        <div class="card-header tableCardHeader">
            <form action="{{ url('searchSubject') }}" type="get">
                <div class="col-md-3 float-end">
                    <input type="search" class="form-control" placeholder="Search Subject" name="query">
                </div> 
                <div class="float-end">
                    <a type="button" href="{{url('/subjects')}}"  class="btn btn-primary"><i class="fas fa-sync-alt"></i></a>
                </div>
            </form>
            <h3><i class="fas fa-book"></i> Subjects</h3>
            <a data-bs-toggle="modal" data-bs-target="#addSubjectModal" class="btn btn-success float-start">Add Subject</a>
            @include('modals.sched-crud.subjects.add-subject')
        </div>
        <form action="{{url('filter-subjects')}}" >
            <div class="row ms-1 mt-2" >

                <div class="col-3">
                    <select class="form-select" name="curriculum_filter">
                        <option value="" selected>Filter by Curriculum</option>
                        @foreach($curriculums as $curriculum)
                        <option value="{{$curriculum->curriculum}}" {{ ($curriculumfilter==$curriculum->curriculum)? "selected" : "" }}>{{$curriculum->curriculum}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-3">
                    <select class="form-select" name="grade_filter">
                        <option value="" selected>Filter by Grade Level</option>
                        <option value="Kinder"{{ ($gradefilter=="Kinder")? "selected" : "" }}>Kinder</option>
                        <option value="Grade 1"{{ ($gradefilter=="Grade 1")? "selected" : "" }}>Grade 1</option>
                        <option value="Grade 2"{{ ($gradefilter=="Grade 2")? "selected" : "" }}>Grade 2</option>
                        <option value="Grade 3"{{ ($gradefilter=="Grade 3")? "selected" : "" }}>Grade 3</option>
                        <option value="Grade 4"{{ ($gradefilter=="Grade 4")? "selected" : "" }}>Grade 4</option>
                        <option value="Grade 5"{{ ($gradefilter=="Grade 5")? "selected" : "" }}>Grade 5</option>
                        <option value="Grade 6"{{ ($gradefilter=="Grade 6")? "selected" : "" }}>Grade 6</option>
                        <option value="Grade 7"{{ ($gradefilter=="Grade 7")? "selected" : "" }}>Grade 7</option>
                        <option value="Grade 8"{{ ($gradefilter=="Grade 8")? "selected" : "" }}>Grade 8</option>
                        <option value="Grade 9"{{ ($gradefilter=="Grade 9")? "selected" : "" }}>Grade 9</option>
                        <option value="Grade 10"{{ ($gradefilter=="Grade 10")? "selected" : "" }}>Grade 10</option>
                        <option value="Grade 11"{{ ($gradefilter=="Grade 11")? "selected" : "" }}>Grade 11</option>
                        <option value="Grade 12"{{ ($gradefilter=="Grade 12")? "selected" : "" }}>Grade 12</option>
                    </select>
                </div>

                <div class="col-3">
                    <select class="form-select" name="track_filter">
                        <option value="" selected>Filter by Track</option>
                        <option value="ABM" {{ ($trackfilter=="ABM")? "selected" : "" }}>ABM</option>
                        <option value="GAS" {{ ($trackfilter=="GAS")? "selected" : "" }}>GAS</option>
                        <option value="HUMSS" {{ ($trackfilter=="HUMSS")? "selected" : "" }}>HUMSS</option>
                        <option value="STEM" {{ ($trackfilter=="STEM")? "selected" : "" }}>STEM</option>
                        <option value="TVL" {{ ($trackfilter=="TVL")? "selected" : "" }}>TVL</option>
                        <option value="General Subject(SHS)"{{ ($trackfilter=="General Subject(SHS)")? "selected" : "" }}>General Subject(SHS)</option>
                        <option value="Not Applicable"{{ ($trackfilter=="Not Applicable")? "selected" : "" }}>Not Applicable</option>
                    </select>
                </div>

                <div class="col-3">
                    <button type="submit"  class="btn btn-success"><i class="fas fa-filter"></i></button>
                </div>
            </div>
        </form>
        <div class="card-body">
            @if (session('alert'))
            <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
            @elseif (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
            @endif
            <div class="table-responsive">
                @if (count($subjects) == 0)
                <div class="alert alert-danger">No Subjects Found </div>
                @else
                <table class="table table-bordered table-sm">
                <thead class="table-primary">
                    <tr>
                        <th>Subject Name</th>
                        <th>Curriculum</th>
                        <th>Grade Level</th>
                        <th>Track</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  
                    @if(!empty($search_text))
                    <div class="alert alert-success" role="alert">Search result(s) for "{{$search_text}}"</div>
                    @endif
                    @foreach ($subjects as $subject)
                                <tr>
                                    <input type="hidden" class="delete_val" id="delete_val" value="{{$subject->subject_id}}">
                                    <td>{{ $subject->subject_name }}</td>
                                    <td>{{ $subject->curriculum }}</td>
                                    <td>{{ $subject->subject_grade_lvl }}</td>
                                    <td>{{ $subject->track }}</td>
                                    <td> 
                                        <a type="button" data-bs-toggle="modal" data-bs-target="#editSubjectModal{{$subject->subject_id}}" class="btn btn-warning"><span class="btn-label"><i class="fas fa-edit"></i></span></a>
                                        <a type="button" class="btn btn-danger deleteButton"><span class="btn-label"><i class="fas fa-trash"></i></span></a>
                                    </td>
                                </tr>
                                @include('modals.sched-crud.subjects.edit-subject')
                        @endforeach
                    @endif
                </tbody>
                </table>
                <tr>
                    {{$subjects->links()}}
                </tr>
            </div>
        </div>
        
    </div>
{{-- </div> --}}

@endsection

@section('scripts')
<script>
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
                            url: 'delete-subject/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('Subject Deleted Successfully' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/subjects';
                                });
                            },
                            error: function (reject) {
                                swal('Subject is associated with an existing schedule. Cannot be deleted!' , {
                                icon: "error",
                                }) 
                                .then((result) => {
                                    window.location.href = '/subjects';
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
@endsection