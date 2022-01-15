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
            <h1 class="display-1 ">Fixar Services</h1>

            <!-- Laravel Success Handling -->
            @if(session()->has('success'))
                <p class="fst-italic text-white bg-success p-1 px-2 rounded d-inline-block">{{session()->get('success')}}</p>
            @else
                <p class="lead fst-italic">Best Services One Can Experience !</p>
            @endif
        </div>
        <div class="col-12 shadow rounded p-4">
            <table class="dataTable" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Actions</th>
                    </tr>
                </thead> 
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
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
            "ajax": "{{url()->to('admin/services/data')}}",
            "processing": true,
            "serverSide": true,
            "serverMethod": 'get',
            "columns": [
                { "data": "name" },
                { "data": "slug" },
                { "data": null , "defaultContent" : "<div class=\"btn-group btn-group-sm\" role=\"group\" aria-label=\"Fixar Actions\"><button type=\"button\" class=\"btn btn-danger suspend\">Suspend</button><button type=\"button\" class=\"btn btn-primary update\">Update</button></div>" },
            ],
            "columnDefs": [
                {'targets': [2], 'orderable':false}
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

        $('.dataTable').on('click',".suspend",function () {
            var row = tbl.row( $(this).parents('tr') );

            var rowData = row.data()

            $.ajax({
                url: "{{URL::to('/admin/services/suspend')}}",
                type: "POST",
                data: {"slug": rowData['slug'], "_token": "{{ csrf_token() }}"},
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
                    alert("Error Suspending Service");
                }
            })
        });
        
        $('.dataTable').on('click','.update', function(){
            var row = tbl.row( $(this).parents('tr'));
            var rowData = row.data()
            window.location.href = "{{URL::to('/admin/services/update')}}/"+rowData['slug'];
        });
    })
</script>
@endsection