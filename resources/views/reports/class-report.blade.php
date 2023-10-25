<!DOCTYPE html>
<html lang="en">
<head>
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery_3.6.0_jquery.min.js') }}"></script> --}}

    {{-- Font --}}
    {{-- <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet"> --}}

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
 
     </style>
</head>
<body>
    <div class="logo">
        <img src="{{ public_path('img/logo4.png') }}" alt="Educare College Inc. Logo">
        <p class="school-name">Educare College Inc.</p>
        <p class="school-address">Irisan, Baguio City, Philippines, 2600</p>
    </div>
    <b> Class Adviser: </b> {{$adviser->last_name . ", " . $adviser->first_name . " " .$adviser->middle_name . " " . $adviser->suffix}}<br>
    <b> Number of Students: </b> {{count($students)}}<br>
    <div class="card-body" style="margin-top: 15px;">
        <table class="table">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>LRN</th>
                    <th>Full Name</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $c = 1;
                @endphp
                    @foreach ($students as $student)
                    <tr>
                        <td>{{$c }}</td>
                        <td>{{$student->student->lrn}}</td>
                        <td>{{ $student->last_name . ", " . $student->first_name . " " . $student->middle_name . " " . $student->suffix}}</td>
                    </tr>
                    @php
                        $c++;
                    @endphp
                    @endforeach
            </tbody>
        </table>
    </div>
</body>


</html>

   