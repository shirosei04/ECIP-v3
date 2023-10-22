<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'ECIP- Home')</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery_3.6.0_jquery.min.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js" integrity="sha512-F636MAkMAhtTplahL9F6KmTfxTmYcAcjcCkyu0f0voT3N/6vzAuJ4Num55a0gEJ+hRLHhdz3vDvZpf6kqgEa5w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.css" integrity="sha512-9tISBnhZjiw7MV4a1gbemtB9tmPcoJ7ahj8QWIc0daBCdvlKjEA48oLlo6zALYm3037tPYYulT0YQyJIJJoyMQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}


    {{-- Font --}}
    <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

    {{-- FontAwesome --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

    {{-- SweetAlert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    {{-- Styles --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
    {{-- HEADER --}}
    @if (Route::has('login'))
        @auth
            {{-- User Navbar --}}
            <nav id="myNavbar"class="sb-topnav navbar navbar-expand navbar" >
                <!-- Navbar Brand-->
                <a>
                    <a class="navbar-brand text-white fw-bold ms-3 fs-1">ECIP</a>
                </a>
                
                <!-- Sidebar Toggle-->
                <button class="btn btn-sm order-1 order-lg-0 me-4 me-lg-0 text-white" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
                
                {{-- <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
          
                </form> --}}

                <!-- Navbar-->
                <ul class="navbar-nav ms-auto me-md-0 me-3 me-lg-4">
                    <li class="nav-item dropdown text-white">
                                 <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="nav-link text-white":href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();"><i class="fas fa-sign-out-alt"></i>
                                 </a>
                                </form>
                    </li>
                </ul>
            </nav>
        @endauth
    @endif

    @if (Route::has('login'))
        @auth
            <div id="layoutSidenav">
                <div id="layoutSidenav_nav">
                    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                        <div class="sb-sidenav-menu">
                            <div class="nav">
                                <center>
                                @if(Auth::user()->sex == 'Male')
                                    <div class=" mx-auto d-block ">
                                        <img src="https://cdn2.iconfinder.com/data/icons/ios-7-icons/50/user_male2-512.png" class="img-fluid ms-auto mx-auto mb-0 mt-2 logo-image">
                                    </div>
                                @else
                                <div class=" mx-auto d-block ">
                                    <img src="https://cdn2.iconfinder.com/data/icons/ios-7-icons/50/user_female2-512.png" class="img-fluid ms-auto mx-auto mb-0 mt-2 logo-image">
                                </div>
                                @endif
                                {{-- <span class="text-white ms-3 me-3 fs-4 lh-1 mb-1"><strong class="myName">{{implode(' ', array_slice(explode(' ', Auth::user()->first_name), 0, 2)) . " " .  Auth::user()->last_name }}</strong></span>  --}}
                                <span class="text-white fs-4 lh-1 m-1 justify-content-center"><strong class="myName">{{Auth::user()->first_name . " " . Auth::user()->middle_name . " " . Auth::user()->last_name }}</strong></span> 
                                {{-- @if(Auth::user()->role == 'Student' && (empty(Auth::user()->student->lrn)))
                                    <span class=" ms-3 me-3 text-white fw-light tagline">{{'No data retrieved'}} </span>
                                @else
                                     <span class=" ms-3 me-3 text-white fw-light tagline">Grade {{Auth::user()->student->grade_lvl}} | {{Auth::user()->sex}}</span>
                                    <span class="  ms-3 me-3 text-white fw-light fst-italic tagline">{{Auth::user()->email}} </span>
                                @endif --}}
                                <p class="mb-1 font-sm smlFont text-white">{{Auth::user()->role}} </p>
                                
                                <div class="container align-items-left">
                                    {{-- <input type="hidden" value="{{Auth::user()->id}}" class="delete_id"> --}}
                                    <a class="btn btn-warning btn-sm changePassBtn smlFont" href="{{url('change-password')}}" >Change Password</a>
                                </div>
                                </center>
                                <hr class="hr">
                                <div class="">
                                    <a class="nav-link {{ Request::is('dashboard') ? 'active':'' }}" href="{{ url('dashboard') }}">
                                        <div class="sb-nav-link-icon "><span class="inline-block smlFont"><i class="fas fa-tachometer-alt"></i> Dashboard</span></div>
                                    </a>
                                    <a class="nav-link {{ Request::is('profile') ? 'active':'' }}" href="{{ url('/profile') }}">
                                        <div class="sb-nav-link-icon "><span class="inline-block smlFont"><i class="fas fa-user fa-fw"></i> Profile</span></div>
                                    </a>
                                    {{-- STUDENT & TEACHER --}}
                                    @if(Auth::user()->role == 'Teacher' )
                                    <a class="nav-link {{ Request::is('teacher-schedule') ? 'active':'' }}" href="{{ url('teacher-schedule') }}">
                                        <div class="sb-nav-link-icon"><span class="inline-block smlFont"><i class="far fa-calendar fa-fw"></i>  Schedule</span></div>
                                    </a>
                                    <a class="nav-link {{ Request::is('handled-subjects') ? 'active':'' }}" href="{{ url('handled-subjects') }}">
                                        <div class="sb-nav-link-icon"><span class="inline-block smlFont"><i class="fas fa-file fa-fw"></i> Handled Subjects</span></div>
                                    </a>
                                    <a class="nav-link {{ Request::is('class-list') ? 'active':'' }}" href="{{ url('class-list') }}">
                                        <div class="sb-nav-link-icon "><span class="inline-block smlFont"><i class="fas fa-list fa-fw"></i> Advisory Class</span></div>
                                    </a>
                                    @endif
                                    {{-- STUDENT --}}
                                    @if(Auth::user()->role == 'Student')
                                        <a class="nav-link {{ Request::is('schedule') ? 'active':'' }}" href="{{ url('schedule') }}">
                                            <div class="sb-nav-link-icon"><span class="inline-block smlFont"><i class="far fa-calendar fa-fw"></i> Schedule</span></div>
                                        </a>
                                        <a class="nav-link {{ Request::is('grades') ? 'active':'' }}" href="{{ url('grades') }}">
                                            <div class="sb-nav-link-icon"><span class="inline-block smlFont"><i class="fas fa-file fa-fw"></i> Grades</span></div>
                                        </a>
                                        <a class="nav-link {{ Request::is('enrollment') ? 'active':'' }}" href="{{ url('enrollment') }}">
                                            <div class="sb-nav-link-icon"><span class="inline-block smlFont"><i class="far fa-list-alt fa-fw"></i> Enrollment</span></div>
                                        </a>
                                        <a class="nav-link {{ Request::is('assessment') ? 'active':'' }}" href="{{ url('assessment') }}">
                                            <div class="sb-nav-link-icon"><span class="inline-block smlFont"><i class="fas fa-money-bill fa-fw"></i> Account & Assessment</span></div>
                                        </a>
                                    @endif
                                    {{-- PRINCIPAL --}}
                                    @if(Auth::user()->role == 'Principal')
                                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts">
                                            <div class="sb-nav-link-icon"> <span class="inline-block smlFont"><i class="fas fa-award fa-fw"></i> Awarding</span></div>
                                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                        </a>
                                        <div class="collapse" id="collapseLayouts2" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                            <nav class="sb-sidenav-menu-nested nav">
                                                <a class="nav-link smlFont {{ Request::is('awards') ? 'active':'' }}" href="{{ url('awards') }}">Awards List</a>
                                                <hr class="mt-1 mb-1">
                                                <a class="nav-link smlFont {{ Request::is('awardees') ? 'active':'' }}" href="{{ url('awardees') }}">Awardees</a>
                                            </nav>
                                        </div>
                                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                            <div class="sb-nav-link-icon"> <span class="inline-block smlFont"><i class="fas fa-columns fa-fw"></i> Scheduling</span></div>
                                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                        </a>
                                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                            <nav class="sb-sidenav-menu-nested nav">
                                                <div class="sb-sidenav-menu-heading scrollHead">-MANAGEABLES-</div>
                                                <a class="nav-link smlFont {{ Request::is('school-year') ? 'active':'' }}" href="{{ url('school-year') }}">School Years</a>
                                                <a class="nav-link smlFont {{ Request::is('tuition-fees') ? 'active':'' }}" href="{{ url('tuition-fees') }}"> Fees</a>
                                                <a class="nav-link smlFont {{ Request::is('curriculums') ? 'active':'' }}" href="{{ url('curriculums') }}">Curriculums</a>
                                                <a class="nav-link smlFont {{ Request::is('rooms') ? 'active':'' }}" href="{{ url('rooms') }}">Rooms</a>
                                                <a class="nav-link smlFont {{ Request::is('sections') ? 'active':'' }}" href="{{ url('sections') }}">Sections</a>
                                                <a class="nav-link smlFont {{ Request::is('subjects') ? 'active':'' }}" href="{{ url('subjects') }}">Subjects</a>
                                          
                                                <div class="sb-sidenav-menu-heading mt-0">-MAIN-</div>
                                                <a class="nav-link smlFont {{ Request::is('set-schedule') ? 'active':'' }}" href="{{ url('set-schedules') }}">Set Schedules </a>
                                                <a class="nav-link smlFont {{ Request::is('advisers') ? 'active':'' }}" href="{{ url('advisers') }}">Class Advisers</a>
                                            </nav>
                                        </div>
                                    
            
                                        <a class="nav-link {{ Request::is('grades-approval') ? 'active':'' }}" href="{{ url('grades-approval') }}">
                                            <div class="sb-nav-link-icon"><span class="inline-block smlFont"><i class="fas fa-thumbs-up"></i> Grades Approval</span></div>
                                        </a>
                                        <a class="nav-link {{ Request::is('principal-class-list') ? 'active':'' }}" href="{{ url('principal-class-list') }}">
                                            <div class="sb-nav-link-icon"><span class="inline-block smlFont"><i class="fas fa-list-ol"></i> Class Lists</span></div>
                                        </a>

                                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts3" aria-expanded="false" aria-controls="collapseLayouts">
                                            <div class="sb-nav-link-icon"> <span class="inline-block smlFont"><i class="fas fa-users"></i> Manage Users</span></div>
                                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                        </a>
                                        <div class="collapse" id="collapseLayouts3" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                            <nav class="sb-sidenav-menu-nested nav">
                                                <a class="nav-link smlFont {{ Request::is('ao-list') ? 'active':'' }}" href="{{ url('ao-list') }}">Admission Officers</a>
                                                <a class="nav-link smlFont {{ Request::is('principal-list') ? 'active':'' }}" href="{{ url('principal-list') }}">Principals</a>
                                                <a class="nav-link smlFont {{ Request::is('student-list') ? 'active':'' }}" href="{{ url('student-list') }}">Students</a>
                                                <a class="nav-link smlFont {{ Request::is('teacher-list') ? 'active':'' }}" href="{{ url('teacher-list') }}">Teachers</a>
                                                <hr class="mt-1 mb-1">
                                                <a class="nav-link smlFont {{ Request::is('archived-list') ? 'active':'' }}" href="{{ url('archived-list') }}">Archived Users </a>
                                            </nav>
                                        </div>
                                       
                                    @endif
                                    {{-- ADMISSION OFFICER --}}
                                    @if(Auth::user()->role == 'Admission Officer')
                                        {{-- <a class="nav-link {{ Request::is('registryApproval') ? 'active':'' }}" href="{{ url('registryApproval') }}">
                                            <div class="sb-nav-link-icon"><span class="inline-block smlFont"><i class="far fa-thumbs-up fa-spin fa-fw"></i> Registry Approval</span></div>
                                        </a> --}}
                                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts3" aria-expanded="false" aria-controls="collapseLayouts">
                                            <div class="sb-nav-link-icon"> <span class="inline-block smlFont"><i class="far fa-thumbs-up fa-spin fa-fw"></i> Registry Approval</span></div>
                                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                        </a>
                                        <div class="collapse" id="collapseLayouts3" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                            <nav class="sb-sidenav-menu-nested nav">
                                                <a class="nav-link smlFont {{ Request::is('registryApproval') ? 'active':'' }}" href="{{ url('registryApproval') }}">Registry Applicants</a>
                                                <a class="nav-link smlFont {{ Request::is('archived-users') ? 'active':'' }}" href="{{ url('archived-users') }}">Archived Students </a>
                                            </nav>
                                        </div>
            
                                        <a class="nav-link {{ Request::is('ao-student-list') ? 'active':'' }}" href="{{ url('ao-student-list') }}">
                                            <div class="sb-nav-link-icon"><span class="inline-block smlFont"><i class="fas fa-list fa-fw"></i> Students List</span></div>
                                        </a>

                                        
                                        {{-- <a class="nav-link {{ Request::is('manage-assessment') ? 'active':'' }}" href="{{ url('manage-assessment') }}">
                                            <div class="sb-nav-link-icon"><span class="inline-block smlFont"><i class="fas fa-search-dollar"></i> Manage Assessment</span></div>
                                        </a> --}}
            
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                        <div class="sb-sidenav-footer">
                            <div class="small text-white">Logged in as: <strong>{{strtok(Auth::user()->first_name, ' ')}}</strong></div>
                        </div>
                    </nav>
                </div>
                <div id="layoutSidenav_content" class="blckTest">
                    <main>
                        @yield('content')
                        @yield('scripts')
                    </main>
        
                        <footer class="py-2 mt-auto myFooter" >
                            <div class="container-fluid px-4">
                                <div class="d-flex align-items-center justify-content-between small">
                                    <div class="text-white">Copyright &copy; Educare College Inc. 2023</div>
                                    <div>
                                        <a class="text-white" href="#">Privacy Policy</a>
                                        &middot;
                                        <a class="text-white" href="#">Terms &amp; Conditions</a>
                                        &middot;
                                        <a class="text-white" href="#">About us</a>
                                    </div>
                                </div>
                            </div>
                        </footer>
                </div>
            </div>
        @endauth
    @endif

    {{-- <script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script> --}}
    <script src="{{ asset('js/scripts.js')}}"></script>
    {{-- <script>
    $(document).ready(function(){
        $('.changePassBtn').click(function (e) {
        e.preventDefault();
        // var spinner  = '<div class="loader fs-3 fw-bold">Please wait...</div>';
        var delete_id = $(this).closest("div").find('.delete_val').val();
        // var data = $('#studentDetailForm').serialize()
        alert(delete_id);
    //     swal({
    //     title: "Are you sure?",
    //     text: "Once you submitted, you cannot edit your information anymore?",
    //     icon: "warning",
    //     dangerMode: true,
    //     buttons: true,
    //     })
    //     .then(willDelete => {
    //     if (willDelete) {
    //         // $('.rejectTarget').html(spinner)
    //         $.ajax({
    //             type: "POST",
    //             url: 'addProfileDetail',
    //             data: data,
    //             success: function (response) {
    //                 swal('Student Information Submitted Successfully' , {
    //                     icon: "success",
    //                 }) 
    //                 .then((result) => {
    //                     window.location.href = '/profile';
    //                 });
    //             },
    //             error: function (reject) {
    //                 if(reject.status == 422){
    //                     swal('Some information are wrong. Please re-enter your inputs.' , {
    //                     icon: "error",
    //                     }) 
    //                     .then((result) => {
    //                       window.location.href = '/profile';
    //                     });
    //                 }
    //                 else{
    //                     swal('Something Went Wrong. Please Try Again' , {
    //                     icon: "error",
    //                     }) 
    //                     .then((result) => {
    //                       window.location.href = '/profile';
    //                     });
    //                 }
    //             }
    //         });
    //     }
    });
            
    }); 
    </script> --}}
</body>
</html>
