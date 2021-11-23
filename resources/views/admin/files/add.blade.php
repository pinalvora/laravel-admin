@extends('layouts.main')
@section('content')

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Files Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Files</li>
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
              <h3 class="card-title">Files</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form id="form" action="{{route('files.store')}}" method="post" enctype="multipart/form-data" class="formdata">
             @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="form-group">
                        <label for="inputName">Site Title</label>
                        <input type="file" name="file" class="form-control">
                        <div class="mt-2 mb-2">
                          @if ($errors->has('file'))
                            <span class="text-danger">{{ $errors->first('file') }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info btn-sub"><i class="fa fa-save"></i>&nbsp;&nbsp;{{ ( empty($fileupload)==false)?'Update':'Save'}}</button>
                        <a href="{{ route('files.index') }}" class="btn btn-default float-right"> 
                          <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
</div>
@endsection