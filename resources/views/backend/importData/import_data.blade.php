<x-admin-layouts>
    <div>
        @section('title')
            Data import
    @endsection
    <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Data Import</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Import</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col-md-6 -->
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">Data Import</h5>
                            </div>
                            @include('backend.flashMessage.flash-message')
                            <div class="card-body">
                                <form autocomplete="off" action="{{ route('app.data.upload') }}" enctype="multipart/form-data" method="POST" accept-charset="UTF-8">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="model">Model *</label>
                                                <select class="form-control @error('model') is-invalid @enderror"
                                                        id="modelField" name="model" style="width: 100%">
                                                    <option value="">Select</option>
                                                    @foreach($modelLists as $item)
                                                        <option value="{{ $item }}">{{ $item }}</option>
                                                    @endforeach
                                                </select>
                                                @error('model')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="file_import">File *</label>
                                                <input type="file"
                                                       class="form-control @error('file_import') is-invalid @enderror"
                                                       id="file_import"
                                                       name="file_import">
                                                @error('file_import')
                                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-check">
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                                class="fa fa-times mr-1"></i>Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary"><i
                                                class="fa fa-upload mr-1"></i>Upload
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
</x-admin-layouts>
@push('js')
    <script>
        $(document).ready(function () {
            $('#modelField').select2({
                placeholder: "Select Model",
                allowClear: true
            });
        });
    </script>
@endpush
