@extends('layouts.master')
@section('title', 'Awards')
@section('content')
{{-- <div class="container-fluid"> --}}
    <div class="card">
        <div class="card-header tableCardHeader">
            <form action="{{ url('searchaward') }}" type="get">
                <div class="col-md-3 float-end">
                    <input type="search" class="form-control" placeholder="Search Award" name="query">
                </div> 
                <div class="float-end">
                    <a type="button" href="{{url('/awards')}}"  class="btn btn-primary"><i class="fas fa-sync-alt"></i></a>
                </div>
            </form>
            <h3><i class="fas fa-trophy"></i> Awards</h3>
            <a data-bs-toggle="modal" data-bs-target="#addAwardModal" class="btn btn-primary float-start">Add Award</a>
            @include('modals.add-award')
        </div>

        <div class="card-body">
            @if (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
             @endif
             @if (session('alert'))
             <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
              @endif
            <div class="table-responsive">
                <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Award Name</th>
                        <th>Award Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($awards) == 0)
                    <div class="alert alert-danger">No awards found.</div>
                    @else
                    @foreach ($awards as $award)
                    @if(!empty($search_text))
                    <div class="alert alert-success">Results for <strong style="color: red">"{{ $search_text }}"</strong></div>
                    @endif
                                <tr>
                                    <input type="hidden" class="delete_val" id="delete_val" value="{{$award->award_id}}">
                                    <td>{{ $award->award_name }}</td>
                                    <td>{{ $award->award_desc }}</td>
                                    <td> 
                                        <a type="button" data-bs-toggle="modal" data-bs-target="#editAwardModal{{$award->award_id}}" class="btn btn-warning"><span class="btn-label"><i class="fas fa-edit"></i></span></a>
                                        <a type="button" class="btn btn-danger deleteButton"><span class="btn-label"><i class="fas fa-trash"></i></span></a>
                                    </td>
                                </tr>
                                @include('modals.edit-award')
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <tr>
                    {{$awards->links()}}
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
                            url: 'delete-award/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('Award Deleted Successfully' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/awards';
                                });
                            },
                            error: function (reject) {
                                swal('Award is associated with a student. Cannot be deleted!' , {
                                icon: "error",
                                }) 
                                .then((result) => {
                                    window.location.href = '/awards';
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