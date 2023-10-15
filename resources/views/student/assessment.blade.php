@extends('layouts.master')
@section('title', 'Assessment')

@section('content')
        <div class="card feeCard">
            <div class="card-header tableCardHeader">
                @if (Auth::user()->role == "Student")
                <h3><i class="fas fa-dollar-sign"></i> Assessment</h3>
                @else
                    @foreach ($student as $stud )
                    <h3><i class="fas fa-dollar-sign"></i> Assessment of {{$stud->first_name . " " . $stud->middle_name . " " . $stud->last_name . " " . $stud->suffix}} </h3>
                    @endforeach
                @endif
                
            </div>
            @if (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
            @endif

            @if (session('alert'))
                <div class="alert alert-danger">{{ session('alert') }}</div>
            @endif
                <div class="row p-3">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3">
                    
                    </div>
                    <div class="col-md-3">
                       
                    </div>
                    <div class="col-md-3 pb-3">
                        <label for="" class="col-md-4 col-form-label fw-bold fs-4">{{ __('Total Due:') }}</label>
                        <input type="text" class="form-control fw-bold fs-4" value="₱{{number_format($allFees, 2) }}" disabled>
                    </div>
                </div>

                @foreach ($myFees as $fee)
                <form action="{{ url('assessment-report') }}" method="POST">
                    @csrf

                <div class="container-fluid mt-3">
                    <div class="card-header h4 fw-bold">
                     S.Y {{$fee->school_year}} 
                        {{-- <button type="button" class="btn btn-success float-end mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#paymentModal{{$fee->student_id}}">Manage</button> --}}
                        @if (Auth::user()->role == "Admission Officer")
                        <button type="button" class="btn btn-success float-end mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#paymentModal{{$fee->studfee_id}}">Manage</button>
                        @endif
                   
                        <button type="submit" class="btn btn-outline-danger  float-end me-3 mb-3 btn-sm">Generate Report</button>
                      </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Transaction Description</th>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <input type="hidden" name="id" value="{{ $fee->studfee_id }}">
                                <td>{{$fee->payment_desc}}</td>
                                <td>{{$fee->payment_date}}</td>
                                <td>{{number_format($fee->payment_amount, 2)}}</td>
                             
                            </tr>
                          
                            @foreach ($fee->audits as $audit)      
                                <tr>
                                    <td>{{$audit->transaction_description}}</td>
                                    <td>{{$audit->transaction_date}}</td>
                                    @if($audit->transaction_type == "Deduct")
                                    <td>{{"-". number_format($audit->transaction_amount, 2)}}</td>
                                    @else
                                    <td>{{"+". number_format($audit->transaction_amount, 2)}}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </form>
                    @include('modals.payment-modal')
                      </table>
                      <div class="row p-3">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3 pb-3">
                            <label for="" class="col-form-label fw-bold text-start">{{ __('Running Balance:') }}</label>
                            <input type="text" class="form-control" value="{{"₱". number_format($fee->running_balance, 2)}}" disabled>
                        </div>
                    </div>
                  
                </div>
                @endforeach
             
        
        </div>

@endsection
