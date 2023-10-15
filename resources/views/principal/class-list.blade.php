@extends('layouts.master')
@section('content')
    <div class="card feeCard">
        <div class="card-header tableCardHeader">
            <h3><i class="fas fa-calendar-alt"></i> Class Lists</h3>
        </div>
        <form action="{{ url('principal-select-year') }}">
            <div class="row p-3" >
                <div class="col-md-3">
                    <select class="form-select" aria-label="Default select example" name="select_section" required>
                        <option value="" selected>Select Section</option>
                        @foreach($sections as $section)
                        <option value="{{$section->section_id}}" >{{$section->section_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <button type="submit"  class="btn btn-success"><i class="fas fa-filter"></i></button>
                </div>
            </div>
        </form>

        @if (session('message'))
        <div class="alert alert-success" role="alert">{{ session('message') }}</div>
        @endif

        @if (session('alert'))
        <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
        @endif

        @if (!empty($students))
        @if(count($students) == 0)
        <div class="alert alert-danger" role="alert">No students found for this section.</div>
        @else
       
        <div class="table-responsive ">
            <table class="table table-sm table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>LRN</th>
                    <th>Full Name</th>
                    {{-- <th>Current Grade Level</th>
                    <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @php
                    $c = 1;
                @endphp
                 <form action="{{url('class-list-report')}}" method="POST">
                 @csrf
                 <button type="submit" class="btn btn-outline-danger float-end m-3"><i class="fas fa-file-export"></i> Generate Report</button>
                 <form action="{{url('teacher-view-grades')}}" method="POST">
                    @csrf
                 @foreach ($students as $student)
                            <tr>
                                <input type="hidden" name="id[]" value="{{$student->id}}">
                                <td>{{$c}}</td>
                                <td>{{ $student->lrn }}</td>
                                <td>{{ $student->last_name . ", " . $student->first_name . " " . $student->middle_name . " " . $student->suffix}}</td>
                                {{-- <td>{{ $student->grade_lvl }}</td> --}}
                                {{-- <td> 
                                    <button type="submit" class="btn btn-info btn-sm"><span class="btn-label"><i class="fas fa-eye"></i> View Grades</span></button>
                                </td> --}}
                       
                            </tr>
                            @php
                                $c++;
                            @endphp
                    @endforeach
                {{-- @endif --}}
                </tbody>
          
            </table>

        </div>
        </form>
        @endif
        @endif
    </div>  
@endsection
