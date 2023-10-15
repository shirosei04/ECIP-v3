@extends('layouts.master')
@section('content')
    <div class="card feeCard">
        <div class="card-header tableCardHeader">
            <h3><i class="fas fa-calendar-alt"></i> All Subject Grades</h3>
        </div>

        @if (session('message'))
        <div class="alert alert-success" role="alert">{{ session('message') }}</div>
        @endif

        @if (session('alert'))
        <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
        @endif
        <div class="row">
            <div class="col">
                <div class="accordion m-3" style="text-align: center " id="accordionExample1">
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="true" aria-controls="collapseOne">
                            <strong> Grading Terms</strong>
                        </button>
                      </h2>
                      <div id="collapse" class="accordion-collapse collapse show" data-bs-parent="#accordionExample1">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                <thead class="table-primary ">
                                    <tr>
                                        <th>Grading</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach ($gradings as $grading)
                                        <tr>
                                            <input type="hidden" class="delete_val" id="delete_val" value="{{$grading->grading_id}}">
                                            <td>{{ $grading->grading }}</td>
                                            <td>
                                              <a href="{{url('grading/'.$grading->grading_id)}}" class="btn btn-sm btn-{{ $grading->status ? 'info' : 'success' }}">
                                                {{$grading->status ? 'Active' : 'Enable'}}
                                              </a>
                                            </td>
                                        </tr>
                                  @endforeach
                                </tbody>
                                </table>
                              </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
           
        </div>
        
       
        <div class="table-responsive ">
            <table class="table table-sm table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Grade Level</th>
                    <th>Teacher</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $c = 1;
                ?>
                 @if(count($subjects) == 0)
                 <div class="alert alert-success">No grades to approve</div>
                 @else
                 @foreach ($subjects as $subject)

                                <tr>
                                    <input type="hidden" class="delete_val" id="delete_val" value="{{$subject->sched_id}}">
                                    <td>{{$c}}</td>
                                    <td>{{ $subject->subject_name }}</td>
                                    <td>{{ $subject->subject_grade_lvl }}</td>
                                    <td>{{ $subject->last_name . ", " . $subject->first_name . " " . $subject->middle_name  . " " . $subject->suffix}}</td>
                                    
                                    <td> 
                                        <a type="button" href="{{url('view-grades/'.$subject->sched_id)}}"  class="btn btn-info btn-sm"><span class="btn-label"><i class="fas fa-eye"></i> View Students</span></a>
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
