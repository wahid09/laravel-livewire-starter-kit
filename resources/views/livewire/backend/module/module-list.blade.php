<div>
{{--    <x-loading-indicator/>--}}
    @section('title')
        Module
    @endsection
<!-- Content Header (Page header) -->
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

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col-md-6 -->
                <div class="col-lg-12">

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0 float-left">Module Management</h5>
                            @permission('module-create')
                            {{--                            <a href="{{ route('app.module.create') }}" class="btn btn-primary float-right"><i--}}
                            {{--                                    class="fa fa-plus-circle mr-1"></i> Add New</a>--}}
                            <button wire:click.prevent="addNewModule" class="btn btn-primary float-right"><i
                                    class="fa fa-plus-circle mr-1"></i> Add New
                            </button>
                            @endpermission
                        </div>
                        <div class="card-body">
                            <x-search-input wire:model="searchTerm"/>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 3px">#</th>
                                    {{--                                    <th style="width: 10px">#</th>--}}
                                    <th>Module Nmae</th>
                                    {{--                                    <th>Sub-Module</th>--}}
                                    <th>URL</th>
                                    <th>Created_at</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse ($modules as $item)
                                    <tr data-widget="expandable-table" aria-expanded="false">
                                        <td class="align-middle">
                                            @if($showMore == 0)

                                                <button type="button" wire:click="open({{$item->id}})"
                                                        class="btn btn-link text-info">
                                                    <i class="far fa-plus-square"></i>
                                                </button>
                                            @elseif($showMore == $item->id)
                                                <button type="button" wire:click="close({{$item->id}})"
                                                        class="btn btn-link text-info">
                                                    <i class="far fa-minus-square"></i>
                                                </button>
                                            @else
                                                <button type="button" wire:click="open({{$item->id}})"
                                                        class="btn btn-link text-info">
                                                    <i class="far fa-plus-square"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            {{ $item->url }}
                                        </td>
                                        <td>
                                            {{ $item->created_at->diffForhumans() }}
                                        </td>
                                        <td>
                                            @permission('module-create')
                                            <a href="" wire:click.prevent="addNewSubModule({{$item}})">
                                                <i class="fa fa-plus-circle mr-1"></i>
                                            </a>
                                            @endpermission
                                            @permission('module-update')
                                            <a href="" wire:click.prevent="editModule({{$item}})">
                                                <i class="fa fa-edit mr-1"></i>
                                            </a>
                                            @endpermission
                                            @permission('module-delete')
                                            <a href="" wire:click.prevent="deleteConfirm({{ $item->id }})">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                            @endpermission
                                        </td>
                                    </tr>
                                    @foreach($item->children as $key)
                                        <tr class="@if($showMore == $item->id)  @else d-none @endif"
                                            style="background-color:#f2eee4">
                                            <td></td>
                                            <td>{{ $key->name }}</td>
                                            <td>{{ $key->url }}</td>
                                            <td>{{ $key->created_at->diffForhumans() }}</td>
                                            <td>
                                                @permission('module-update')
                                                <a href="" wire:click.prevent="editModule({{$key}})">
                                                    <i class="fa fa-edit mr-1"></i>
                                                </a>
                                                @endpermission
                                                @permission('module-delete')
                                                <a href="" wire:click.prevent="deleteConfirm({{ $key->id }})">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </a>
                                                @endpermission
                                            </td>
                                        </tr>
                                    @endforeach
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
                            {{ $modules->links() }}
                        </div>

                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
         wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ ($showEditModal) ? 'Edit' : 'Create' }}
                        Module</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateModule' : 'createModule'}}">
                    <div class="modal-body">
                        <div class="card-body">
                            @if($subModule)
                                <div class="form-group">
                                    <label for="name">Submodule Name *</label>
                                    <input type="text"
                                           class="form-control @error('state.name') is-invalid @enderror"
                                           id="name" placeholder="Enter submodule name" wire:model="state.name">
                                    @error('state.name')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="name">Module Name *</label>
                                    <input type="text"
                                           class="form-control @error('state.name') is-invalid @enderror"
                                           id="name" placeholder="Enter module name" wire:model="state.name">
                                    @error('state.name')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            @endif
                            @if($subModule)
                                <div class="form-group">
                                    <label for="name">URL *</label>
                                    <input type="text"
                                           class="form-control @error('url') is-invalid @enderror"
                                           id="name"
                                           placeholder="Module name(singular)/sub module name plural(e.g dev-consol/permissions)"
                                           wire:model.lazy="state.url">
                                    @error('url')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="name">URL *</label>
                                    <input type="text"
                                           class="form-control @error('url') is-invalid @enderror"
                                           id="name"
                                           placeholder="Enter Module Name(e.g dev-console)"
                                           wire:model.lazy="state.url">
                                    @error('url')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="name">Order *</label>
                                <input type="number"
                                       class="form-control @error('state.sort_order') is-invalid @enderror"
                                       id="name" placeholder="Enter Order" wire:model="state.sort_order">
                                @error('state.sort_order')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Icon *</label>
                                <input type="text"
                                       class="form-control @error('icon') is-invalid @enderror"
                                       id="name" placeholder="Enter icon (e.g fa fa-user)" wire:model.lazy="state.icon">
                                @error('icon')
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
                                           wire:model.lazy="state.is_active" @isset($service) {{ $service->is_active==true ? 'checked' : ''}} @endisset>
                                    <label class="custom-control-label" for="is_active">Status *</label>
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
    <!-- Modal -->

</div>
@push('js')
    <script>
        // document.addEventListener("livewire:load", () => {
        // Livewire.hook('message.processed', (message, component) => {
        // 	$('#select2').select2()

        // }); });
        // $(document).ready(function () {
        //     $('#select2').on('change', function (e) {
        //         var data = $('#select2').select2("val");
        //         @this.set('selected', data);
        //     });
        // });

        // $(document).ready(function() {
        //     window.initSelectCompanyDrop=()=>{
        //         $('#select2').select2({
        //             placeholder: 'Select a Company',
        //             allowClear: true});
        //     }
        //     initSelectCompanyDrop();
        //     $('#select2').on('change', function (e) {
        //         livewire.emit('selectedCompanyItem', e.target.value)
        //     });
        //     window.livewire.on('select2',()=>{
        //         initSelectCompanyDrop();
        //     });

        // });
    </script>
@endpush
