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
                <h1 class="display-2">Update {{$service['name']}}</h1>

                <!-- Laravel Error Handling -->
                @if(session()->has('error'))
                    <p class="fst-italic text-white bg-danger p-1 px-2 rounded d-inline-block">{{session()->get('error')}}</p>
                @else
                    <p class="lead fst-italic">Upgraded Services Are Artwork !</p>
                @endif
            </div>

            <div class="col-12">
                <form action="{{url()->to('admin/services/update')}}" method="post" class="needs-validation" novalidate>
                    @csrf
                    
                        <div class="form-floating mb-5 position-relative">
                            <input type="text" class="form-control" id="floatingName" placeholder="name" required name="name" value="{{$service['name']}}">
                            <label for="floatingName">Name</label>
                            
                            <!-- Bootstrap Error Handling -->
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                            <div class="invalid-tooltip">
                                Please Update Your Service: {{$service['name']}} !
                            </div>
                            
                        </div>
                    
                        <div class="form-floating mb-5 position-relative">
                            <input type="text" class="form-control" id="floatingSlug" placeholder="slug" required name="slug" value="{{$service['slug']}}">
                            <label for="floatingSlug">Slug</label>
                            
                            <!-- Bootstrap Error Handling -->
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                            <div class="invalid-tooltip">
                                Please Update Your Slug: {{$service['slug']}} !
                            </div>
                            
                        </div>

                        <input type="hidden" name="old_slug" value="{{$service['slug']}}">
                    
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