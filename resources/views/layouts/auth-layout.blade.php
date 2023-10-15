<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery_3.6.0_jquery.min.js') }}"></script>
    
    <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

    {{-- FontAwesome --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    {{-- SweetAlert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{-- Styles --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

</head>
<body>
    <div class="auth">
        <div class="auth-mask">
            <main>
                @yield('content')
                @yield('scripts')
            </main>
        </div>

    </div>

    <script src="{{ asset('js/scripts.js')}}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>