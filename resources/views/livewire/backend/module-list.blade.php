<div>
    <x-loading-indicator />
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
                <button wire:click.prevent="addNew" class="btn btn-primary float-right"><i class="fa fa-plus-circle mr-1"></i> Add New</button>
                @endpermission
                </div>
                <div class="card-body">
                    <x-search-input wire:model="searchTerm" />
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th style="width: 10px">#</th>
                            <th>Module Nmae</th>
                            <th>url</th>
                            <th>Created_at</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody wire:loading.class="text-muted">
                            @forelse ($modules as $item)
                            <tr>
                                {{-- <td>{{ $loop->index+1 }}</td> --}}
                                <td class="align-middle">
                                  @if($showMore==0)
                                  <button type="button" wire:click.prevent="open({{ $item->id }})" class="btn btn-link text-info">
                                    <i class="far fa-plus-square"></i>
                                </button>
                                  @elseif($showMore==$item->id)
                                <button type="button" wire:click.prevent="close({{ $item->id }})" class="btn btn-link text-info">
                                  <i class="far fa-minus-square"></i>
                              </button>
                              @else
                              <button type="button" wire:click.prevent="open({{ $item->id }})" class="btn btn-link text-info">
                                <i class="far fa-plus-square"></i>
                            </button>
                                  @endif
                              </td>
                                <td>{{ $item->name }}</td>
                                {{-- <td>
                                  @foreach ($item->children as $submodule)
                                    <span class="badge badge-primary">{{ $submodule->name }}</span>
                                  @endforeach
                                </td> --}}
                                <td>
                                  {{ $item->url }}
                                </td>
                                <td>{{ $item->created_at }}</span></td>
                                <td>
                                    <a href="" wire:click.prevent="editModule({{ $item }})">
                                        <i class="fa fa-edit mr-1"></i>
                                    </a>
                                    <a href="" wire:click.prevent="deleteConfirm({{ $item->id }})">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                            {{-- <div x-show="showMore">
                            </div> --}}
                            @foreach ($item->children as $submodule)
                            <tr class="@if($showMore==$item->id)  @else d-none @endif">
                              
                              <td></td>
                              <td>{{ $submodule->name }}</td>
                              <td>{{ $submodule->url }}</td>
                              <td>{{ $submodule->created_at }}</span></td>
                              <td>
                                <a href="" wire:click.prevent="editModule({{ $submodule }})">
                                    <i class="fa fa-edit mr-1"></i>
                                </a>
                                <a href="" wire:click.prevent="deleteConfirm({{ $submodule->id }})">
                                    <i class="fa fa-trash text-danger"></i>
                                </a>
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

    <!-- Modal -->
    <div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{ ($showEditModal) ? 'Edit' : 'Create' }} Module</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateModule' : 'createModule' }}">
            <div class="modal-body">
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="name">Module Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter your name" wire:model="state.name" value="{{ $user->name ?? old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                          <label for="sort_order">Order</label>
                          <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" placeholder="Enter module order" wire:model="state.sort_order">
                          @error('sort_order')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                      <div class="form-group">
                        <label for="name">Url</label>
                        <input type="text" class="form-control @error('url') is-invalid @enderror" id="name" placeholder="url" wire:model.defer="state.url">
                        @error('url')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                      <label for="name">Icon</label>
                      <input type="text" class="form-control @error('icon') is-invalid @enderror" id="name" placeholder="fas fa-plus" wire:model.defer="state.icon">
                      @error('icon')
                          <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
    
                  <div class="form-group">
                    {{-- <label for="status">Status</label> --}}
                    <div class="custom-control custom-switch">
                        <input type="checkbox"
                               class="custom-control-input @error('is_active') is-invalid @enderror"
                               id="status"
                               wire:model.defer="state.is_active" @isset($role) {{ $role->is_active==true ? 'checked' : ''}} @endisset>
                        <label class="custom-control-label" for="status">Status</label>
                    </div>
                    @error('is_active')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
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
// $(document).ready(function() {
//     $('.roleselect').select2({
//         dropdownParent: $("#form"),
//     });
//     $('.roleselect').on('change', function (e) {
//         var data = $('.roleselect').select2("val");
//         @this.set('role_id', data);
//     });
// });
</script>

@endpush

