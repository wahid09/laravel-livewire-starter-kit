<div>
{{--    <x-loading-indicator/>--}}
    @section('title')
        Role
    @endsection
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Roles</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Roles</li>
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
                            <h5 class="m-0 float-left">Role Management</h5>
                            @permission('role-create')
                            <a href="{{ route('app.role.create') }}" class="btn btn-primary float-right"><i
                                    class="fa fa-plus-circle mr-1"></i> Add New</a>
                            @endpermission
                        </div>
                        <div class="card-body">
                            <x-search-input wire:model="searchTerm"/>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Permissions</th>
                                    <th>Status</th>
                                    <th>Created_at</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse ($roles as $role)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->permissions_count }}</td>
                                        <td>
                                            @if($role->is_active == true)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-warning">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $role->created_at->diffForhumans() }}</td>
                                        <td>
                                            @permission('role-update')
                                            <a href="{{ route('app.role.update', $role->id) }}">
                                                <i class="fa fa-edit mr-1"></i>
                                            </a>
                                            @endpermission
                                            @if($role->deletable == true)
                                                @permission('role-delete')
                                                <a href="" wire:click.prevent="deleteConfirm({{ $role }})">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </a>
                                                @endpermission
                                            @else
                                                <span class="badge badge-warning">Not Deletable</span>
                                            @endif

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
                            {{ $roles->links() }}
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
    <div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
         wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ ($showEditModal) ? 'Edit' : 'Create' }}
                        Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateRole' : 'createRole' }}">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" placeholder="Enter your name" wire:model.defer="state.name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox"
                                           class="custom-control-input @error('deletable') is-invalid @enderror"
                                           id="deletable"
                                           wire:model.defer="state.deletable" @isset($role) {{ $role->deletable==true ? 'checked' : ''}} @endisset>
                                    <label class="custom-control-label" for="deletable">Is deletable</label>
                                </div>
                                @error('deletable')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox"
                                           class="custom-control-input @error('is_active') is-invalid @enderror"
                                           id="is_active"
                                           wire:model.defer="state.is_active" @isset($role) {{ $role->is_active==true ? 'checked' : ''}} @endisset>
                                    <label class="custom-control-label" for="is_active">Status</label>
                                </div>
                                @error('is_active')
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
                                class="fa fa-save mr-1"></i>{{ ($showEditModal) ? 'Update' : 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('js')
@endpush
