@extends('layouts.master')
@section('content')
  <div class="container">
    {{-- GRADINGS FOR UPLOADING OF GRADES --}}
    <h3 style="text-align:center;">CHARTS</h3>
    <div style="width: 80%; margin:auto">
      <canvas id="studentChart"></canvas>
    </div>
    
    <h3 style="text-align:center" class="mt-3">UTILITIES</h3>
    <div class="row">
      <div class="col-6">
        <h5>Quick Access</h5>
          <div class="col-8">
         
            <div class="input-group mb-3">
              <span class="input-group-text fw-bold" style="width: 130px">School Year</span>
              @if(!empty($syear))
              <input type="text" value="{{$syear->school_year}}" class="form-control "disabled>
              @else
              <input type="text" value="No Current Year Set" class="form-control "disabled>
              @endif
          
              <a type="button" href="{{ url('school-year') }}" class="btn btn-primary">Manage</a>
            </div>
          </div>

          <div class="col-8">
            <div class="input-group mb-3">
              <span class="input-group-text fw-bold" style="width: 130px">Sections</span>
              @if(!empty($sections))
              <input type="text" value="{{$sections}} sections in total" class="form-control "disabled>
              @else
              <input type="text" value="No Sections Found" class="form-control "disabled>
              @endif
              <a type="button" href="{{ url('sections') }}" class="btn btn-primary">Manage</a>
            </div>
          </div>

          <div class="col-8">
            <div class="input-group mb-3">
              <span class="input-group-text fw-bold" style="width: 130px">Student Fees</span>
              @if(!empty($fees))
              <input type="text" value="{{$fees}} set fees in total" class="form-control "disabled>
              @else
              <input type="text" value="No Fees Found" class="form-control "disabled>
              @endif
              <a type="button" href="{{ url('tuition-fees') }}" class="btn btn-primary">Manage</a>
            </div>
          </div>
      </div>

      <div class="col-6">
        <h5>Grading Terms</h5>
          <div class="table-responsive">
            <table class="table table-sm">
            <thead class="table-primary ">
              <a type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#addGradingModal"><span class="btn-label"><i class="fas fa-plus"></i> Add Grading</span></a>
              @include('modals.add-grading')
                <tr>
                    <th>Grading</th>
                    <th>Status</th>
                    <th>Action</th>
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
                        <td>
                          <a href="{{url('edit-grading/'.$grading->grading_id)}}" data-bs-toggle="modal" data-bs-target="#editGradingModal{{$grading->grading_id}}" class="btn btn-sm btn-warning"> Edit</a>
                        </td>
                        @include('modals.edit-grading')
                    </tr>
              @endforeach
            </tbody>
            </table>
          </div>
      </div>
  </div>
  {{-- CHART --}}


  

  {{-- LOADER --}}
  <div class="loader fs-1 text-white fw-bold"></div>
  </div>
 

@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  //students charts 
  var ctx = document.getElementById('studentChart').getContext('2d');
  var userChart = new Chart(ctx,{
    type:'bar',
    data: {
        labels: {!! json_encode($labels) !!},
        datasets: {!! json_encode($datasets) !!}
    },
  });

  

</script>
 
@endsection