@extends('layouts.main')
@section('content')

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sites Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sites</li>
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
              <h3 class="card-title">Site</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form id="form" action="{{route('sites.store')}}" method="post" enctype="multipart/form-data" class="formdata">
             @csrf
                <input type="hidden" name="id" value="{{ (empty($site)==false)?$site['id']:'' }}"/>
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputName">Site Title</label>
                        <input type="text" id="inputName" class="form-control" name="name" placeholder="Enter Site Name" value="{{ (empty($site)==false)?$site['name']:'' }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                    </div>
                    <input type="hidden" name="uid">
                    <input type="hidden" name="status" value="1">
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info btn-sub"><i class="fa fa-save"></i>&nbsp;&nbsp;{{ ( empty($site)==false)?'Update':'Save'}}</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-default float-right"> 
                          <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
</div>
@endsection