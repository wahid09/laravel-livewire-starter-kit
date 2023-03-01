<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Modules</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Modules</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col-md-6 -->
                <div class="col-lg-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0 float-left">Module Management</h5>
                            @permission('module-create')
                            <a href="{{ route('app.dev/modules') }}" class="btn btn-warning float-right"><i
                                    class="fa fa-arrow-left mr-1"></i> Back</a>
                            @endpermission
                        </div>
                        <div class="card-body">
                            <form autocomplete="off"
                                  wire:submit.prevent="createModule">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <div wire:ignore class="input-group">
                                                    <div class="custom-control">
                                                    <label for="role_id">Module</label>
                                                    <select
                                                        class="custom-control @error('module_id') is-invalid @enderror"
                                                        id="select2" wire:model="state.module_id" style="width: 100%">
                                                        <option value=""></option>
                                                        @foreach($modules as $module)
                                                            <option
                                                                value="{{ $module->id }}">{{ $module->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('module_id')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    </div>
                                                    {{-- <div>
                                                        <select data-pharaonic="select2" data-component-id="{{ $this->id }}" wire:model="country" id="roleselect">
                                                            <option value="EG">Egypt</option>
                                                            <option value="TW">Taiwan</option>
                                                        </select>
                                                    </div> --}}
                                                    <div class="input-group-append">
                                                    <button class="btn">+ Add New</button>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text"
                                                           class="form-control @error('name') is-invalid @enderror"
                                                           id="name" placeholder="Enter your name"
                                                           wire:model.defer="state.name"
                                                           value="{{ $user->name ?? old('name') }}">
                                                    @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email address</label>
                                                    <input type="email"
                                                           class="form-control @error('email') is-invalid @enderror"
                                                           id="email"
                                                           placeholder="Enter email" wire:model.defer="state.email"
                                                           value="{{ $user->email ?? old('email') }}">
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password"
                                                           class="form-control @error('password') is-invalid @enderror"
                                                           id="password" placeholder="Password"
                                                           wire:model.defer="state.password" {{ !isset($user) ? 'required' : '' }}>
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirm_password">Confirm Password</label>
                                                    <input type="password"
                                                           class="form-control @error('password_confirmation') is-invalid @enderror"
                                                           id="confirm_password" placeholder="Confirm Password"
                                                           wire:model.defer="state.password_confirmation" {{ !isset($user) ? 'required' : '' }}>
                                                    @error('password_confirmation')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="form-check">
                                                    {{-- <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                    <label class="form-check-label" for="exampleCheck1">Check me out</label> --}}
                                                    {{-- <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                            class="fa fa-times mr-1"></i>Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-save mr-1"></i>Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function () {
            $('#select2').select2({
                placeholder: "Select Role",
                allowClear: true
            });
            // $('#select2').on('change', function (e) {
            //     var data = $('#select2').select2("val");
            // @this.set('selected', data);
            // });
        });
    </script>
@endpush

