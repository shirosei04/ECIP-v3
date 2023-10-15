@extends('layouts.master')
@section('title', 'Archived Users')
@section('content')
<div class="card">
    <div class="loader fs-1 text-white fw-bold">
      
    </div>
    <div class="card-header tableCardHeader">
        <form action="{{ url('searcharchived') }}" type="get">
            <div class="col-md-3 float-end">
                <input type="search" class="form-control" placeholder="Search Student" name="query">
            </div> 
        </form>
        <h3><i class="fas fa-user-graduate"></i> Archived Users</h3>
    </div>

    @if (session('message'))
    <div class="alert alert-success" role="alert">{{ session('message') }}</div>
     @endif
     @if (session('alert'))
     <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
      @endif
     {{-- FILTERING --}}
     
     
     <form action="{{url('principal-filter-archived')}}" >
        <label for="" class="cold-form-label ms-3 text-start fw-bold">{{ __('Students') }}</label>
        <div class="row ms-2" >
                <div class="col-3">
                 
                    <select class="form-select" name="grade_filter">
         
                        <option value="nofilter" selected>Filter by Grade Level</option>
                        <option value="0">Kinder</option>
                        <option value="1">Grade 1</option>
                        <option value="2">Grade 2</option>
                        <option value="3">Grade 3</option>
                        <option value="4">Grade 4</option>
                        <option value="5">Grade 5</option>
                        <option value="6">Grade 6</option>
                        <option value="7">Grade 7</option>
                        <option value="8">Grade 8</option>
                        <option value="9">Grade 9</option>
                        <option value="10">Grade 10</option>
                        <option value="11">Grade 11</option>
                        <option value="12">Grade 12</option>
                        <option value="reset">Reset Filter</option>
                    
                    </select>
                </div>
          
                <div class="col-3">
                  <button type="submit"  class="btn btn-success"><i class="fas fa-filter"></i></button>
                </div>
        </div>
    </form>

    <form action="{{url('archived-filter-role')}}" >
        <label for="" class="cold-form-label ms-3  pt-3  text-start fw-bold">{{ __('Faculty Members') }}</label>
        <div class="row ms-2 pb-3" >
                <div class="col-3">
                    <select class="form-select" name="filter_role">
                        <option value="nofilter" selected>Filter by Role</option>
                        <option value="Teacher">Teacher</option>
                        <option value="Principal">Principal</option>
                        <option value="Admission Officer">Admission Officer</option>
                        <option value="reset">Reset Filter</option>
                    </select>
                </div>
          
                <div class="col-3">
                  <button type="submit"  class="btn btn-success"><i class="fas fa-filter"></i></button>
                </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead class="table-primary">
              <tr>
                <th>Date of Registration</th>
                <th>LRN</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Applying As</th>
                <th>Details</th>
              </tr>
            </thead>
              <tbody>
                @if (count($users) == 0)
                {{-- <tr> --}}
                    <div class="alert alert-danger">No archived users found.</div>
                    {{-- @if($gradefilter == 0)
                    <div class="alert alert-danger">
                        No archived users for<strong style="color: red"> Kinder</strong>
                    </div>
                    @elseif($gradefilter == "nofilter")
                    <div class="alert alert-danger">
                       No archived users
                    </div>
                    @elseif($gradefilter == "Teacher")
                    <div class="alert alert-danger">
                       No archived users for <strong style="color: red">Teacher</strong>
                    </div>
                    @elseif($gradefilter == "Principal")
                    <div class="alert alert-danger">
                       No archived users for <strong style="color: red">Principal</strong>
                    </div>
                    @elseif($gradefilter == "Admission Officer")
                    <div class="alert alert-danger">
                       No archived users for <strong style="color: red">Admission Officer</strong>
                    </div>
                    @else
                    <div class="alert alert-danger">
                        No archived users for  <strong style="color: red">Grade {{$gradefilter}}</strong>
                     </div>

                    </tr>
                    @endif --}}
                @else
                {{-- <tr> --}}
                    {{-- @if($gradefilter == 0)
                    <div class="alert alert-success">
                        <strong style="color: red">Current Filter: Kinder</strong>
                    </div>
                    @elseif($gradefilter == "nofilter")
                    <div class="alert alert-success">
                        Showing <strong style="color: red">All</strong> archived users
                    </div>
                    @elseif($gradefilter == "Teacher")
                    <div class="alert alert-success">
                      Showing archived users for <strong style="color: red">Teacher</strong>
                    </div>
                    @elseif($gradefilter == "Principal")
                    <div class="alert alert-success">
                      Showing archived users for<strong style="color: red">Principal</strong>
                    </div>
                    @elseif($gradefilter == "Admission Officer")
                    <div class="alert alert-success">
                      Showing archived users for <strong style="color: red">Admission Officer</strong>
                    </div>
                    @else
                    <div class="alert alert-success">
                        Current Filter:  <strong style="color: red">Grade {{$gradefilter}}</strong>
                     </div>

                    </tr>
                    @endif --}}
                    @foreach ($users as $user)
                    @if(!empty($search_text))
                    <div class="alert alert-success">Results for <strong style="color: red">"{{ $search_text }}"</strong></div>
                    @endif
                                <tr>
                                    <input type="hidden" class="delete_val" id="delete_val" value="{{$user->id}}">
                                    <td>{{date('F d, Y', strtotime($user->date_of_registration))}} <em><small>{{now()->diffInDays(($user->date_of_registration ))}} days ago </em></small></td>
                                    @if(!empty($user->student))
                                        <td>{{ $user->student->lrn }}</td>
                                    @else
                                        <td>No LRN retrieved</td>
                                    @endif
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    @if(!empty($user->student))
                                        <td>Grade {{ $user->student->grade_lvl }}</td>
                                    @else
                                        <td>No Grade Level retrieved</td>
                                    @endif
                                    <td> 
                                    <a href="{{url('/view-archived/'.$user->id)}}"  type="button" class="btn btn-info"><span class="btn-label"><i class="far fa-eye"></i></span> View</a>
                                    </td>
                                </tr>
                    @endforeach
                @endif
            </tbody>
          </table>
    </div>
</div>
@endsection
