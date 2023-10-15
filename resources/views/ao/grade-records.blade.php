@extends('layouts.master')
@section('title', 'Grades Records')
@section('content')
{{-- <div class="container-fluid"> --}}
    <div class="card spinnerTarget">
        <div class="card-header tableCardHeader">
            <form action="{{ url('aosearchstudent') }}" type="get">
                <div class="col-md-3 float-end">
                    <input type="search" class="form-control" placeholder="Search Lastname" name="query">
                </div> 
                <div class="float-end">
                    <a type="button" href="{{url('/ao-student-list')}}"  class="btn btn-primary"><i class="fas fa-sync-alt"></i></a>
                </div>
            </form>
            <h3><i class="fas fa-user-graduate"></i> Students</h3>
        </div>
        {{-- <div class="p-2" >
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newUserModal">Add New User</button>
        </div> --}}
        {{-- <div class="card-body"> --}}
            @if (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
             @endif
             @if (session('alert'))
             <div class="alert alert-danger" role="alert">{{ session('alert') }}</div>
              @endif
              <div>
                
              </div>
             <form action="{{url('ao-filter-students')}}" >
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
                <table class="table table-sm table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>LRN</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Grade Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($users) == 0)
                        <div class="alert alert-danger">No students found.</div>
                    @else
                    @foreach ($users as $user)
                    @if(!empty($search_text))
                    <div class="alert alert-success">Results for <strong style="color: red">"{{ $search_text }}"</strong></div>
                    @endif
                                <tr>
                                    <input type="hidden" class="delete_val" id="delete_val" value="{{$user->id}}">
                                    <td>{{ $user->student->lrn }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->student->grade_lvl }}</td>
                                    <td> 
                                        <a type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewUserModal{{$user->id}}"><span class="btn-label"><i class="fas fa-eye"></i> View Details</span></a>
                                        <a type="button" href="{{url('/view-assessment/'.$user->id)}}"  class="btn btn-success btn-sm" ><span class="btn-label"><i class="fas fa-eye"></i> View Grades</span></a>

                                    </td>

                           
                                </tr>

                        @endforeach
                    @endif
                    </tbody>
              
                </table>
            </div>
        {{-- </div> --}}
        
    </div>
{{-- </div> --}}

@endsection
@section('scripts')
<script>
    $(document).ready(function () {
    
    // edit USER
    // $('.editBtn').click(function (e) {
    //         e.preventDefault();
    //         var delete_id = $(this).closest("div").find('.delete_val').val();
    //         var data = $('#editUserForm').serialize();
    //         alert(data);
    //         // alert(delete_id);
    //             swal({
    //             title: "Are you sure?",
    //             text: "This specific user details will be changed",
    //             icon: "warning",
    //             buttons: true,
    //             dangerMode: true,
    //             })
    //             .then((willEdit) => {
    //                 if (willEdit) {
    //                     $.ajax({
    //                         type: "PUT",
    //                         url: 'edit-user',
    //                         data: data,
    //                         success: function (response) {
    //                             swal('User Edited Successfully' , {
    //                                 icon: "success",
    //                             }) 
    //                             .then((result) => {
    //                                 window.location.href = '/student-list';
    //                             });
    //                         }
    //                     });
    //                 } else {
    //                     swal("No Changes Made :)");
    //                 }
    //         });
    //     });
        // $('.manageBtn').click(function (e) {
        //     e.preventDefault();
        //     // var spinner  = '<div class="loader fs-3 fw-bold">Please wait...</div>';
        //     var delete_id = $(this).closest("tr").find('.delete_val').val();
        //     // alert(delete_id);
        //     //  
        //         $.ajax({
        //             type: "GET",
        //             url: 'manage-assessment/'+delete_id,
        //             data: delete_id,
        //         });
        //     //        
        //     // });
        // });

        

     });
</script>
@endsection