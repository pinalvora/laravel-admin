@extends('layouts.main')
@section('content')

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Serial Number</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">View</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Serial Number</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form id="form" action="" method="post" enctype="multipart/form-data" class="formdata">
             @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                          <label for="inputName">Serial Number</label>
                          <input type="text" id="inputName" class="form-control sr_no" name="serial_number" placeholder="Enter Serial Number" value="{{ $serial_numbers->serial_number }}" readonly="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                          <label for="inputName">Validate Count</label>
                          <input type="text" id="inputName" class="form-control" name="validate_count" placeholder="Enter Validate Count" value="{{ $serial_numbers->validate_count }}" readonly="">
                      </div>
                    </div>
                  </div>
                </div>
            </form>
        </div>
    </div>
  </div>
  <div class="card mt-12">
        <div class="card-body">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-body">
                            <div class="row mb-4">
                                <a href="{{ route('activeSerialNumber') }}" style="float: left; font-weight: 900;margin-bottom:10px;" class="btn btn-info btn-sm" type="button">Back</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered yajra-datatable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Serial Numbers.</th>
                                            <th>Validated On</th>
                                            <th>IP Address</th>
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
</section>
</div>
</div>
@endsection
@section('pageJS')
<script>
$(document).ready(function() {
    Serial_no = $(this).find('.sr_no').val();
        var table = $('.yajra-datatable').DataTable({
                serverSide: true,
                autoWidth: false,
                serachable:true,
                pageLength: 10,
                orderable:true,
                "order": [[ 0, "asc" ]],
                "ajax": {
                    "url": SITE_URL+"getLogData?sr_no="+Serial_no
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'serial_number', name: 'serial_number'},
                    {data: 'validate_on', name: 'validate_on'},
                    {data: 'ip_address', name: 'ip_address'},
            ]
        });
});
</script>
@endsection