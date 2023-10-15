@extends('layouts.master')
@section('title', 'AO List')
@section('content')
{{-- <div class="container-fluid"> --}}
    <div class="card spinnerTarget">
        <div class="card-header tableCardHeader">
            <form action="{{ url('searchao') }}" type="get">
                <div class="col-md-3 float-end">
                    <input type="search" class="form-control" placeholder="Search Officer" name="query">
                </div> 
                <div class="float-end">
                    <a type="button" href="{{url('/ao-list')}}"  class="btn btn-primary"><i class="fas fa-sync-alt"></i></a>
                </div>
            </form>
            <h3><i class="fas fa-user-tie"></i> Admission Officers</h3>
        </div>
        <div class="p-2" >
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newUserModal">Add New User</button>
        </div>
        @include('modals.add-user')
        {{-- <div class="card-body"> --}}
            @if (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
             @endif
             @if (session('alert'))
             <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
              @endif
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>Last Name</th>
                        <th>Middle Name</th>
                        <th>First Name</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($users) == 0)
                    <div class="alert alert-danger">No Admission Officers found.</div>
                    @else
                    @foreach ($users as $user)
                    @if(!empty($search_text))
                    <div class="alert alert-success">Results for <strong style="color: red">"{{ $search_text }}"</strong></div>
                    @endif
                                <tr>
                                    <input type="hidden" class="delete_val" id="delete_val" value="{{$user->id}}">
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->middle_name }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td> 
                                        <a type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewUserModal{{$user->id}}"><span class="btn-label"><i class="fas fa-eye"></i> View</span></a>
                                        <a type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal{{$user->id}}"><span class="btn-label"><i class="fas fa-edit"></i> Edit</span></a>
                                        <a href="{{url('principal-archive-user/'.$user->id)}}"  type="button" class="btn btn-danger btn-sm archiveBtn"><span class="btn-label"><i class="fas fa-archive"></i></span> Archive</a>
                                        <a type="button" class="btn btn-info btn-sm orange-button resetBtn"><span class="btn-label"><i class="fas fa-wrench"></i> Reset Password</span></a>
                                        @include('modals.view-user')
                                    </td>
                                    @include('modals.edit-user')
                                </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
    </div>
@endsection

@section('scripts')
<script>
    //username auto creation
    // function getValue(){
    //     //get fname value
    //     let fname = document.getElementById("firstname");
    //     let fnameValue = fname.value;
    //     //get lname value
    //     let lname = document.getElementById("lastname");
    //     let lnameValue = lname.value;

    //     //only take first name
    //     let onlyFirst = fnameValue.split(" ")[0]

    //     //concatenate fname & lname value and save it in a var
    //     let fusername = lnameValue.concat("_"+onlyFirst).toLowerCase();

    //     //set disabled textbox's value for display
    //     document.getElementById('username').value = fusername;
    //     //set hidden textbox's value to save in DB
    //     document.getElementById('susername').value = fusername;
    // }
    $(document).ready(function () {
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
                                    window.location.href = '/ao-list';
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
@endsection