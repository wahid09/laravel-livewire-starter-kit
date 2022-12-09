<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Starter</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/toastr/toastr.min.css') }}">
  <livewire:styles />
  @stack('css')

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  @include('backend.layouts.partials.header')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('backend.layouts.partials.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    {{ $slot }}
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  @include('backend.layouts.partials.rightsidebar')
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
<script>
    $(document).ready(function(){
        toastr.options = {
        "progressBar": true,
        "positionClass": "toast-bottom-right"
        }
        window.addEventListener('toastr-success', event =>{
        toastr.success(event.detail.message, 'Success');
        });
        window.addEventListener('toastr-info', event =>{
        toastr.info(event.detail.message, 'Info');
        });
        window.addEventListener('toastr-error', event =>{
            toastr.error(event.detail.message, 'Error');
        });
    });
    window.addEventListener('show-form', event =>{
        $('#form').modal('show');
    });
    window.addEventListener('hide-form', event =>{
        $('#form').modal('hide');
    });
    
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    window.addEventListener('delete-confirm', event=>{
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
            window.livewire.emit('delete', event.detail.id);
            Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
            )
        }
        })
    });
</script>
<livewire:scripts />
<script>
    $(document).ready(function(){

    var url = window.location.href;
    var encodedString = btoa(url);
    encodedString=encodedString.replace("==","");
    encodedString=encodedString.replace("=","");

    //alert(encodedString);
    $activeUrl=$("#"+encodedString);
    //alert($activeUrl)
    $activeUrl.addClass("active");

    $activeLi=$activeUrl.parents("li.customLiClass:first");
    $activeLi.addClass("menu-open");
    });
</script>
@stack('js')
</body>
</html>
