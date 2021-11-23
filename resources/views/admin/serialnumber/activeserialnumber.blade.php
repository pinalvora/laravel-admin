@extends('layouts.main')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Serial Numbers Validators</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div>

      <div class="card mt-5">
        <div class="card-body">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-body">
                            <div class="row mb-4">
                                <a href="{{ route('checkSerialNumber') }}" style="float: left; font-weight: 900;margin-bottom:10px;" class="btn btn-info btn-sm" type="button">Serial Numbers Validators</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered yajra-datatable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Serial Numbers</th>
                                            <th>Validate Count</th>
                                            <th>Validated On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('pageJS')
<script>
$(document).ready(function(){
    var table = $('.yajra-datatable').DataTable({
        processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 5,
           /* scrollY: 500,
            scrollX: true,*/
            "order": [[ 0, "asc" ]],
            ajax: '{{ route('getserialnumberlist') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'serial_number', name: 'serial_number'},
                {data: 'validate_count', name: 'validate_count'},
                {data: 'validate_on', name: 'validate_on'},
                {data: 'Actions', name: 'Actions',
                orderable:true,
                serachable:true,
                Class:'text-center'
            },
        ]
    });
});
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var deleteID;
        $('body').on('click', '#delete', function(e){
            e.preventDefault();
            deleteID = $(this).data('id');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                var data = {
                    "_method" : 'DELETE',
                    "_token":$('input[name="csrf-token"]').val(),
                    "id":deleteID,
                }
            var url = '{{ route("checkSerialNumber/delete", ":id") }}';
            url = url.replace(':id', deleteID );
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response){
                     swal(response.status, {
                         icon: "success",
                     }).then((result) => {
                         location.reload();
                     });
                }
            });
        }
    });
});
});

</script>
@endsection