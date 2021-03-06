@extends('layouts.main')
@section('content')

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Serial Number Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit</li>
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
              <h3 class="card-title">Serial Number</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form id="form" action="{{route('getserialnumbers/update')}}" method="post" enctype="multipart/form-data" class="formdata">
             @csrf
                <input type="hidden" name="id" value="{{ (empty($serial_no)==false)?$serial_no['id']:'' }}"/>
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputName">Serial No.</label>
                        <input type="text" class="form-control" name="serial_number" value="{{ $serial_no->serial_number }}">
                            @if ($errors->has('serial_number'))
                                <span class="text-danger">{{ $errors->first('serial_number') }}</span>
                            @endif
                    </div>
                    <input type="hidden" name="status" value="1">
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info btn-sub"><i class="fa fa-save"></i>&nbsp;&nbsp;{{ 'Update' }}</button>
                        <a href="{{ route('getserialnumbers') }}" class="btn btn-default float-right"> 
                          <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
</div>
@endsection