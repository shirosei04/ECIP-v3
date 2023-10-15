@extends('layouts.master')
@section('content')

<div class="mainCard">
    <div class="">
  
        <center>
            <div class="fs-1 fw-bold text-white announcement-header m-3">
                <img src="{{asset('img/logo4.png')}}" alt="" style="height: 90px; width: auto" class="pt-2">
                    EDUCARE COLLEGE INC. ANNOUNCEMENTS
            </div>
        </center>
           
            <div class="d-grid gap-2 col-6 mx-auto">
                @if(Auth::user()->role == 'Principal')
                <a href="" type="button" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal" class="btn btn-success text-center btn-lg m-3"><i class="fas fa-bullhorn"></i> Make New Announcement</a>
                @include('modals.add-announcement')
                @endif
            </div>

        <div class="">
            @if(count($announcements) == 0)
                {{-- <div class="alert complementary-orange m-3">
                    <img src="{{asset('img/nein.png')}}" alt="" style="height: 300px; width: auto;" class="center">
                </div> --}}
                
                {{-- <div class="noAnnouncement">
                    <img src="{{asset('img/no.jpg')}}" alt="" style="height: 300px; width: auto;" class="center">
                </div> --}}
                <div class="no-announcement fw-bold">
                    {{-- <img src="{{asset('img/bruh.png')}}" alt="" style="height: 300px; width: auto;" class="center pt-3 "> --}}
                    NO ANNOUNCEMENTS
                </div>  
            @endif

            @foreach($announcements as $announcement)
            <div class="card annCard mb-3 mt-3">
                <div class="card-body">
                    @if(Auth::user()->role == 'Principal')
                        <input type="hidden" class="delete_val" id="delete_val" value="{{$announcement->announcement_id}}">
                        <a type="button" class="btn btn-danger m-2 btn-sm float-end deleteButton"><i class="fas fa-trash"></i></a>
                        <a type="button" class="btn btn-warning m-2 btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal{{$announcement->announcement_id}}"><i class="far fa-edit"></i></a>
                        @include('modals.edit-announcement')
                    @endif
                    @if($announcement->sex == 'Male')
                        <div class=" mx-auto d-block mb-2 ">
                            <span><img src="https://cdn2.iconfinder.com/data/icons/ios-7-icons/50/user_male2-512.png" class="img-fluid ms-auto mx-auto mb-0 mt-2 logo-image" style="height: 50px; width: 50px"> <strong>{{$announcement->first_name}} {{$announcement->middle_name}} {{$announcement->last_name}} </strong>   <em><small class="text-muted">at {{date('F d, Y h:i A', strtotime($announcement->posted_at))}}</small></em>
                            </span>
                            </div>
                        @else
                        <div class=" mx-auto d-block  mb-2">
                            <span><img src="https://cdn2.iconfinder.com/data/icons/ios-7-icons/50/user_female2-512.png" class="img-fluid ms-auto mx-auto mb-0 mt-2 logo-image" style="height: 50px; width: 50px"> <strong>{{$announcement->first_name}} {{$announcement->middle_name}} {{$announcement->last_name}} </strong>   <em><small class="text-muted">at {{date('F d, Y h:i A', strtotime($announcement->posted_at))}}</small></em>
                            </span>
                        </div>
                    @endif
                <h6 class="card-title mb-1">{{$announcement->announcement_title}}</h6>
                <p class="card-text">{{$announcement->announcement_content}}</p>
                </div>
                @if($announcement->announcement_img != null)
                <div>
                    <img src="{{ asset($announcement->announcement_img) }}" class="card-img-bottom img img-responsive" alt="error.png">
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>  
    <div class="loader fs-1 text-white fw-bold">
   
    </div>
</div>
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
            
            var delete_id = $(this).closest("div").find('.delete_val').val();
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
                            url: 'delete-announcement/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('Announcement Deleted Successfully' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/announcements';
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