<!DOCTYPE html>
<html lang="en">
<head>

    {{-- Styles --}}
    <link href="{{public_path('css/bootstrap.min.css')}}" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            /* background-color: #f2f2f2; */
            margin: 0;
        }

        .logo {
            text-align: center;
            margin: 0;

        }

        .logo img {
            width: 100px;
        }

        .school-name {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            color: #4784e8;
        }

        .school-address {
        }

        .header {
            background-color: #4784e8;
            padding: 10px;
            text-align: center;
        }

        h5 {
            text-align: center;
            margin: 10px;
        }

        .user-info {
            text-align: center;
        }

        .user-info h6 {
            font-weight: 600;
            margin: 5px 0;
        }

        .table {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .table th,
        .table td {
            padding: 10px;
        }

        .table th {
            background-color: #4784e8;
            color: #fff;
        }

        .table td {
            background-color: #f9f9f9;
        }

        .m-3 {
            margin: 20px;
            text-align: center;
        }
        .total, .running-bal{
            width: 40%;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ public_path('img/logo4.png') }}" alt="Educare College Inc. Logo">
        <p class="school-name">Educare College Inc.</p>
        <p class="school-address">Irisan, Baguio City, Philippines, 2600</p>
    </div>
    <div style="background-color: rgb(150, 150, 155)"></div>
    <b> Student Name: </b> {{Auth::user()->last_name . ", " . Auth::user()->first_name . " " . Auth::user()->middle_name . " " . Auth::user()->suffix}}<br>
    @foreach ($assessment as $fee)
    <b class="mt-1">School Year: </b>{{$fee->year->school_year}}<br>
    <b class="mt-1">Date Generated: </b>{{now()->toDateString('m-d-Y')}}
    @endforeach
    <div style="background-color: rgb(150, 150, 155)"></div>



    <div class="card-body" style="margin-top: 15px;">
        <div class="total">
            <label for="" class="col-md-4 col-form-label fw-bold fs-4">{{ __('Total Due(All Assessment): ') }}</label>
            <input type="text" class="form-control fw-bold" value="{{number_format($allFees, 2) }}" disabled>
        </div>
        <div class="table">
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
            
           
        </table>
        <div class="running-bal">
            <label for="" class="col-form-label fw-bold text-start">{{ __('Running Balance this semester:') }}</label>
            <input type="text" class="form-control" value="{{ number_format($fee->running_balance, 2)}}" disabled>
        </div>
    </div>

    </div>
</body>


</html>

   