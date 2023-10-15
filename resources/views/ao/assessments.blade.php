@extends('layouts.master')
@section('title', 'Assessment')

@section('content')
        <div class="card pb-5 vh-100">
            
            <div class="card-header tableCardHeader">
                <form action="{{ url('searchao') }}" type="get">
                    <div class="col-md-3 float-end">
                        <input type="search" class="form-control" placeholder="Search Student or LRN" name="query">
                    </div> 
                    <div class="float-end">
                        <a type="button" href="{{url('/ao-list')}}"  class="btn btn-primary"><i class="fas fa-sync-alt"></i></a>
                    </div>
                </form>
                <h3><i class="fas fa-dollar-sign"></i> Student Assessments</h3>
            </div>
            @if (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
            @endif

            @if (session('alert'))
                <div class="alert alert-danger">{{ session('alert') }}</div>
            @endif

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>School Year</th>
                        <th width="10%">LRN</th>
                        <th>Student</th>
                        <th>Transaction Description</th>
                        <th>Running Balance</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach($fees as $fee)
                        <tr>
                            <td>{{$fee->school_year}}</td>
                            <td>{{$fee->lrn}}</td>
                            <td>{{$fee->first_name . " " . $fee->middle_name . " " . $fee->last_name . " " . $fee->suffix}}</td>
                            <td>{{$fee->payment_desc}}</td>
                            <td>{{$fee->running_balance}}</td>
                            <td>  
                                <a href="{{url('/view-assessment/'.$fee->student_id)}}"  type="button" class="btn btn-info"><span class="btn-label"><i class="far fa-eye"></i></span> View</a>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal{{$fee->studfee_id}}">Manage</button>
                            </td>
                            @include('modals.payment-modal')
                        </tr>
                        @endforeach
                    </tr>
    
        
                </tbody>
            </table>
            <tr>
                {{$fees->links()}}
            </tr>
        </div>

@endsection