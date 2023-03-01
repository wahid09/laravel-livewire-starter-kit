<div>
    @section('title')
        user-create
    @endsection
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                <div class="col-lg-12">

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0 float-left">User Management</h5>
                            @permission('user-index')
                            <a href="{{ route('app.access-control/users') }}" class="btn btn-warning float-right"><i
                                    class="fa fa-arrow-left mr-1"></i> Back</a>
                            @endpermission
                        </div>
                        <div class="card-body">
                            <form autocomplete="off"
                                  wire:submit.prevent="createUser">
                                <div class="modal-body">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div wire:ignore class="form-group">
                                                    <label for="role_id">Role *</label>
                                                    <select class="form-control @error('role_id') is-invalid @enderror"
                                                            id="select2" wire:model="state.role_id" style="width: 100%">
                                                        <option value=""></option>
                                                        @foreach($roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('role_id')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="username">User Name *</label>
                                                    <input type="text"
                                                           class="form-control @error('username') is-invalid @enderror"
                                                           id="username" placeholder="Enter your user name"
                                                           wire:model.defer="state.username" required>
                                                    @error('username')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email Address *</label>
                                                    <input type="email"
                                                           class="form-control @error('email') is-invalid @enderror"
                                                           id="email"
                                                           placeholder="Enter email" wire:model.defer="state.email"
                                                           value="{{ $user->email ?? old('email') }}" required>
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password *</label>
                                                    <input type="password"
                                                           class="form-control @error('password') is-invalid @enderror"
                                                           id="password" placeholder="Password"
                                                           wire:model.defer="state.password">
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="first_name">First Name *</label>
                                                    <input type="text"
                                                           class="form-control @error('first_name') is-invalid @enderror"
                                                           id="name" placeholder="Enter your first name"
                                                           wire:model.defer="state.first_name" required>
                                                    @error('first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="address">Address</label>
                                                    <input type="text"
                                                           class="form-control @error('address') is-invalid @enderror"
                                                           id="address" placeholder="Address"
                                                           wire:model.defer="state.address">
                                                    @error('address')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="form-check">

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                
                                                <div class="form-group">
                                                    <label for="confirm_password">Retype Password *</label>
                                                    <input type="password"
                                                           class="form-control @error('password_confirmation') is-invalid @enderror"
                                                           id="confirm_password" placeholder="Confirm Password"
                                                           wire:model.defer="state.password_confirmation">
                                                    @error('password_confirmation')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="name">Last Name</label>
                                                    <input type="text"
                                                           class="form-control @error('last_name') is-invalid @enderror"
                                                           id="name" placeholder="Enter your last name"
                                                           wire:model.defer="state.last_name">
                                                    @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone">Phone</label>
                                                    <input type="tel"
                                                           class="form-control @error('phone') is-invalid @enderror"
                                                           id="phone"
                                                           wire:model.defer="state.phone"
                                                           pattern="[0-9]{11}">
                                                    <small>Format: xxxxx-xxx-xxx</small>
                                                    @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox"
                                                               class="custom-control-input @error('status') is-invalid @enderror"
                                                               id="is_active"
                                                               wire:model.defer="state.status">
                                                        <label class="custom-control-label"
                                                               for="is_active">Status</label>
                                                    </div>
                                                    @error('status')
                                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
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
            $('#select2').on('change', function (e) {
                var data = $('#select2').select2("val");
            @this.set('role_id', data);
            });
        });
        $(document).ready(function () {
            $('#unit').select2({
                placeholder: "Select Unit",
                allowClear: true
            });
            $('#unit').on('change', function (e) {
                var data = $('#unit').select2("val");
            @this.set('unit_id', data);
            });
        });
        $(document).ready(function () {
            $('#rank').select2({
                placeholder: "Select Rank",
                allowClear: true
            });
            $('#rank').on('change', function (e) {
                var data = $('#rank').select2("val");
            @this.set('rank_id', data);
            });
        });
    </script>
@endpush
