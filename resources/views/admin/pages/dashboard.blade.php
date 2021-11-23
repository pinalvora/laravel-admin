@extends('layouts.main')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
          <div class="col-sm-6">
              <a href="{{ route('sites.create') }}" class="float-right btn btn-sm btn-outline-secondary btn-sm" type="button">Add New Site</a>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          @foreach($site as $v)
            <div class="col-lg-3 col-6 divdata" id="checksite">
              <div class="small-box bg-info" id="divcolor">
                <div class="inner">
                  <div class="float-right">
                    <a href="{{route('sites.edit',$v->id) }}" class="text-white"><i class='fas fa-edit mr-1'></i></a>
                    <a href='' data-id='{{$v->id}}' data-method='delete' id='delete' class="text-white"><i class='fas fa-trash-alt'></i></a>
                  </div>
                  <h3>150</h3>
                  <div id="selectsite">
                    <input type="hidden" value="{{$v->id}}" class="site_id">
                    <a href="" class="text-white"><p>{{$v->name}}</p></a>
                  </div>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer" >More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  </div>
@endsection
@section('pageJS')
<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000
    });
  $(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var Check_site_id;
      $('body').on('click', '#selectsite', function(e){
        e.preventDefault();
        Check_site_id = $(this).find(".site_id").val();
      
        var data = {
                "id":Check_site_id,
            }
            $.ajax({
                url: '{{ route('dashboard/list') }}',
                type: 'GET',
                data: data,
                success: function(route){
                  var url = route.route;
                    Toast.fire({
                        icon: 'success',
                        title: 'Selected Site SuccessFully!'
                    })
                    setTimeout( function(){ 
                       window.location.href = SITE_URL+url;
                    },2000);
                },
            });
        });
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
            var url = '{{ route("sites.destroy", ":id") }}';
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
/*$(document).ready(function(){
  setInterval(function(){
        $('#divcolor').animate({backgroundColor: 'blue'},300)
                    .animate({backgroundColor: 'yellow'},300)
                    .animate({backgroundColor: 'white'},300)
                    .animate({backgroundColor: 'black'},300);
  },1000);
});*/

</script>
@endsection
