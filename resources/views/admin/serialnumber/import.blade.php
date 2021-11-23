@extends('layouts.main')
@section('content')

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Upload Serial Numbers</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Upload Serial Numbers</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    @if(session()->get('success'))
      <div class="alert alert-success text-center col-sm-6 ml-2" id="successMessage">
          {{ session()->get('success') }} 
      </div>
    @endif

    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Upload Serial Numbers</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form action="{{ route('import') }}" method="post" enctype="multipart/form-data" class="formdata" id="uploadForm">
             @csrf
              <div class="form-group">
                <div class="col-md-12 mt-4">
                <input type="file" name="file" class="form-control">
                <div class="mt-2 mb-2">
                  @if ($errors->has('file'))
                    <span class="text-danger">{{ $errors->first('file') }}</span>
                  @endif
                </div><br>
                <button class="btn btn-default" id="submitButton"><i class="fas fa-file-import">  Import User Data</i></button>
              </div>
            </div>
            <div class="progress">
              <div class="progress-bar"></div>
            </div>
          </form>
        </div>
    </div>
</section>
</div>
@endsection
