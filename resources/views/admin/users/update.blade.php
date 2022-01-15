@extends('admin.features.layout')
@section('styles')
<style>
    /* CHANGE BOOTSTRAP DEFAULT BEHAVIOUR
    1. Changed Blue Color To White -- https://stackoverflow.com/questions/14820952/change-bootstrap-input-focus-blue-glow */
    input[type="password"]:focus,
    input[type="email"]:focus {   
        border-color: #6c757d;
        box-shadow: 0 1px 1px #6c757d, 0 0 6px #6c757d;
        outline: 0 none;
    }

    /* Remove Arrows From Input['number'] 
    https://www.w3schools.com/howto/howto_css_hide_arrow_number.asp */
    /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endsection
@section('content')
    <div class="container">

        <div class="row">
                
            <div class="col-12">
                <h1 class="display-2">Update {{$user['name']}}</h1>

                <!-- Laravel Error Handling -->
                @if(session()->has('error'))
                    <p class="lead fst-italic text-danger">{{session()->get('error')}}</p>
                @else
                    <p class="lead fst-italic">Information is blinded with Data !</p>
                @endif
            </div>

            <div class="col-12">
                <form action="{{url()->to('admin/users/update')}}" method="post" class="needs-validation" novalidate>
                    @csrf
                    
                        <div class="form-floating mb-5 position-relative">
                            <input type="text" class="form-control" id="floatingName" placeholder="name" required name="name" value="{{$user['name']}}">
                            <label for="floatingName">Name</label>
                            
                            <!-- Bootstrap Error Handling -->
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                            <div class="invalid-tooltip">
                                Please Update {{$user['name']}}'s Name !
                            </div>
                            
                        </div>
                    
                        <div class="form-floating mb-5 position-relative">
                            <input type="email" class="form-control" id="floatingEmail" placeholder="name@example.com" required name="email" value="{{$user['email']}}">
                            <label for="floatingEmail">Email address</label>
                            
                            <!-- Bootstrap Error Handling -->
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                            <div class="invalid-tooltip">
                                Please Enter {{$user['name']}}'s Email !
                            </div>
                            
                        </div>

                        <div class="form-floating mb-5 position-relative">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="new_password">
                            <label for="floatingPassword">New Password</label>
                            
                            <!-- Bootstrap Error Handling -->
                            <div class="valid-tooltip">
                                As You Choose !
                            </div>
                            <!-- <div class="invalid-tooltip">
                                Please Enter Password !
                            </div> -->
                            
                        </div>

                        <div class="form-floating mb-5 position-relative">
                            <input type="number" class="form-control" id="floatingNumber" placeholder="+92 03032761851" required name="number" max="999999999" value="{{$user['number']}}">
                            <label for="floatingNumber">Phone Number</label>
                            
                            <!-- Bootstrap Error Handling -->
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                            <div class="invalid-tooltip">
                                Please Enter {{$user['name']}}'s Number / It Must be 9 digits 
                            </div>
                            
                        </div>

                        <div class="form-floating mb-5 position-relative">
                            <select required class="form-select" id="floatingSelect" aria-label="Floating label select Fixar" name="type">
                                <option {{$user['type'] === 'Customer' ? 'selected' : ''}} value="Customer">Customer</option>
                                <option {{$user['type'] === 'Provider' ? 'selected' : ''}} value="Provider">Provider</option>
                            </select>
                            <label for="floatingSelect">Type</label>
                            
                            <!-- Bootstrap Error Handling -->
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                            <div class="invalid-tooltip">
                                Please Select {{$user['name']}}'s Type !
                            </div>
                            
                        </div>
                        
                        <input type="hidden" name="username" value="{{$user['username']}}">
                        
                        <div class="form-floating mb-3">
                            <button type="submit" class="btn btn-secondary">Submit</button>
                        </div>
                </form>
            </div>

        </div>

    </div>
@endsection
@section('scripts')
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
@endsection