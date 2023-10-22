@extends('layouts.master')
@section('content')
    <div class="card vh-100">
        <div class="card-header tableCardHeader">
            <h3><i class="fas fa-calendar-alt"></i> Advisory Class</h3>
        </div>
        <form action="{{ url('select-year') }}">
            <div class="row p-3" >
                <div class="col-md-3">
                    <select class="form-select" aria-label="Default select example" name="select_year">
                        <option value=""  selected>Select School Year</option>
                        
                        @foreach($syears as $syear)
                        <option value="{{$syear->sy_id}}" {{ ($selectedYear==$syear->sy_id)? "selected" : "" }}>{{$syear->school_year}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <select class="form-select" aria-label="Default select example" name="select_sem" required> 
                        <option value="" selected>Select Semester</option>
                        <option value="1st" {{ ($semester=="1st")? "selected" : "" }}>1st</option>
                        <option value="2nd"  {{ ($semester=="2nd")? "selected" : "" }}>2nd</option>
                        <option value="Not Applicable" {{ ($semester=="Not Applicable")? "selected" : "" }} >Not Applicable</option>
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
        @if (count($students) == 0)
        {{-- <div class="alert alert-danger">No students found.</div> --}}
        @else
      
        <div class="card m-3">
        @if(!empty($students))
            @foreach($list as $l)
                <div class="card-header">
                    <h6>School Year: {{$syear->school_year}}</h6>
                    <h6>Semester: {{$semester}}</h6>
                    <h6>Grade: @if($l->section_grade_lvl == 0)Kinder @else {{$l->section_grade_lvl}}@endif</h6>
                    <h6>Section: {{$section = $l->section_name}}</h6>
                </div>
             @endforeach
        @endif

        <div class="table-responsive m-3">
          
          
            <table class="table table-sm table-hover">
            <thead class="table-primary">
                <tr>
                    <th>LRN</th>
                    <th>Full Name</th>
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
                                <input type="hidden" class="delete_val" id="delete_val" name="selectedYear" value="{{$syear->sy_id}}">
                                <input type="hidden" name="semester" value="{{$semester}}">
                                <input type="hidden" name="section" value="{{$section}}">
                                <td>{{ $student->lrn }}</td>
                                <td>{{ $student->last_name . ", " . $student->first_name . " " . $student->middle_name . " " . $student->suffix  }}</td>
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
    </div>  
@endsection
