@extends('layouts.master')
@section('title', 'School Year')
@section('content')
{{-- <div class="container-fluid"> --}}
    <div class="card">
        <div class="card-header tableCardHeader">
            <form action="{{ url('searchSy') }}" type="get">
                
                <div class="col-md-3 float-end">
                    <input type="search" class="form-control" placeholder="Search School Year" name="query">
                </div> 
                <div class="float-end">
                    <a type="button" href="{{url('/school-year')}}"  class="btn btn-primary"><i class="fas fa-sync-alt"></i></a>
                </div>
            </form>
            <h3><i class="fas fa-table"></i> School Year</h3>
            <a data-bs-toggle="modal" data-bs-target="#addSyModal" class="btn btn-success float-start">Add School Year</a>
            @include('modals.sched-crud.sy.add-sy')
        </div>

        <div class="card-body">
            <div class="col">
                <div class="accordion m-3" style="text-align: center " id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <strong> Semesters (FOR SHS ONLY)</strong>
                        </button>
                      </h2>
                      <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                <thead class="table-primary ">
                                    <tr>
                                        <th>Semester</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach ($semesters as $semester)
                                        <tr>
                                            <input type="hidden" class="delete_val" id="delete_val" value="{{$semester->sem_id}}">
                                            <td>{{ $semester->semester }}</td>
                                            <td>
                                              <a href="{{url('sem/'.$semester->sem_id)}}" class="btn btn-sm btn-{{ $semester->sem_status ? 'info' : 'success' }}">
                                                {{$semester->sem_status ? 'Active' : 'Enable'}}
                                              </a>
                                            </td>
                                        </tr>
                                  @endforeach
                                </tbody>
                                </table>
                              </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            @if (session('alert'))
            <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
            @elseif (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                <thead class="table-primary">
                    <tr>
                        <th>School Year</th>
                        <th>Type</th>
                        <th>Enrollment</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($years) == 0)
                    <div class="alert alert-danger">No school years found.</div>
                    @else
                    @foreach ($years as $year)
                    @if(!empty($search_text))
                    <div class="alert alert-success" role="alert">Search result(s) for "{{$search_text}}"</div>
                    @endif
                                <tr>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" class="delete_val" id="delete_val" value="{{$year->sy_id}}">
                                    <td>{{$year->school_year}}</td>
                                    <td>{{$year->type}}</td>
                                    @if($year->enrollment == 1) 
                                        <td><i class="fas fa-check"></i> Open</td>
                                    @else
                                        <td><i class="fas fa-times"></i> Closed</td>
                                    @endif

                                    @if($year->is_current == 1) 
                                        <td><i class="fas fa-check"></i> Current</td>
                                    @else
                                        <td><i class="fas fa-times"></i> Not Current</td>
                                    @endif
                                    <td> 
                                        @if($year->is_current == 1) 
                                            @if($year->enrollment == 1) 
                                            <a type="button" class="btn btn-danger closeEnrollmentBtn"><span class="btn-label"><i class="fas fa-lock"></i> Close Enrollment</span></a>
                                            @else
                                            <a type="button" class="btn btn-success openEnrollmentBtn"><span class="btn-label"><i class="fas fa-lock-open"></i> Open Enrollment</span></a>
                                            @endif
                                        @endif


                                        @if($year->is_current != 1) 
                                        
                                        <a type="button" class="btn btn-success setCurrentBtn"><span class="btn-label"><i class="fas fa-calendar-check" title="Set as Current"></i></span></a>
                                        <a type="button" data-bs-toggle="modal" data-bs-target="#editSyModal{{$year->sy_id}}" class="btn btn-warning"><span class="btn-label"><i class="fas fa-edit"></i></span></a>
                                        <a type="button" class="btn btn-danger deleteButton"><span class="btn-label"><i class="fas fa-trash"></i></span></a>
                                        @else
                                        <a type="button" class="btn btn-danger setNotCurrentBtn"><span class="btn-label"><i class="fas fa-calendar-times"></i></span></a>
                                        @endif
                                     
                                       
                                    </td>
                                </tr>
                                @include('modals.sched-crud.sy.edit-sy')
                        @endforeach
                    @endif
                </tbody>
                </table>
                <tr>
                    {{$years->links()}}
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
            //alert(delete_id);
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
                            url: 'delete-sy/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('School Year Deleted Successfully' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/school-year';
                                });
                            },
                            error: function (reject) {
                                swal('School year is associated with an existing schedule. Cannot be deleted!' , {
                                icon: "error",
                                }) 
                                .then((result) => {
                                    window.location.href = '/school-year';
                                });
                            }
                        });

                        
                    } else {
                        swal("No Changes Made :)");
                    }
            });
        });


        $('.setCurrentBtn').click(function (e) {
            e.preventDefault();
            // var spinner  = '<div class="loader fs-3 fw-bold">Please wait...</div>';
            var delete_id = $(this).closest("tr").find('.delete_val').val();
             //alert(delete_id);
                swal({
                title: "Are you sure?",
                text: "This will change the current year into this year",
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
                            url: 'set-current/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('Current Year Successfully Changed' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/school-year';
                                });
                            }
                        });
                    } else {
                        swal("No Changes Made :)");
                    }
            });
        });


        $('.setNotCurrentBtn').click(function (e) {
            e.preventDefault();
            // var spinner  = '<div class="loader fs-3 fw-bold">Please wait...</div>';
            var delete_id = $(this).closest("tr").find('.delete_val').val();
             //alert(delete_id);
                swal({
                title: "Are you sure?",
                text: "This selected year will be removed as current",
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
                            url: 'set-not-current/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('Current Year Successfully Removed' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/school-year';
                                });
                            }
                        });
                    } else {
                        swal("No Changes Made :)");
                    }
            });
        });

        //open enrollment
        $('.openEnrollmentBtn').click(function (e) {
            e.preventDefault();
            // var spinner  = '<div class="loader fs-3 fw-bold">Please wait...</div>';
            var delete_id = $(this).closest("tr").find('.delete_val').val();
             alert(delete_id);
                swal({
                title: "Are you sure?",
                text: "This will change the current year into this year",
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
                            url: 'open-enroll/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('Enrollment Successfully Opened' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/school-year';
                                });
                            }
                        });
                    } else {
                        swal("No Changes Made :)");
                    }
            });
        });


        $('.closeEnrollmentBtn').click(function (e) {
            e.preventDefault();
            // var spinner  = '<div class="loader fs-3 fw-bold">Please wait...</div>';
            var delete_id = $(this).closest("tr").find('.delete_val').val();
             alert(delete_id);
                swal({
                title: "Are you sure?",
                text: "This will change the current year into this year",
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
                            url: 'close-enroll/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('Enrollment Successfully Closed' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/school-year';
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