@extends('layouts.master')
@section('title', 'Sections')
@section('content')
{{-- <div class="container-fluid"> --}}
    <div class="card vh-100">
        <div class="card-header tableCardHeader">
            <form action="{{ url('searchSection') }}" type="get">
                <div class="col-md-3 float-end">
                    <input type="search" class="form-control" placeholder="Search Section or Grade Level" name="query">
                </div> 
                <div class="float-end">
                    <a type="button" href="{{url('/sections')}}"  class="btn btn-primary"><i class="fas fa-sync-alt"></i></a>
                </div>
            </form>
            <h3><i class="fas fa-warehouse"></i> Sections</h3>
            <a data-bs-toggle="modal" data-bs-target="#addSectionModal" class="btn btn-success float-start">Add Section</a>
            @include('modals.sched-crud.sections.add-section')
        </div>

        <div class="card-body">
            @if (session('alert'))
            <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
            @elseif (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Grade Level</th>
                        <th>Section Name</th>
                        <th>Capacity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($sections) == 0)
                    <div class="alert alert-danger">No sections found.</div>
                    @else
                    @if(!empty($search_text))
                    <div class="alert alert-success" role="alert">Search result(s) for "{{$search_text}}"</div>
                    @endif
                    @foreach ($sections as $section)
                                <tr>
                                    <input type="hidden" class="delete_val" id="delete_val" value="{{$section->section_id}}">
                                    @if ($section->section_grade_lvl == 0)
                                    <td>Kinder</td>
                                    @else
                                    <td>Grade {{  $section->section_grade_lvl }}</td>
                                    @endif
                                    <td>{{ $section->section_name }}</td>
                                    <td>{{ $section->capacity }}</td>
                                    <td> 
                                        <a type="button" data-bs-toggle="modal" data-bs-target="#editSectionModal{{$section->section_id}}" class="btn btn-warning"><span class="btn-label"><i class="fas fa-edit"></i></span></a>
                                        <a type="button" class="btn btn-danger deleteButton"><span class="btn-label"><i class="fas fa-trash"></i></span></a>
                                    </td>
                                </tr>
                                @include('modals.sched-crud.sections.edit-section')
                        @endforeach
                    @endif
                </tbody>
                </table>
                <tr>
                    {{$sections->links()}}
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
                            url: 'delete-section/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('Section Deleted Successfully' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/sections';
                                });
                            },
                            error: function (reject) {
                                swal('Section is associated with an existing schedule. Cannot be deleted!' , {
                                icon: "error",
                                }) 
                                .then((result) => {
                                    window.location.href = '/sections';
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