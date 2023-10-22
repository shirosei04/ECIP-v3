@extends('layouts.master')
@section('title', 'Teachers List')
@section('content')
{{-- <div class="container-fluid"> --}}
    <div class="card spinnerTarget vh-100">
        <div class="card-header tableCardHeader">
            <form action="{{ url('searchteacher') }}" type="get">
                <div class="col-md-3 float-end">
                    <input type="search" class="form-control" placeholder="Search Teacher" name="query">
                </div> 
                <div class="float-end">
                    <a type="button" href="{{url('/teacher-list')}}"  class="btn btn-primary"><i class="fas fa-sync-alt"></i></a>
                </div>
            </form>
            <h3><i class="fas fa-chalkboard-teacher"></i> Teachers</h3>
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
            {{-- @if($errors->has('role') | $errors->has('role') | )
            <span class="text-danger">{{ $errors->first('role') }}</span>
            @endif --}}
             {{-- <form action="{{url('filter-officers')}}" >
                <div class="row p-3" >
                        <div class="col-3">
                            <select class="form-select" name="grade_filter">
                 
                                <option value="nofilter" selected>Filter by Grade Level</option>
                                <option value="0">Kinder</option>
                                <option value="1">Grade 1</option>
                                <option value="2">Grade 2</option>
                                <option value="3">Grade 3</option>
                                <option value="4">Grade 4</option>
                                <option value="5">Grade 5</option>
                                <option value="6">Grade 6</option>
                                <option value="7">Grade 7</option>
                                <option value="8">Grade 8</option>
                                <option value="9">Grade 9</option>
                                <option value="10">Grade 10</option>
                                <option value="11">Grade 11</option>
                                <option value="12">Grade 12</option>
                                <option value="reset">Reset Filter</option>
                            
                            </select>
                        </div>
                  
                        <div class="col-3">
                          <button type="submit"  class="btn btn-success"><i class="fas fa-filter"></i></button>
                        </div>
                </div>
            </form> --}}
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>Last Name</th>
                        <th>Middle Name</th>
                        <th>First Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($users) == 0)
                       <div class="alert alert-danger">
                            No teachers found.
                       </div>   
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
                                    window.location.href = '/teacher-list';
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