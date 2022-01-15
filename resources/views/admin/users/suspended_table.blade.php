@extends('admin.features.layout')
@section('styles')
<link rel="stylesheet" href="{{url()->to('public/jquery-datatable-1-11.min.css')}}">
<style>
    /* Grouping Styles */
    tr.group,
    tr.group:hover {
        background-color: #ddd !important;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="row">

        <div class="col-12">
            <h1 class="display-1 ">Fixar Suspended Users</h1>

            <!-- Laravel Success Handling -->
            @if(session()->has('success'))
                <p class="lead fst-italic text-success">{{session()->get('success')}}</p>
            @else
                <p class="lead fst-italic">Performance Benefits the Users !</p>
            @endif
        </div>
        <div class="col-12 shadow rounded p-4">
            <table class="dataTable" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Number</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead> 
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Number</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{url()->to('public/jquery-3-6.min.js')}}"></script>
<script src="{{url()->to('public/jquery-datatable-1-11.min.js')}}"></script>
<script>
    $(document).ready(function () {
        let options = {
            "ajax": "{{url()->to('admin/users/suspended/data')}}",
            "processing": true,
            "serverSide": true,
            "serverMethod": 'get',
            "columns": [
                { "data": "name" },
                { "data": "username" },
                { "data": "email" },
                { "data": "number" },
                { "data": "type" },
                { "data": null , "defaultContent" : "<div class=\"btn-group btn-group-sm\" role=\"group\" aria-label=\"Fixar Actions\"><button type=\"button\" class=\"btn btn-success recover\">Recover</button><button type=\"button\" class=\"btn btn-primary update\">Update</button></div>" },
            ],
            "columnDefs": [
                {'targets': [5], 'orderable':false}
            ],
            "aaSorting": [],
            "paging":   true,
            "info":     true,
            "fixedHeader": true,
            "keys": true,
            "dom": 'Blfrtip',
            "buttons": ['pdf','copy','excel','csv','print'],
            "colReorder": true,
            "pageLength": 10,
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, 'All'] ],
            "scrollX": true,
        };

        var tbl = $('.dataTable').DataTable(options);

        $('.dataTable').on('click',".recover",function () {
            var row = tbl.row( $(this).parents('tr') );

            var rowData = row.data()

            $.ajax({
                url: "{{URL::to('/admin/users/recover')}}",
                type: "POST",
                data: {"username": rowData['username'], "_token": "{{ csrf_token() }}"},
                success: function(res){
                    res = JSON.parse(res);

                    // console.log(res);
                    if (res.success) {
                        row.remove().draw(false);
                    }else{
                        alert(res.error);
                    }
                },
                error: function () {
                    alert("Error Recovering User");
                }
            })
        });
        
        $('.dataTable').on('click','.update', function(){
            var row = tbl.row( $(this).parents('tr'));
            var rowData = row.data()
            window.location.href = "{{URL::to('/admin/users/update')}}/"+rowData['username'];
        });
    })
</script>
@endsection