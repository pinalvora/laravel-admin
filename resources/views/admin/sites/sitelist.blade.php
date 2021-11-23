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
                <div class="col-md-6">
                <div class="form-group">
                    <label>Site List</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="9" tabindex="-1" aria-hidden="true" name="site">
                      <option>Please Select Site</option>
                        @foreach($site as $data)
                            <option value="{{ $data->id }}">{{ $data->title }}</option>
                        @endforeach
                  </select>
                  @if ($errors->has('site'))
                    <span class="text-danger">{{ $errors->first('site') }}</span>
                    @endif
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-info btn-sub"><i class="fa fa-save"></i>&nbsp;&nbsp; Save</button>
                        <a href="{{ route('sites.index') }}" class="btn btn-default float-right"> 
                          <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
              </div>
                </div>
            </form>
        </div>
    </div>
</section>
</div>
@endsection