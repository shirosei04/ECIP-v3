@extends('layouts.master')
@section('title', 'Curriculums')
@section('content')
{{-- <div class="container-fluid"> --}}
    <div class="card">
        <div class="card-header tableCardHeader">
            <form action="{{ url('searchCurriculum') }}" type="get">
                <div class="col-md-3 float-end">
                    <input type="search" class="form-control" placeholder="Search Curriculum" name="query">
                </div> 
                <div class="float-end">
                    <a type="button" href="{{url('/curriculums')}}"  class="btn btn-primary"><i class="fas fa-sync-alt"></i></a>
                </div>
            </form>
            <h3><i class="fas fa-th-list"></i> Curriculums</h3>
            <a data-bs-toggle="modal" data-bs-target="#addCurriculumModal" class="btn btn-success float-start">Add Curriculum</a>
            @include('modals.sched-crud.curriculums.add-curriculum')
        </div>

        <div class="card-body">
            @if (session('alert'))
            <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
            @elseif (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
            @endif
            @if($errors->has('curriculum'))
            <span class="text-danger">{{ $errors->first('curriculum') }}</span>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Curriculum</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($curs) == 0)
                    <div class="alert alert-danger">No Curriculums found.</div>
                    @else
                    @if(!empty($search_text))
                    <div class="alert alert-success" role="alert">Search result(s) for "{{$search_text}}"</div>
                    @endif
                    @foreach ($curs as $cur)
                    
                                <tr>
                                    <input type="hidden" class="delete_val" id="delete_val" value="{{$cur->curriculum_id}}">
                                    <td>{{ $cur->curriculum }}</td>
                                    <td> 
                                        <a type="button" data-bs-toggle="modal" data-bs-target="#editCurriculumModal{{ $cur->curriculum_id }}" class="btn btn-warning"><span class="btn-label"><i class="fas fa-edit"></i></span></a>
                                        <a type="button" class="btn btn-danger deleteButton"><span class="btn-label"><i class="fas fa-trash"></i></span></a>
                                    </td>
                                </tr>
                                @include('modals.sched-crud.curriculums.edit-curriculum')
                        @endforeach
                    @endif
                </tbody>
                </table>
                <tr>
                    {{$curs->links()}}
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
                            url: 'delete-curriculum/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('Curriculum Deleted Successfully' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/curriculums';
                                });
                            },
                            error: function (reject) {
                                swal('Curriculum is associated with an existing subject. Cannot be deleted!' , {
                                icon: "error",
                                }) 
                                .then((result) => {
                                    window.location.href = '/curriculums';
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