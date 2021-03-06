@extends('layouts.main')
@section('content')

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Check Serial Number</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Check Serial Number</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Check Serial Number</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form id="form" action="{{route('checkSerialNumber/save')}}" method="post" enctype="multipart/form-data" class="formdata">
             @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputName">Serial Number</label>
                        <input type="text" class="form-control" name="serial_number" placeholder="Enter Serial Number">
                            @if ($errors->has('serial_number'))
                                <span class="text-danger">{{ $errors->first('serial_number') }}</span>
                            @endif
                    </div>
                   
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info btn-sub"><i class="fa fa-save"></i>&nbsp;&nbsp; Save</button>
                        <a href="{{ route('activeSerialNumber') }}" class="btn btn-default float-right">   <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
</div>
@endsection