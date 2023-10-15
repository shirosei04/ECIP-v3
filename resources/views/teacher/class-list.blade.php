@extends('layouts.master')
@section('content')
    <div class="card feeCard">
        <div class="card-header tableCardHeader">
            <h3><i class="fas fa-calendar-alt"></i> Advisory Class</h3>
        </div>
        <form action="{{ url('select-year') }}">
            <div class="row p-3" >
                <div class="col-md-3">
                    <select class="form-select" aria-label="Default select example" name="select_year">
                        <option value=""  selected>Select School Year</option>
                        @foreach($syears as $year)
                        <option value="{{$year->sy_id}}" >{{$year->school_year}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <select class="form-select" aria-label="Default select example" name="select_sem" required> 
                        <option value="" selected>Select Semester</option>
                        <option value="1st" >1st</option>
                        <option value="2nd" >2nd</option>
                        <option value="Not Applicable" >Not Applicable</option>
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
        {{-- @foreach($students as $student)
        <tr>
            <td>{{$student->section_name}}</td>
           <td>{{$student->first_name}}</td>
        </tr>
        @endforeach --}}
        <div class="table-responsive ">
            @if(!empty($students))
            <div class="alert alert-success">
                @foreach($list as $l)
                <strong>School Year: </strong> {{$year->school_year}}<strong> / Grade:</strong> @if($l->section_grade_lvl == 0)Kinder @else {{$l->section_grade_lvl}}  @endif <strong> / Section:</strong> {{$l->section_name}}
                @endforeach
            </div>
            @endif
            @if (count($students) == 0)
            <div class="alert alert-danger">No students found.</div>
            @else
            <table class="table table-sm table-hover">
            <thead class="table-primary">
                <tr>
                    <th>LRN</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Suffix</th>
                    <th>Current Grade Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
  
                @foreach ($students as $student)
                {{-- @if(!empty($search_text))
                <div class="alert alert-success">Results for <strong style="color: red">"{{ $search_text }}"</strong></div>
                @endif --}}
                            <form action="{{url('teacher-view-grades')}}" method="POST">
                                @csrf
                            <tr>

                                <input type="hidden" class="delete_val" id="delete_val" name="student_id" value="{{$student->id}}">
                                <input type="hidden" class="delete_val" id="delete_val" name="selectedYear" value="{{$year->sy_id}}">
                                <input type="hidden" name="semester" value="{{$semester}}">
                                <td>{{ $student->lrn }}</td>
                                <td>{{ $student->last_name }}</td>
                                <td>{{ $student->first_name }}</td>
                                <td>{{ $student->middle_name }}</td>
                                <td>{{ $student->suffix }}</td>
                                <td>{{ $student->grade_lvl }}</td>
                                <td> 
                                    <button type="submit" class="btn btn-info btn-sm"><span class="btn-label"><i class="fas fa-eye"></i> View Grades</span></button>
                                </td>
                            </form>
                            </tr>
              
                    @endforeach
                @endif
                </tbody>
          
            </table>
            {{-- <tr>
                {{$users->links()}}
            </tr> --}}
        </div>
    </div>  
@endsection
