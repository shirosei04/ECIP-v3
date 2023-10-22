<!DOCTYPE html>
<html lang="en">
<head>

    {{-- Styles --}}
    <link href="{{public_path('css/bootstrap.min.css')}}" rel="stylesheet">
    <style>
        body{
            font-family: 'Sans-serif';
        }
  
        th, td {
            padding: 8px;
            text-align: left;
           
        }

        thead{
            background-color: rgb(131, 166, 219);
        }

        .logo{
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            margin-top: -20px;
        }

    </style>
</head>
<body>
    <div class="logo" style="margin: 0"></span>
    <span style="font-size: 40px;  " class="fw-bold"><img style="width: 100px; " class="ms-auto me-auto" src="{{ public_path('img/logo4.png') }}" alt="">
    Educare College Inc.</span>
    <p style="margin: 0 0 3px 0">Irisan, Baguio City</p>
    </div>
    <div style="background-color: blue"></div>
    @foreach ($assessment as $fee)
    <h5 class="mt-1">School Year {{$fee->year->school_year}}</h5>
    @endforeach
    
    {{-- @if(Auth::user()->role != "Principal" )    
        @if(Auth::user()->role == "Teacher" )  
        Teacher Name: {{Auth::user()->last_name . ", " . Auth::user()->first_name . " " . Auth::user()->middle_name . " " . Auth::user()->suffix}}
        @else
        Student Name: {{Auth::user()->last_name . ", " . Auth::user()->first_name . " " . Auth::user()->middle_name . " " . Auth::user()->suffix}}
        <h6>{{$glvl}}</h6>
        <h6>{{$section}}</h6>
        @endif
    @else
        <h6>{{$glvl}}</h6>
        <h6>{{$section}}</h6>
    @endif --}}
    <div style="background-color: blue"></div>

    <div class="card-body" style="margin-top: 15px;">


        <div class="col-md-3">
            <label for="" class="col-md-4 col-form-label fw-bold fs-4">{{ __('Total Due:') }}</label>
            <input type="text" class="form-control fw-bold" value="{{number_format($allFees, 2) }}" disabled>
        </div>
        {{-- <p>Running balance from other semesters/school-years: {{number_format($otherBal, 2) }}</p> --}}
        <table class="table">
            <thead class="table-primary">
                <tr>
                    <th>Transaction Description</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($assessment as $fee)
                    <tr>
                        <td>{{$fee->payment_desc}}</td>
                        <td>{{$fee->payment_date}}</td>
                        <td>{{number_format($fee->payment_amount, 2)}}</td>
                    </tr>
                    @endforeach

                    @foreach ($fee->audits as $audit)      
                    <tr>
                        <td>{{$audit->transaction_description}}</td>
                        <td>{{$audit->transaction_date}}</td>
                        @if($audit->transaction_type == "Deduct")
                        <td>{{"-". number_format($audit->transaction_amount, 2)}}</td>
                        @else
                        <td>{{"+". number_format($audit->transaction_amount, 2)}}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
            
                <div class="col-md-3 pb-3">
                    <label for="" class="col-form-label fw-bold text-start">{{ __('Running Balance:') }}</label>
                    <input type="text" class="form-control" value="{{ number_format($fee->running_balance, 2)}}" disabled>
                </div>

        </table>

    </div>
</body>


</html>

   