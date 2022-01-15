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
                <h1 class="display-1 ">Fixar Users</h1>

                <!-- Laravel Error Handling -->
                @if(session()->has('error'))
                    <p class="fst-italic text-white bg-danger p-1 px-2 rounded d-inline-block">{{session()->get('error')}}</p>
                @else
                    <p class="lead fst-italic">Performance Benefits the Users !</p>
                @endif
            </div>

            <div class="col-12">
                <form action="{{url()->to('admin/users/add')}}" method="post" class="needs-validation" novalidate>
                    @csrf
                    
                        <div class="form-floating mb-5 position-relative">
                            <input type="text" class="form-control" id="floatingName" placeholder="name" required name="name">
                            <label for="floatingName">Name</label>
                            
                            <!-- Bootstrap Error Handling -->
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                            <div class="invalid-tooltip">
                                Please Enter Your Name !
                            </div>
                            
                        </div>
                    
                        <div class="form-floating mb-5 position-relative">
                            <input type="text" class="form-control" id="floatingUsername" placeholder="username" required name="username">
                            <label for="floatingUsername">Username</label>
                            
                            <!-- Bootstrap Error Handling -->
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                            <div class="invalid-tooltip">
                                Please Enter Your Username !
                            </div>
                            
                        </div>
                    
                        <div class="form-floating mb-5 position-relative">
                            <input type="email" class="form-control" id="floatingEmail" placeholder="name@example.com" required name="email">
                            <label for="floatingEmail">Email address</label>
                            
                            <!-- Bootstrap Error Handling -->
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                            <div class="invalid-tooltip">
                                Please Enter Your Email !
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
                                Please Enter Your Password !
                            </div>
                            
                        </div>

                        <div class="form-floating mb-5 position-relative">
                            <input type="number" class="form-control" id="floatingNumber" placeholder="+92 03032761851" required name="number">
                            <label for="floatingNumber">Phone Number</label>
                            
                            <!-- Bootstrap Error Handling -->
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                            <div class="invalid-tooltip">
                                Please Enter Your Number !
                            </div>
                            
                        </div>

                        <div class="form-floating mb-5 position-relative">
                            <select required class="form-select" id="floatingSelect" aria-label="Floating label select Fixar" name="type">
                                <option selected value="Customer">Customer</option>
                                <option value="Provider">Provider</option>
                            </select>
                            <label for="floatingSelect">Type</label>
                            
                            <!-- Bootstrap Error Handling -->
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                            <div class="invalid-tooltip">
                                Please Select A Type !
                            </div>
                            
                        </div>

                        <!-- COLLAPSABLE AREA -->
                        <div class="collapse mb-5" id="collapseServices">
                            <div class="card card-body">
                                <h3 class="display-6">Please Select Provider Services</h3>
                                @if(count($services) !== 0)
                                <div class="row row-cols-auto" id="checkboxes">
                                @foreach($services as $each)
                                    <div class="col">
                                        <input type="checkbox" fixar="fixar" class="btn-check" id="{{$each['slug']}}" autocomplete="off" value="{{$each['slug']}}">
                                        <label class="btn btn-outline-primary" for="{{$each['slug']}}">{{$each['name']}}</label>
                                    </div>
                                @endforeach
                                </div>
                                <input type="hidden" name="services">
                                @else No Services 
                                @endif
                            </div>
                        </div>
                        <script>
                            /*
                            let services = document.querySelector('input[name="services"]');
                            let inserted = [];
                            document.querySelectorAll('input[fixar="fixar"]').forEach(e => {
                                e.addEventListener('click', ()=> {
                                    if(e.checked){
                                        inserted.push(e.value);
                                        services.value = inserted;
                                    } else {
                                        inserted.pop(e.value)
                                        services.value = inserted;
                                    }
                                })
                            })*/
                            

                        </script>
                        
                        
                        
                        <div class="form-floating">
                            <button type="submit" class="btn btn-secondary">Submit</button>
                        </div>

                        <button style="visibility: hidden;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseServices" aria-expanded="false" aria-controls="collapseServices"></button>
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


    /* Script For Selector Toggler */
    document.querySelector('#floatingSelect').addEventListener('change', (e)=> {
        if(e.selectedIndex === 1) {
            document.querySelector('button[data-bs-target="#collapseServices"]').click()
        } else if (e.selectedIndex !== 1) {
            document.querySelector('button[data-bs-target="#collapseServices"]').click()
        }
    })
</script>
@endsection