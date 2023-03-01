<div>
    {{--    <x-loading-indicator/>--}}
    @section('title')
        Rank
@endsection
<!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ranks</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Rank</li>
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
                            <h5 class="m-0 float-left">Rank Management</h5>
                            @permission('rank-create')
                            {{-- <a href="{{ route('app.addUser') }}" class="btn btn-primary float-right"><i class="fa fa-plus-circle mr-1"></i> Add New</a> --}}
                            <button wire:click.prevent="addNewRank" class="btn btn-primary float-right"><i
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
                                    <th></th>
                                    <th style="width: 10px">#</th>
                                    <th>
                                        Rank Name
                                        <x-sort-by wire:click="sortBy('rank_name')" :sortColumnName=$sortColumnName :sortDirection=$sortDirection />
                                    </th>
                                    <th>
                                        Rank Short Name
                                        <x-sort-by wire:click="sortBy('rank_short_name')" :sortColumnName=$sortColumnName :sortDirection=$sortDirection />
                                    </th>
                                    <th>
                                        Rank Order
                                    </th>
                                    <th>Status</th>
                                    <th>Created_at</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted" wire:sortable="updateRankOrder">
                                @forelse ($ranks as $index => $item)
                                    <tr wire:sortable.item="{{ $item->id }}"
                                        wire:key="rank-{{ $item->rank_order }}">
                                        <td wire:sortable.handle style="width: 10px; cursor: move;"><i
                                                class="fa fa-arrows-alt text-muted"></i></td>
                                        {{--                                        <th style="width: 10px;">--}}
                                        {{--                                            <div class="icheck-primary d-inline">--}}
                                        {{--                                                <input wire:model="selectedRows" type="checkbox"--}}
                                        {{--                                                       value="{{ $item->id }}" name="todo2"--}}
                                        {{--                                                       id="{{ $item->id }}">--}}
                                        {{--                                                <label for="{{ $item->id }}"></label>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </th>--}}
                                        <td>{{ $ranks->firstItem() + $index }}</td>
                                        <td>{{ $item->rank_name }}</td>
                                        <td>{{ $item->rank_short_name }}</td>
                                        <td>{{ $item->rank_order }}</td>
                                        <td>
                                            @if($item->is_active == true)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-warning">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at->diffForhumans() }}</td>
                                        <td>
                                            @permission('rank-update')
                                            <a href="" wire:click.prevent="editRank({{ $item }})">
                                                <i class="fa fa-edit mr-1"></i>
                                            </a>
                                            @endpermission
                                            @permission('rank-delete')
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
                            {{ $ranks->links() }}
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
                        Rank</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form autocomplete="off"
                      wire:submit.prevent="{{ $showEditModal ? 'updateRank' : 'createRank' }}">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="rank_name">Rank Name</label>
                                <input type="text" class="form-control @error('rank_name') is-invalid @enderror"
                                       id="rank_name" placeholder="Rank Name" wire:model.defer="state.rank_name">
                                @error('rank_name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="rank_short_name">Rank Short Name</label>
                                <input type="text" class="form-control @error('rank_short_name') is-invalid @enderror"
                                       id="rank_short_name" placeholder="Rank Name" wire:model.defer="state.rank_short_name">
                                @error('rank_short_name')
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
@push('css')
    <style>
        .draggable-mirror {
            background-color: white;
            width: 1200px;
            display: flex;
            justify-content: space-between;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
@endpush
@push('js')
@endpush
