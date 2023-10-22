@extends('layouts.master')
@section('title', 'Rooms')
@section('content')
{{-- <div class="container-fluid"> --}}
    <div class="card vh-100">
        <div class="card-header tableCardHeader">
            <form action="{{ url('searchRoom') }}" type="get">
                <div class="col-md-3 float-end">
                    <input type="search" class="form-control" placeholder="Search Room" name="query">
                </div> 
                <div class="float-end">
                    <a type="button" href="{{url('/rooms')}}"  class="btn btn-primary"><i class="fas fa-sync-alt"></i></a>
                </div>
            </form>
            <h3><i class="fas fa-door-open"></i> Rooms</h3>
            <a data-bs-toggle="modal" data-bs-target="#addRoomModal" class="btn btn-success float-start">Add Room</a>
            @include('modals.sched-crud.rooms.add-room')
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
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($rooms) == 0)
                    <div class="alert alert-danger">No Rooms found.</div>
                    @else
                        @foreach ($rooms as $room)
                        @if(!empty($search_text))
                        <div class="alert alert-success" role="alert">Search result(s) for "{{$search_text}}"</div>
                        @endif
                                    <tr>
                                        <input type="hidden" class="delete_val" id="delete_val" value="{{$room->room_id}}">
                                        <td>{{ $room->room_number }}</td>
                                        <td>{{ $room->room_type }}</td>
                                        <td> 
                                            <a type="button" data-bs-toggle="modal" data-bs-target="#editRoomModal{{$room->room_id}}" class="btn btn-warning"><span class="btn-label"><i class="fas fa-edit"></i></span></a>
                                            <a type="button" class="btn btn-danger deleteButton"><span class="btn-label"><i class="fas fa-trash"></i></span></a>
                                        </td>
                                    </tr>
                                    @include('modals.sched-crud.rooms.edit-room')
                        @endforeach
                    @endif
                </tbody>
                </table>
                <tr>
                    {{$rooms->links()}}
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
                            url: 'delete-room/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('Room Deleted Successfully' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/rooms';
                                });
                            },
                            error: function (reject) {
                                swal('Room is associated with an existing schedule. Cannot be deleted!' , {
                                icon: "error",
                                }) 
                                .then((result) => {
                                    window.location.href = '/rooms';
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