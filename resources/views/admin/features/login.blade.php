<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixar Login</title>
    <link rel="stylesheet" href="{{url()->to('public/bootstrap.min.css')}}">
    <script defer src="{{url()->to('public/bootstrap.bundle.min.js')}}"></script>
    
</head>
<body class="bg-dark bg-gradient">
    <div class="container pt-5" style="height:100vh;">

        <div class="row">

            <div class="col-12 my-5">
                <h1 class="display-1 text-light ">Fixar Login</h1>
                <p class="lead text-info fst-italic">Getting through a day with a smile is surprise ! </p>
            </div>

            <div class="col-12">
                <form action="{{url()->to('admin/login')}}" method="post" class="needs-validation" novalidate>
                    @csrf

                    <!-- Laravel Error Handling -->
                    @if(session()->has('error'))
                        <p class="text-white bg-danger p-1 rounded d-inline-block">{{session()->get('error')}}</p>
                    @endif
                    
                        <div class="form-floating mb-5 position-relative">
                            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" required name="email">
                            <label for="floatingInput">Email address</label>
                            
                            <!-- Bootstrap Error Handling -->
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                            <div class="invalid-tooltip">
                                Please Enter Admin Email !
                            </div>
                            
                        </div>

                        <div class="form-floating mb-5 position-relative">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" required name="password">
                            <label for="floatingPassword">Password</label>
                            
                            <!-- Bootstrap Error Handling -->
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                            <div class="invalid-tooltip">
                                Please Enter Admin Password !
                            </div>
                            
                        </div>
                        <div class="form-floating mb-3">
                            <button type="submit" class="btn btn-secondary">Submit</button>
                        </div>
                </form>

                <!-- Bootstrap Validation Script -->
                <script>
                    // Example starter JavaScript for disabling form submissions if there are invalid fields
                        (function () {
                        'use strict'

                        // Fetch all the forms we want to apply custom Bootstrap validation styles to
                        var forms = document.querySelectorAll('.needs-validation')

                        // Loop over them and prevent submission
                        Array.prototype.slice.call(forms)
                            .forEach(function (form) {
                            form.addEventListener('submit', function (event) {
                                if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                                }

                                form.classList.add('was-validated')
                            }, false)
                            })
                        })()
                </script>
                
            </div>

        </div>

    </div>

    <!-- 
        CHANGE BOOTSTRAP DEFAULT BEHAVIOUR
        1. Changed Blue Color To White -- https://stackoverflow.com/questions/14820952/change-bootstrap-input-focus-blue-glow
    -->
    <style>
        input[type="password"]:focus,
        input[type="email"]:focus {   
            border-color: #6c757d;
            box-shadow: 0 1px 1px #6c757d, 0 0 6px #6c757d;
            outline: 0 none;
        }
    </style>
</body>
</html>