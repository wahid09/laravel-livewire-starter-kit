<div>
    <x-loading-indicator />
    <!-- Content Header (Page header) -->
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

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-lg-12">

            <div class="card card-primary card-outline">
                <div class="card-header">
                <h5 class="m-0 float-left">User Management</h5>
                @permission('user-create')
                <button wire:click.prevent="addNew" class="btn btn-primary float-right"><i class="fa fa-plus-circle mr-1"></i> Add New</button>
                @endpermission
                </div>
                <div class="card-body">
                    <x-search-input wire:model="searchTerm" />
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th style="width: 10px">#</th>
                            <th>Nmae</th>
                            <th>Email</th>
                            <th>Created_at</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody wire:loading.class="text-muted">
                            @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                  {{ $user->email }}
                                </td>
                                <td>{{ $user->created_at }}</span></td>
                                <td>
                                    <a href="" wire:click.prevent="editUser({{ $user }})">
                                        <i class="fa fa-edit mr-1"></i>
                                    </a>
                                    <a href="" wire:click.prevent="deleteConfirm({{ $user->id }})">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <div>
                                <tr class="text-center">
                                    <td colspan="5">No Data Found.</td>
                                </tr>
                            </div>
                            @endforelse
                        </tbody>
                      </table>
                </div>

                <div class="card-footer clearfix d-flex justify-content-end">
                    {{ $users->links() }}
                </div>
            
            </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- Modal -->
    <div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{ ($showEditModal) ? 'Edit' : 'Create' }} User</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateUser' : 'createUser' }}">
            <div class="modal-body">
                    <div class="card-body">
                        {{-- <x:select-list wire:model="test" id="test" name="test" :messages="$tests" select-type="label"/> --}}
                        <div class="form-group">
                            <label>Minimal</label>
                            {{-- <input id="role" type="hidden" wire:model.lazy="state.role"/> --}}
                            <div wire:ignore>
                            <select data-livewire="@this" class="form-control roleselect" style="width: 100%;" wire:model.lazy="state.role" {{ $selected }}>
                              <option></option>
                              @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                               @endforeach
                            </select>
                            </div>
                        </div>
                        {{-- <div class="col d-flex display-inline-block">
                            <label>Device</label>
                            <select {{ $customer ? '' : 'disabled' }} wire:model="selectedItem" class="form-control contact_devices_multiple" data-placeholder="Select" style="width: 100%;">
                              @foreach($devices as $device)
                                 <option value="{{ $device }}">{{ $device }}</option>
                              @endforeach
                            </select>
                          </div> --}}
                        
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter your name" wire:model.defer="state.name" value="{{ $user->name ?? old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                      <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter email" wire:model.defer="state.email" value="{{ $user->email ?? old('email') }}">
                        @error('email')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                      </div>
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" wire:model.defer="state.password" {{ !isset($user) ? 'required' : '' }}>
                        @error('password')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                      </div>
                      <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="confirm_password" placeholder="Confirm Password" wire:model.defer="state.password_confirmation" {{ !isset($user) ? 'required' : '' }}>
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
                    <!-- /.card-body -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Cancel</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-1"></i>{{ ($showEditModal) ? 'Update' : 'Save' }}</button>
            </div>
        </form>
          </div>
        </div>
      </div>
</div>
@push('js')
<script>
    $(document).ready(function() {
        $('.roleselect').select2({
            dropdownParent: $("#form"),
            placeholder: '{{__('Select your option')}}',
            allowClear: true
        });
        $('.roleselect').on('change', function (e) {
            let elementName = $(this).attr('id');
            var data = $(this).select2("val");
            @this.set(elementName, data);
            //let livewire = $(this).data('livewire')
            //eval(livewire).set('role', $(this).val());
        });
    });
</script>
{{-- <script>
$(document).ready(function() {
    $('.roleselect').select2({
        dropdownParent: $("#form"),
    });
    $('.roleselect').on('change', function (e) {
        var data = $('.roleselect').select2("val");
        @this.set('selected', data);
    });
});
</script> --}}
{{-- <script>
document.addEventListener('livewire:load', function (){
    $('.roleselect').on('change', function (e) {
    var data = $('.roleselect').select2("val");
    @this.set('selected', data);
});
});
</script> --}}
@endpush
