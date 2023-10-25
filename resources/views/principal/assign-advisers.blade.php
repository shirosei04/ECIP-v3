@extends('layouts.master')
@section('title', 'Class Advisers')
@section('content')
{{-- <div class="container-fluid"> --}}
    <div class="card vh-100">
        <div class="card-header tableCardHeader">
            <h3><i class="fas fa-warehouse"></i> Class Advisers</h3>
            <a data-bs-toggle="modal" data-bs-target="#addAdviserModal" class="btn btn-success float-start">Assign Class Adviser</a>
            @include('modals.sched-crud.advisers.add-adviser')
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
                        <th>School Year</th>
                        <th>Teacher</th>
                        <th>Section Handled</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($advisers) == 0)
                    <div class="alert alert-danger">No assigned advisers.</div>
                    @else
                    {{-- @if(!empty($search_text))
                    <div class="alert alert-success" role="alert">Search result(s) for "{{$search_text}}"</div>
                    @endif --}}
                    @foreach ($advisers as $adviser)
                                <tr>
                                    <input type="hidden" class="delete_val" id="delete_val" value="{{$adviser->adviser_id}}">
                                    <td>{{ $adviser->school_year }}</td>
                                    <td>{{ $adviser->first_name . " " . $adviser->middle_name . " " . $adviser->last_name . " " . $adviser->suffix}}</td>
                                    <td>{{ $adviser->section_name }}</td>
                                    <td> 
                                        <a type="button" data-bs-toggle="modal" data-bs-target="#editAdviserModal{{$adviser->adviser_id}}" class="btn btn-warning"><span class="btn-label"><i class="fas fa-edit"></i></span></a>
                                        <a type="button" class="btn btn-danger deleteButton"><span class="btn-label"><i class="fas fa-trash"></i></span></a>
                                    </td>
                                </tr>
                                @include('modals.sched-crud.advisers.edit-adviser')
                        @endforeach
                    @endif
                </tbody>
                </table>
                <tr>
                    {{$advisers->links()}}
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
                            url: 'delete-adviser/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('Adviser Deleted Successfully' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/advisers';
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