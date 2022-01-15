@extends('admin.features.layout')
@section('scripts')
<!-- Charts.js -->
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js" integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
    
@section('content')
<div class="container">
    <div class="row">

        <div class="col-12">
            <h1 class="display-1 ">Fixar Dashboard</h1>
            
            <!-- Laravel Success Handling -->
            @if(session()->has('success'))
                <p class="fst-italic text-white bg-success p-1 px-2 rounded d-inline-block">{{session()->get('success')}}</p>
            @else
                <p class="lead fst-italic">A happy surprise is waiting, work for it !</p>
            @endif

        </div>
    </div>
</div>
@endsection