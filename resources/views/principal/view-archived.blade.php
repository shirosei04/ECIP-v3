@extends('layouts.master')
@section('title', 'View Archived')
@section('content')
<div class="container-fluid ">
    
    <div class="card mt-3 spinnerTarget">
        <div class="card-header tCardHeader">
            <h3><i class="far fa-eye"></i> Viewing Details for {{$enrollee->first_name }} {{$enrollee->last_name}}</h3>
        </div>
        @if (session('message'))
        <div class="alert alert-success" role="alert">{{ session('message') }}</div>
        @endif
        <div class="card-body">
            <form method="POST" action="{{ url('accept-user/'.$enrollee->id) }}">  
                @csrf
                @method('PUT')
                        <div class="container cardContent">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="card">
                                        <center>
                                        <div class="card-body">
                                                <p class="text-center fs-5 fw-bold lsa">BASIC INFORMATION</p>
                                                @if($enrollee->status == "0")
                                                    <div class="alert alert-warning alert-fixed sticky-top">
                                                        <i class="fas fa-exclamation-triangle"></i> This is an archived user
                                                    </div>
                                                @else
                                                    @if(empty($enrollee->student))
                                                    <div class="alert alert-danger alert-fixed sticky-top">
                                                        <i class="fas fa-exclamation-triangle"></i> This student has incomplete profile details. Cannot be accepted.
                                                    </div>
                                                    @endif
                                                @endif
                                              
                                                <hr class="mt-0 mb-0">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('Date of Registration') }}</label>
                                                        <p>{{$enrollee->date_of_registration}}</p>
                                                    </div>
                        
                                                    {{-- Sex --}}
                                            
                                                    <div class="col-md-4">
                        
                                                    </div>
                        
                                                    <div class="col-md-4 ">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('Sex') }}</label>
                                                        <p>{{$enrollee->sex}}</p>
                                            
                                                </div>
                                                
                                                </div>
                                                <hr class="mt-0 mb-0">
                                                {{--GL & LRN --}}
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="" class="col-6 col-form-label fw-bold">{{ __('Grade Level') }}</label>
                                                        @if(!empty($enrollee->student))
                                                            @if($enrollee->student->grade_lvl == 0)
                                                            <p>Kinder</p>
                                                            @else
                                                            <p>{{ $enrollee->student->grade_lvl }}</p>
                                                            @endif
                                                        @else
                                                            <p>No Grade Level Retrieved</p>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-4">
                        
                                                    </div>
                        
                                                    <div class="col-md-4">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('Learner Reference Number') }}</label>
                                                        @if(!empty($enrollee->student))
                                                            <p>{{ $enrollee->student->lrn }}</p>
                                                        @else
                                                            <p>No LRN Retrieved</p>
                                                        @endif
                                                    </div>
                                                </div> 
                                                <hr class="mt-0 mb-0">
                                                {{-- Name --}}
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="" class="col-form-label fw-bold">{{ __('First Name') }}</label>
                                                        <p>{{ $enrollee->first_name }}</p>
                                                    </div>
                        
                                                    <div class="col-md-3">
                                                        <label for="" class="col-form-label fw-bold">{{ __('Middle Name') }}</label>
                                                        <p>{{ $enrollee->middle_name }}</p>
                                                    </div>
                        
                                                    <div class="col-md-3">
                                                        <label for="" class="col-form-label fw-bold">{{ __('Last Name') }}</label>
                                                        <p>{{ $enrollee->last_name }}</p>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="" class="col-form-label fw-bold">{{ __('Suffix') }}</label>
                                                        <p>{{ $enrollee->suffix }}</p>
                                                    </div>
                                                </div> 
                                                <hr class="mt-0 mb-0">
                                                {{-- BIRTH DETAILS --}}
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="bdate" class="col-md-4 col-form-label fw-bold">{{ __('Birth Date') }}</label>
                                                        <p>{{ $enrollee->birth_date }}</p>
                                                    </div>
                        
                                                    <div class="col-md-6">
                                                        <label for="bplace" class="col-md-4 col-form-label fw-bold">{{ __('Birth Place') }}</label>
                                                        <p>{{ $enrollee->birth_place }}</p>
                                                    </div>
                                                </div>
                                                
                                                <hr class="mt-0 mb-0">
                                                {{-- Address --}}
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('Region') }}</label>
                                                        <p>{{ $enrollee->region }}</p>
                                                    </div>
                        
                                                    <div class="col-md-2">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('Province') }}</label>
                                                        <p>{{ $enrollee->province }}</p>
                                                    </div>
                        
                                                    <div class="col-md-2">
                                                        <label for="city" class="col-12 col-form-label fw-bold">{{ __('City') }}</label>
                                                        <p>{{ $enrollee->city }}</p>
                                                    </div>
                        
                                                    <div class="col-md-2">
                                                        <label for="city" class="col-12 col-form-label fw-bold">{{ __('Barangay') }}</label>
                                                        <p>{{ $enrollee->barangay }}</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('House #/Street') }}</label>
                                                        {{-- <input id="building" type="text" class="form-control" name="" value=""  > --}}
                                                        <p>{{ $enrollee->house_no }}</p>
                                                    </div>
                                                </div>
                                                <hr class="mt-0 mb-0">
                                                {{-- Nationality & Religion --}}
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="" class="col-6 col-form-label fw-bold">{{ __('Nationality') }}</label>
                                                        <p>{{ $enrollee->nationality }}</p>
                                                    </div>
                        
                                                    <div class="col-md-3">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('Religion') }}</label>
                                                        <p>{{ $enrollee->religion }}</p>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="" class="col-6 col-form-label fw-bold">{{ __('Ethnicity') }}</label>
                                                        <p>{{ $enrollee->ethnicity }}</p>
                                                    </div>
                        
                                                    <div class="col-md-3">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('Mother Tongue') }}</label>
                                                        <p>{{ $enrollee->mother_tongue }}</p>
                                                    </div>
                                                </div>
                        
                                                {{-- Ethnicity & Mother tongue --}}
                                                {{-- <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="" class="col-6 col-form-label fw-bold">{{ __('Ethnicity') }}</label>
                                                        <p>{{ $enrollee->ethnicity }}</p>
                                                    </div>
                        
                                                    <div class="col-md-6">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('Mother Tongue') }}</label>
                                                        <p>{{ $enrollee->mother_tongue }}</p>
                                                    </div>
                                                </div> --}}
                                                <hr class="mt-0 mb-0">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('Are you a 4Ps Beneficiary?') }}</label>
                                                        @if(!empty($enrollee->student))
                                                            @if($enrollee->student->is_4ps_member == '0')
                                                            <p>No</p>
                                                            @else
                                                            <p>Yes</p>
                                                            @endif
                                                        @else
                                                            <p>No Data Retrieved</p>
                                                        @endif
                                                    
                                                    </div>
                        
                                                    <div class="col-6">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('Enrolled in Madrasah? (For Muslims ONLY)') }}</label>
                                                        @if(!empty($enrollee->student))
                                                            @if($enrollee->student->is_madrasah_enrolled == '0')
                                                            <p>No</p>
                                                            @else
                                                            <p>Yes</p>
                                                            @endif
                                                        @else
                                                            <p>No Data Retrieved</p>
                                                        @endif
                                                    
                                                    </div>
                                                </div>
                                                <hr class="mt-0 mb-0">
                                                {{-- Telephone  & CP Number --}}
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="" class="col-6 col-form-label fw-bold">{{ __('Telephone Number') }}</label>
                                                        <p>{{$enrollee->tel_no}}</p>
                                                    </div>
                        
                                                    <div class="col-md-3">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('Cellphone Number') }}</label>
                                                        <p>{{$enrollee->cell_no}}</p>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="" class="col-6 col-form-label fw-bold">{{ __('Email Address') }}</label>
                                                        <p>{{$enrollee->email}}</p>
                                                    </div>
                        
                                                    <div class="col-md-3">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('Facebook Account') }}</label>
                                                        <p>{{$enrollee->fb_account}}</p>
                                                    </div>
                                                </div>
                                                <hr class="mt-0 mb-0">
                                                {{-- Email Address & FB Account --}}
                                                {{-- <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="" class="col-6 col-form-label fw-bold">{{ __('Email Address') }}</label>
                                                        <p>{{$enrollee->email}}</p>
                                                    </div>
                        
                                                    <div class="col-md-6">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('Facebook Account') }}</label>
                                                        <p>{{$enrollee->fb_acc}}</p>
                                                    </div>
                                                </div> --}}
                                                <div class="row">
                                                    <div class="col-md-6 ">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('How do you go to school?') }}</label>
                                                        @if(!empty($enrollee->student))
                                                            <p>{{$enrollee->student->mogts}}</p>
                                                        @else
                                                            <p>No Data Retrieved</p>
                                                        @endif
                                                        
                                                    </div>
                        
                                                    <div class="col-md-6 ">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('Do you have an available guardian for remote learning?') }}</label>
                                                        @if(!empty($enrollee->student))
                                                            @if($enrollee->student->hgfrl == '0')
                                                            <p>No</p>
                                                            @else
                                                            <p>Yes</p>
                                                            @endif
                                                        @else
                                                            <p>No Data Retrieved</p>
                                                        @endif
                                                    
                                                    </div>
                                                </div>
                                                <hr class="mt-0 mb-0" class="regHr">
                                                @if(!empty($enrollee->student->past_school))
                                                    <p class="text-center fs-5 fw-bold lsa">LAST SCHOOL ATTENDED (<span class="nso">TRANSFEREES ONLY</span>)</p>
                                                    <hr class="mt-0 mb-0">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <label for="" class="col-12 col-form-label fw-bold">{{ __('Name of School') }}</label>
                                                            <p>{{$enrollee->student->past_school}}</p>
                                                        </div>
                            
                                                        <div class="col-4">
                                                            <label for="" class="col-12 col-form-label fw-bold">{{ __('School ID') }}</label>
                                                            <p>{{$enrollee->student->past_school_id}}</p>
                                                        </div>

                                                        <div class="col-4">
                                                            <label for="" class="col-12 col-form-label fw-bold">{{ __('School Address') }}</label>
                                                            <p>{{$enrollee->student->past_school_address}}</p>
                                                        </div>
                                                    </div>
                            
                    
                                                    <hr class="mt-0 mb-0">
                                                @endif
                                            
                                                <p class="text-center fs-5 fw-bold lsa">COVID-19 RELATED INFORMATION</p>
                        
                                                <div class="row">
                                                    <div class="col-6 ">
                                                        <label for="" class="col-12 col-form-label fw-bold">{{ __('Vaccination Status') }}</label>
                                                        @if(!empty($enrollee->student))
                                                            <p>{{$enrollee->student->vaccine_status}}</p>
                                                        @else
                                                            <p>No Data Retrieved</p>
                                                        @endif
                                                    </div>
                        
                                                    <div class="col-6 ">
                                                        <div class="row">
                                                            <label for="" class="col-12 col-form-label fw-bold">{{ __('With Comorbidity?') }}</label>
                                                            @if(!empty($enrollee->student))
                                                                @if($enrollee->student->has_comorbidity == '0')
                                                                <p>No</p>
                                                                @else
                                                                <p>Yes</p>
                                                                <p>{{$enrollee->student->illnesses}}</p>
                                                                @endif
                                                            @else
                                                                <p>No Data Retrieved</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="mt-0 mb-0">
                                                <p class="text-center fs-5 fw-bold lsa">PARENT/GUARDIAN INFORMATION</p>
                                                    @foreach($enrollee->parents as $parent)
                                                        <hr class="mt-0 mb-3"> 
                                                        <p class="fw-bold text-uppercase">{{$parent->relationship}} INFORMATION</p>
                                                        <hr class="mt-0 mb-0">
                                                            <div class="row mb-3">
                                                                <div class="col-md-3">
                                                                    <label for="" class="col-12 col-form-label fw-bold">First Name</label>
                                                                    {{$parent->first_name}}
                                                                </div>
                                    
                                                                <div class="col-md-3">
                                                                    <label for="" class="col-12 col-form-label fw-bold">{{ __('Middle Name') }}</label>
                                                                    {{$parent->middle_name}}v
                                                                </div>
                                    
                                                                <div class="col-md-3">
                                                                    <label for="" class="col-12 col-form-label fw-bold">{{ __('Last Name (Maiden Name)') }}</label>
                                                                    {{$parent->last_name}}
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label for="" class="col-12 col-form-label fw-bold">{{ __('Suffix') }}</label>
                                                                    {{$parent->suffix}}
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row mb-3">
                                                                <div class="col-md-3">
                                                                    <label for="" class="col-12 col-form-label fw-bold">{{ __('Occupation') }}</label>
                                                                    {{$parent->occupation}}
                                                                </div>
                                    
                                                                <div class="col-md-3">
                                                                    <label for="" class="col-12 col-form-label fw-bold">{{ __('Contact Number') }}</label>
                                                                    {{$parent->contact_no}}
                                                                </div>
                                    
                                                                <div class="col-md-3">
                                                                    <label for="" class="col-12 col-form-label fw-bold">{{ __('Email Address') }}</label>
                                                                    {{$parent->email}}
                                                                </div>
                                    
                                                                <div class="col-md-3">
                                                                    <label for="" class="col-12 col-form-label fw-bold">{{ __('Facebook Account') }}</label>
                                                                    {{$parent->fb_account}}
                                                                </div>
                                                            </div>
                                                    @endforeach
                                            
                    
                                            
                                        </div>
                                    </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
            </div>
            <div class="card-footer justify-content-center">
                <div class="d-flex mb-3">
                    <input type="hidden" class="delete_val" id="delete_val" value="{{$enrollee->id}}">
                        <a type="button" class="btn btn-primary me-auto p-2" href="{{url('/archived-list')}}"><span class="btn-label"><i class="fas fa-chevron-left"></i></span> Back to List</a>

                </form>
                        <a type="button" class="btn btn-warning p-2 me-2 unarchiveBtn"><span class="btn-label"><i class="fas fa-archive"></i></span> Unarchive</a>
                        <a type="button" class="btn btn-danger p-2 me-2 deleteBtn"><span class="btn-label"><i class="fas fa-trash"></i></span> Delete</a>
                </div>
              
            </div>
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


    // UNARCHIVE USER
    $('.unarchiveBtn').click(function (e) {
        e.preventDefault();
        // var spinner  = '<div class="loader fs-3 fw-bold">Please wait...</div>';
        var delete_id = $(this).closest("div").find('.delete_val').val();
            swal({
            title: "Are you sure?",
            text: "Once unarchived, you cannot undo it",
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
                        url: '/view-archived/unarchive-user/'+delete_id,
                        data: data,
                        success: function (response) {
                            swal('User Unarchived Successfully' , {
                                icon: "success",
                            }) 
                            .then((result) => {
                                window.location.href = '/archived-list';
                            });
                        }
                    });
                } else {
                    swal("No Changes Made :)");
                }
        });
    });

    //DELETE USER
    $('.deleteBtn').click(function (e) {
            e.preventDefault();
            var spinner  = '<div class="loader fs-3 fw-bold">Please wait...</div>';
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
                        $('.spinnerTarget').html(spinner);
                        var data = {
                            "_token": $('input[name="_token"]').val(),
                            "id": delete_id,
                        };
                        $.ajax({
                            type: "DELETE",
                            url: '/view-archived/delete-user/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('User Deleted Successfully' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/archived-list';
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