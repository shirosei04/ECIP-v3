@extends('layouts.master')
@section('content')
    <div class="card feeCard">
        <div class="card-header tableCardHeader">
            <h3><i class="fas fa-calendar-alt"></i> Subjects Handled</h3>
        </div>
        <form action="{{ url('subject-select-year') }}">
            <div class="row p-3" >
                <div class="col-md-3">
                    <select class="form-select" aria-label="Default select example" name="select_year">
                        <option value=""  selected>Select School Year</option>
                        @foreach($syears as $year)
                        <option value="{{$year->sy_id}}" >{{$year->school_year}}</option>
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
        {{-- @foreach($students as $student)
        <tr>
            <td>{{$student->section_name}}</td>
           <td>{{$student->first_name}}</td>
        </tr>
        @endforeach  --}}
        <div class="table-responsive ">
            {{-- @if(!empty($students))
            <div class="alert alert-success">
                @foreach($list as $l)
                <strong>School Year: </strong> {{$year->school_year}}<strong> / Grade:</strong> @if($l->section_grade_lvl == 0)Kinder @else {{$l->section_grade_lvl == 0}}  @endif <strong> / Section:</strong> {{$l->section_name}}
                @endforeach
            </div>
            @endif --}}
            @if (count($students) == 0)
            <div class="alert alert-danger">No students found.</div>
            @else
            <table class="table table-sm table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $c = 1;
                ?>
                @foreach ($students as $student)
                {{-- @if(!empty($search_text))
                <div class="alert alert-success">Results for <strong style="color: red">"{{ $search_text }}"</strong></div>
                @endif --}}
                             <tr>
                                <input type="hidden" class="delete_val" id="delete_val" value="{{$student->id}}">
                                <td>{{$c}}</td>
                                <th>{{ $student->subject_name }}</th>
                                <td> 
                                    <a type="button" href="{{url('view-students/'.$student->sched_id)}}"  class="btn btn-info btn-sm"><span class="btn-label"><i class="fas fa-eye"></i> View Students</span></a>
                                </td>
                            </tr>
                            <?php
                            $c++;
                             ?>
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
