@extends('layouts.main')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Files</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div>
@if(session()->get('success'))
    <div class="alert alert-success text-center" id="successMessage">
        {{ session()->get('success') }} 
    </div>
@endif

      <div class="card mt-5">
        <div class="card-body">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-body">
                            <div class="row mb-4">
                                <a href="{{ route('files.create') }}" style="float: left; font-weight: 900;margin-bottom:10px;" class="btn btn-info btn-sm" type="button">Add New File</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered yajra-datatable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>File</th>
                                            <th>DateTime</th>
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
            // scrollX: true,
            "order": [[ 0, "desc" ]],
            ajax: '{{ route('getfilelist') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'date_time', name: 'date_time'},
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
            var url = '{{ route("files.destroy", ":id") }}';
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