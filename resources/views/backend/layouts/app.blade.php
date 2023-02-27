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
  <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <livewire:styles />
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/toastr/toastr.min.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  @stack('css')

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  @include('backend.layouts.partials.header')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  {{-- @include('backend.layouts.partials.sidebar') --}}
  <x-partials.sidebar />

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    {{ $slot }}
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  @include('backend.layouts.partials.rightsidebar')
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <x-partials.footer />
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
<script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js" defer></script>
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
        //$('.roleselect').select2();
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
@stack('js')
</body>
</html>
