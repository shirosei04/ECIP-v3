@extends('layouts.master')
@section('title', 'Awards')
@section('content')
{{-- <div class="container-fluid"> --}}
    <div class="card">
        <div class="card-header tableCardHeader">
            <form action="{{ url('searchawardee') }}" type="get">
                <div class="col-md-3 float-end">
                    <input type="search" class="form-control" placeholder="Search Award or Awardee" name="query">
                </div> 
                <div class="float-end">
                    <a type="button" href="{{url('/awardees')}}"  class="btn btn-primary"><i class="fas fa-sync-alt"></i></a>
                </div>
            </form>
            <h3><i class="fas fa-trophy"></i> Awardees</h3>
        </div>

        {{-- <div class="card-body"> --}}
            @if (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
             @endif
             @if (session('alert'))
             <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
              @endif
            <div class="table-responsive">
                <table class="table table-responsive table-hover table-sm">
                <thead class="table-primary">
                    <tr>
                        {{-- <th>LRN</th> --}}
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Award</th>
                        <th>Date Awarded</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($awardees) == 0)
                    <div class="alert alert-danger">No data found {{ $search_text }}</div>
                    @else
                    @foreach ($awardees as $awardee)
                    @if(!empty($search_text))
                    <div class="alert alert-success">Results for <strong style="color: red">"{{ $search_text }}"</strong></div>
                    @endif
                        <tr>
                            <input type="hidden" class="delete_val" id="delete_val" value="{{$awardee->id}}">
                            <td>{{ $awardee->last_name }}</td>
                            <td>{{ $awardee->first_name }}</td>
                            <td>{{ $awardee->award_name }}</td>
                            <td>{{date('F d, Y', strtotime($awardee->date_awarded))}}</td>
                            <td> 
                                <a type="button" class="btn btn-danger deleteButton"><span class="btn-label"><i class="fas fa-trash"></i></span></a>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <tr>
                    {{$awardees->links()}}
                </tr>
            </div>
        {{-- </div> --}}
        
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
                            url: 'delete-awardee/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('Awardee Deleted Successfully' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/awardees';
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