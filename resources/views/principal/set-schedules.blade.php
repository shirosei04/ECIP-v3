@extends('layouts.master')
@section('title', 'Scheduling')

@section('content')
{{-- <div class="container-fluid"> --}}
        <div class="card">
            <div class="card-header tableCardHeader">
                <form action="{{ url('searchSched') }}" type="get">
                    <div class="col-md-3 float-end">
                        <input type="search" class="form-control" placeholder="Search Subject or Section" name="query" value="">
                    </div> 
                    <div class="float-end">
                        <a type="button" href="{{url('/set-schedules')}}"  class="btn btn-primary"><i class="fas fa-sync-alt"></i></a>
                    </div>
                </form>
                
        
                <h3><i class="fas fa-calendar-alt"></i> Schedules</h3>
                    <a href=""  data-bs-toggle="modal" data-bs-target="#addSchedModal" class="btn btn-success float-start">Schedule a Subject</a>
                    @include('modals.sched-crud.schedules.add-schedule')
            </div>

            <form action="{{url('filter-schedules')}}">
                <div class="row p-3" >
                        <div class="col-2">
                            <select class="form-select" aria-label="Default select example" name="sy_filter">
                                <option value="" selected>Choose School Year</option>
                                @foreach($allsy as $sy)
                                <option value="{{$sy->school_year}}">{{$sy->school_year}}</option>
                                @endforeach
                            </select>
                        </div>
                  

                        <div class="col-2">
                            <select class="form-select" aria-label="Default select example" name="section_filter">
                                <option value=""  selected>Filter Section</option>
                                @foreach($sections as $section)
                                <option value="{{$section->section_name}}">{{$section->section_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-2">
                            <select class="form-select" name="track_filter">
                                <option value="" selected>Filter by Track</option>
                                <option value="ABM">ABM</option>
                                <option value="GAS">GAS</option>
                                <option value="HUMSS">HUMSS</option>
                                <option value="STEM">STEM</option>
                                <option value="TVL">TVL</option>
                                <option value="General Subject(SHS)">General Subject(SHS)</option>
                                <option value="Not Applicable">Not Applicable</option>
                            </select>
                        </div>

                        
                        <div class="col-2">
                            <select class="form-select" name="semester_filter">
                                <option value="" selected>Filter by Semester</option>
                                <option value="1st">1st</option>
                                <option value="2nd">2nd</option>
                                <option value="Not Applicable">Not Applicable</option>
                            </select>
                        </div>
                        
                        <div class="col-1">
                          <button type="submit"  class="btn btn-success"><i class="fas fa-filter"></i></button>
                        </div>
             
                        <div class="col-3">
                            <a href="{{url('viewplotsched')}}" type="button"  class="btn btn-success float-end"><i class="fas fa-calendar-alt"></i> View Plotted Schedules</a>
                        </div>

                        
                </div>
            </form>

            @if (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
            @endif

            @if (session('alert'))
                <div class="alert alert-danger">{{ session('alert') }}</div>
            @endif

            <div class="card-body table-responsive">
                <table class="table table-sm">
                    <thead class="table-primary">
                        <tr>
                            <th>School Year</th>
                            <th>Section</th>
                            <th>Subject Name</th>
                            <th>Semester</th>
                            <th>Days</th>
                            <th>Time Start</th>
                            <th>Time End</th>
                            <th>Teacher</th>
                            <th>Room</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($scheds) == 0)
                            <tr>
                                <div class="alert alert-danger">NO SCHEDULES FOUND<strong style="color: red">"{{"S.Y: " . $syfilter . ", Section: " . $sectionfilter  . ", Track:" . $trackfilter . ", Semester:" . $semesterfilter}}"</strong></div>  </div>
                            </tr>
                        @else
           
                            {{-- if search text is not empty --}}
                            @if(!empty($search_text))
                            <div class="alert alert-success" role="alert">Search result(s) for <strong style="color: red">"{{$search_text}}"</strong></div>
                            @endif
                            @if($syfilter != "")
                            <div class="alert alert-success" role="alert">Filter result(s) for <strong style="color: red">"{{"S.Y: " . $syfilter . ", Section: " . $sectionfilter  . ", Track:" . $trackfilter . ", Semester:" . $semesterfilter}}"</strong></div>
                            @endif
                            @foreach ($scheds as $sched)
                            <tr>
                            <input type="hidden" class="delete_val" name="id"  value="{{$sched->sched_id}}">
                            <td>{{$sched->schoolYear->school_year}}</td>
                            <td>{{$sched->section->section_name}}</td>
                            @if(!empty($sched->subject))
                            <td>{{$sched->subject->subject_name}}</td>
                            @endif
                            <td>{{$sched->semester}}</td>
                            <td>{{$sched->days}}</td>
                            <td>{{$sched->time_start}}</td>
                            <td>{{$sched->time_end}}</td>
                                @if(!empty($sched->teacher))
                                <td>{{$sched->teacher->first_name . " " . $sched->teacher->middle_name . " " . $sched->teacher->last_name . " " . $sched->teacher->suffix}}</td>
                                @else
                                <td>No Assigned Teacher</td>
                                @endif
                                {{-- <td>{{$sched->teacher->first_name}}</td> --}}
                                @if(!empty($sched->room))
                                <td>{{$sched->room->room_number}}</td>
                                @else
                                <td>No Assigned Room</td>
                                @endif
                                <td>
                                    <a href="" data-bs-toggle="modal" data-bs-target="#editSchedModal{{$sched->sched_id}}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    <button type="button" class="btn btn-danger deleteButton"><i class="fas fa-trash"></i></button>
                                    <a href="" data-bs-toggle="modal" data-bs-target="#dupSchedModal{{$sched->sched_id}}" class="btn btn-info dupButton"><i class="fas fa-copy"></i></a>
                                    @include('modals.sched-crud.schedules.edit-schedule')
                                </td>
                                @include('modals.sched-crud.schedules.duplicate-sched')
                            </tr>
                            @endforeach
                        @endif
      

                    </tbody>
                </table>
                <tr>
                    {{ $scheds->links() }}
                </tr>
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
                                url: '/delete-sched/'+delete_id,
                                data: data,
                                success: function (response) {
                                    swal('Schedule Deleted Successfully' , {
                                        icon: "success",
                                    }) 
                                    .then((result) => {
                                        // window.location.reload();
                                        window.location.href = '/set-schedules';
                                    });
                                },
                                error: function (reject) {
                                swal('Schedule is associated with an existing grade. Cannot be deleted!' , {
                                icon: "error",
                                }) 
                                .then((result) => {
                                    window.location.href = '/set-schedules';
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