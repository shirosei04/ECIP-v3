@extends('layouts.master')
@section('title', 'Registry Approval')
@section('content')
<div class="card">
    <div class="loader fs-1 text-white fw-bold">
    </div>
    <div class="card-header tableCardHeader">
        <form action="{{ url('searchNewEnrollee') }}" type="get">
            <div class="col-md-3 float-end">
                <input type="search" class="form-control" placeholder="Search by ID" name="query">
            </div> 
            <div class="float-end">
                <a type="button" href="{{url('/registryApproval')}}"  class="btn btn-primary"><i class="fas fa-sync-alt"></i></a>
            </div>
        </form>
        <h3><i class="fas fa-user-graduate"></i> New Registries</h3>
    </div>

    @if (session('message'))
    <div class="alert alert-success" role="alert">{{ session('message') }}</div>
     @endif

    @if (session('alert'))
    <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
     @endif
     {{-- FILTERING --}}
     <form action="{{url('filter-enrollees')}}" >
        <div class="row p-3" >
                <div class="col-3">
                    <select class="form-select" name="grade_filter">
                        <option value="nofilter" selected>Filter by Grade Level</option>
                        <option value="0" {{ ($gradefilter=="0")? "selected" : "" }}>Kinder</option>
                        <option value="1" {{ ($gradefilter=="1")? "selected" : "" }}>Grade 1</option>
                        <option value="2" {{ ($gradefilter=="2")? "selected" : "" }}>Grade 2</option>
                        <option value="3" {{ ($gradefilter=="3")? "selected" : "" }}>Grade 3</option>
                        <option value="4" {{ ($gradefilter=="4")? "selected" : "" }}>Grade 4</option>
                        <option value="5" {{ ($gradefilter=="5")? "selected" : "" }}>Grade 5</option>
                        <option value="6" {{ ($gradefilter=="6")? "selected" : "" }}>Grade 6</option>
                        <option value="7" {{ ($gradefilter=="7")? "selected" : "" }}>Grade 7</option>
                        <option value="8" {{ ($gradefilter=="8")? "selected" : "" }}>Grade 8</option>
                        <option value="9" {{ ($gradefilter=="9")? "selected" : "" }}>Grade 9</option>
                        <option value="10" {{ ($gradefilter=="10")? "selected" : "" }}>Grade 10</option>
                        <option value="11" {{ ($gradefilter=="11")? "selected" : "" }}>Grade 11</option>
                        <option value="12" {{ ($gradefilter=="12")? "selected" : "" }}>Grade 12</option>
                        <option value="reset">Reset Filter</option>
                    </select>
                </div>
          
                <div class="col-3">
                  <button type="submit"  class="btn btn-success"><i class="fas fa-filter"></i></button>
                </div>
        </div>
    </form>

    <div class="table-responsive">
        @if(count($enrollees) == 0)
        <div class="alert alert-danger">
            No data found. <strong style="color: red">@if(!empty($search_text)) {{"(".$search_text.")"}}  @endif</strong>
        </div>
        @else
        @if (!empty($search_text))
        <div class="alert alert-success">
            Showing search results for <strong style="color: red">{{$search_text}}  </strong>
        </div>
        @endif
        <table class="table table-sm table-hover">
            <thead class="table-primary">
              <tr>
                <th>Date of Registration</th>
                <th>ID</th>
                <th>LRN</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Applying As</th>
                <th>Details</th>
              </tr>
            </thead>
              <tbody>
                    @foreach ($enrollees as $enrollee)
                                <tr>
                                    <input type="hidden" class="delete_val" id="delete_val" value="{{$enrollee->id}}">
                                    <td>{{date('F d, Y', strtotime($enrollee->date_of_registration))}} <em><small>{{now()->diffInDays(($enrollee->date_of_registration ))}} days ago </em></small></td>
                                    <td>{{$enrollee->id}}</td>
                                    @if(!empty($enrollee->student))
                                        <td>{{ $enrollee->student->lrn }}</td>
                                    @else
                                        <td>No LRN retrieved</td>
                                    @endif
                                    <td>{{ $enrollee->last_name }}</td>
                                    <td>{{ $enrollee->first_name }}</td>
                                    @if(!empty($enrollee->student))
                                        @if($enrollee->student->grade_lvl == 0)
                                        <td>Kinder</td>
                                        @else
                                        <td>Grade {{ $enrollee->student->grade_lvl }}</td>
                                        @endif
                                    @else
                                        <td>No Grade Level retrieved</td>
                                    @endif
                                    <td> 
                                        <a href="{{url('/view-details/'.$enrollee->id)}}"  type="button" class="btn btn-info"><span class="btn-label"><i class="far fa-eye"></i></span> View</a>
                                    </td>
                                </tr>
                    @endforeach
                @endif
            </tbody>
          </table>
          <tr>
            @if (count($enrollees) != 0)
            {{ $enrollees->links() }}
            @endif
        </tr>
    </div>
</div>

@endsection

