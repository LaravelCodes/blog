<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixar</title>
    <link rel="stylesheet" href="{{url()->to('public/bootstrap.min.css')}}">
    @yield('styles')
</head>
<body class="bg-light bg-gradient">

<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow ">
  <div class="container">
    <a class="navbar-brand" href="{{url()->to('/admin/dashboard')}}">Fixar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#FixarNavbar" aria-controls="FixarNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="FixarNavbar">
        <ul class="navbar-nav me-auto">
            <li class="nav-item me-2">
                <button id="user_nav" class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFixar" aria-controls="offcanvasFixar">
                    Users
                </button>
            </li>
            <li class="nav-item me-2">
                <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFixar" aria-controls="offcanvasFixar">Services</button>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item ">
                <a class="btn btn-outline-light" href="{{url()->to('admin/logout')}}">Log Out</a>
            </li>
        </ul>
    </div>
  </div>
</nav>
    
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasFixar" aria-labelledby="offcanvasFixarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasFixarLabel">Fixar Dashboard</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        
        <!-- USER ACCORDIAN -->
        <div class="accordion mb-3" id="accordionFixarUser">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingUser">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser" >
                    <span class="d-flex align-items-center">
                        <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-video2" viewBox="0 0 16 16">
                            <path d="M10 9.05a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                            <path d="M2 1a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2ZM1 3a1 1 0 0 1 1-1h2v2H1V3Zm4 10V2h9a1 1 0 0 1 1 1v9c0 .285-.12.543-.31.725C14.15 11.494 12.822 10 10 10c-3.037 0-4.345 1.73-4.798 3H5Zm-4-2h3v2H2a1 1 0 0 1-1-1v-1Zm3-1H1V8h3v2Zm0-3H1V5h3v2Z"/>
                        </svg>
                        &nbsp;
                        All Users Functions
                    </span>
                </button>
                </h2>
                <div id="collapseUser" class="accordion-collapse collapse" aria-labelledby="headingUser" data-bs-parent="#accordionFixarUser">
                    <div class="accordion-body">

                    <!-- User Functions  -->
                        
                    <a href="{{url()->to('/admin/users/add')}}" class="text-decoration-none d-block mb-1">
                            <div class="d-grid">
                                <button class="btn btn-outline-secondary d-flex justify-content-center align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-rolodex" viewBox="0 0 16 16">
                                        <path d="M8 9.05a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                                        <path d="M1 1a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h.5a.5.5 0 0 0 .5-.5.5.5 0 0 1 1 0 .5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5.5.5 0 0 1 1 0 .5.5 0 0 0 .5.5h.5a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H6.707L6 1.293A1 1 0 0 0 5.293 1H1Zm0 1h4.293L6 2.707A1 1 0 0 0 6.707 3H15v10h-.085a1.5 1.5 0 0 0-2.4-.63C11.885 11.223 10.554 10 8 10c-2.555 0-3.886 1.224-4.514 2.37a1.5 1.5 0 0 0-2.4.63H1V2Z"/>
                                    </svg>
                                    &nbsp;
                                    Add A User
                                </button>
                            </div>
                        </a>

                        <a href="{{url()->to('/admin/users/suspended/table')}}" class="text-decoration-none d-block mb-1">
                            <div class="d-grid">
                                <button class="btn btn-outline-danger d-flex justify-content-center align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-badge-fill" viewBox="0 0 16 16">
                                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-.245z"/>
                                    </svg>
                                    &nbsp;
                                    Suspended Users Table
                                </button>
                            </div>
                        </a>

                        <a href="{{url()->to('/admin/users/table')}}" class="text-decoration-none d-block mb-1">
                            <div class="d-grid">
                                <button class="btn btn-outline-success d-flex justify-content-center align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                    </svg>
                                    &nbsp;
                                    Users Table
                                </button>
                            </div>
                        </a>
                        

                    </div>
                </div>
            </div>
        </div>

        <!-- Services Accordian -->
        <div class="accordion" id="accordionFixarServices">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingServices">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseServices" aria-expanded="false" aria-controls="collapseServices">
                    <span class="d-flex align-items-center">
                        <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16">
                            <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.356 3.356a1 1 0 0 0 1.414 0l1.586-1.586a1 1 0 0 0 0-1.414l-3.356-3.356a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0zm9.646 10.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708zM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11z"/>
                        </svg>
                        &nbsp;
                        All Services Functions
                    </span>
                </button>
                </h2>
                <div id="collapseServices" class="accordion-collapse collapse" aria-labelledby="headingServices" data-bs-parent="#accordionFixarServices">
                    <div class="accordion-body">

                    <!-- Services Functions  -->

                        <a href="{{url()->to('/admin/services/add')}}" class="text-decoration-none d-block mb-1">
                            <div class="d-grid">
                                <button class="btn btn-outline-secondary d-flex justify-content-center align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-nut-fill" viewBox="0 0 16 16">
                                        <path d="M4.58 1a1 1 0 0 0-.868.504l-3.428 6a1 1 0 0 0 0 .992l3.428 6A1 1 0 0 0 4.58 15h6.84a1 1 0 0 0 .868-.504l3.429-6a1 1 0 0 0 0-.992l-3.429-6A1 1 0 0 0 11.42 1H4.58zm5.018 9.696a3 3 0 1 1-3-5.196 3 3 0 0 1 3 5.196z"/>
                                    </svg>
                                    &nbsp;
                                    Add A Service
                                </button>
                            </div>
                        </a>
                    
                        <a href="{{url()->to('/admin/services/suspended/table')}}" class="text-decoration-none d-block mb-1">
                            <div class="d-grid">
                                <button class="btn btn-outline-danger d-flex justify-content-center align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hammer" viewBox="0 0 16 16">
                                        <path d="M9.972 2.508a.5.5 0 0 0-.16-.556l-.178-.129a5.009 5.009 0 0 0-2.076-.783C6.215.862 4.504 1.229 2.84 3.133H1.786a.5.5 0 0 0-.354.147L.146 4.567a.5.5 0 0 0 0 .706l2.571 2.579a.5.5 0 0 0 .708 0l1.286-1.29a.5.5 0 0 0 .146-.353V5.57l8.387 8.873A.5.5 0 0 0 14 14.5l1.5-1.5a.5.5 0 0 0 .017-.689l-9.129-8.63c.747-.456 1.772-.839 3.112-.839a.5.5 0 0 0 .472-.334z"/>
                                    </svg>
                                    &nbsp;
                                    Suspended Services Table
                                </button>
                            </div>
                        </a>

                        <a href="{{url()->to('/admin/services/table')}}" class="text-decoration-none d-block mb-1">
                            <div class="d-grid">
                                <button class="btn btn-outline-success d-flex justify-content-center align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                        <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                    </svg>
                                    &nbsp;
                                    Services Table
                                </button>
                            </div>
                        </a>
                        
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
    @yield('content')
    <script defer src="{{url()->to('public/bootstrap.bundle.min.js')}}"></script>
    @yield('scripts')
</body>
</html>