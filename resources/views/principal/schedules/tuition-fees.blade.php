@extends('layouts.master')
@section('title', 'Tuition Fees')
@section('content')
{{-- <div class="container-fluid"> --}}
    <div class="card vh-100">
        <div class="card-header tableCardHeader">
            <h3><i class="fas fa-money-check-alt"></i> Student Fees</h3>
        </div>

        <div class="card-body">
            @if (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
             @endif
             {{-- @if($errors->has('for_grade_lvl'))
             <span class="text-danger">{{ $errors->first('for_grade_lvl') }}</span>
             @endif --}}
            <div class="table-responsive">
                <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Grade Level</th>
                        <th>Tuition Fee</th>
                        <th>Miscellaneous Fee</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($fees) == 0)
                    <div class="alert alert-danger">No Tuition Fee found.</div>
                    @else
                    @foreach ($fees as $fee)
                                <tr>
                                    <input type="hidden" class="delete_val" id="delete_val" value="{{ $fee->tf_id }}">
                                    @if ($fee->for_grade_lvl == 0)
                                    <td>Kinder</td>
                                    @else
                                    <td>Grade {{  $fee->for_grade_lvl }}</td>
                                    @endif
                               
                                    <td>₱{{  number_format($fee->tuition_fee, 2, '.', ',') }}</td>
                                    <td>₱{{  number_format($fee->misc_fee, 2, '.', ',') }}</td>
                                    <td>₱{{  number_format($fee->misc_fee + $fee->tuition_fee, 2, '.', ',') }}</td>
                                    <td> 
                                        <a type="button" data-bs-toggle="modal" data-bs-target="#editFeeModal{{ $fee->tf_id }}" class="btn btn-warning"><span class="btn-label"><i class="fas fa-edit"></i></span></a>
                                        <a type="button" class="btn btn-danger deleteButton"><span class="btn-label"><i class="fas fa-trash"></i></span></a>
                                    </td>
                                </tr>
                                @include('modals.sched-crud.fees.edit-fee')
                        @endforeach
                    @endif
                </tbody>
                </table>
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
                            url: 'delete-fee/'+delete_id,
                            data: data,
                            success: function (response) {
                                swal('Fee Deleted Successfully' , {
                                    icon: "success",
                                }) 
                                .then((result) => {
                                    window.location.href = '/tuition-fees';
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