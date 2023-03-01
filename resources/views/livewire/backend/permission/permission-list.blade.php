<div>
{{--    <x-loading-indicator/>--}}
    @section('title')
        Permission
    @endsection
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Permissions</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Permission</li>
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
                            <h5 class="m-0 float-left">Permission Management</h5>
                            @permission('permission-create')
                            {{-- <a href="{{ route('app.addUser') }}" class="btn btn-primary float-right"><i class="fa fa-plus-circle mr-1"></i> Add New</a> --}}
                            <button wire:click.prevent="addNewPermission" class="btn btn-primary float-right"><i
                                    class="fa fa-plus-circle mr-1"></i> Add New
                            </button>
                            @endpermission
                        </div>
                        <div class="card-body">
                            <div class="flex align-items-center justify-content-between">
                                <x-per-page wire:model="perPage"/>
                                <x-search-input wire:model="searchTerm"/>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>
                                        Name
                                        <x-sort-by wire:click="sortBy('name')" :sortColumnName=$sortColumnName :sortDirection=$sortDirection />
                                    </th>
                                    <th>
                                        Slug
                                        <x-sort-by wire:click="sortBy('slug')" :sortColumnName=$sortColumnName :sortDirection=$sortDirection />
                                    </th>
                                    <th>Status</th>
                                    <th>Created_at</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse ($permissions as $index => $item)
                                    <tr>
                                        <td>{{ $permissions->firstItem() + $index }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->slug }}</td>
                                        <td>
                                            @if($item->is_active == true)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-warning">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at->diffForhumans() }}</td>
                                        <td>
                                            @permission('permission-update')
                                            <a href="" wire:click.prevent="editPermission({{ $item }})">
                                                <i class="fa fa-edit mr-1"></i>
                                            </a>
                                            @endpermission
                                            @permission('permission-delete')
                                            <a href="" wire:click.prevent="deleteConfirm({{ $item->id }})">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                            @endpermission
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
                            {{ $permissions->links() }}
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
                        Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form autocomplete="off"
                      wire:submit.prevent="{{ $showEditModal ? 'updatePermission' : 'createPermission' }}">
                    <div class="modal-body">
                        <div class="card-body">
                            <div wire:ignore class="form-group">
                                <label for="module_id">Module</label>
                                <select class="form-control @error('module_id') is-invalid @enderror"
                                        wire:model="state.module_id" required>
                                    <option value=""></option>
                                    @foreach($modules as $module)
                                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                                    @endforeach
                                </select>
                                @error('module_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Permission Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" placeholder="Enter your name" wire:model.defer="state.name" required>
                                @error('name')
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
                                           wire:model.defer="state.is_active">
                                    <label class="custom-control-label" for="is_active">Status</label>
                                </div>
                                @error('is_active')
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
