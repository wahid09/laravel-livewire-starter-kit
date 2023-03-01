<div>
{{--    <x-loading-indicator/>--}}
    <!-- Content Header (Page header) -->
    @section('title')
        User
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
                            <a href="{{ route('app.user.create') }}" class="btn btn-primary float-right"><i
                                    class="fa fa-plus-circle mr-1"></i> Add New</a>
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
                                        User Name
                                        <x-sort-by wire:click="sortBy('username')" :sortColumnName=$sortColumnName :sortDirection=$sortDirection />
                                    </th>
                                    <th>
                                        Full Name
                                        <x-sort-by wire:click="sortBy('first_name')" :sortColumnName=$sortColumnName :sortDirection=$sortDirection />
                                    </th>
                                    <th>
                                        Email
                                        <x-sort-by wire:click="sortBy('email')" :sortColumnName=$sortColumnName :sortDirection=$sortDirection />
                                    </th>
                                    <th>User Group</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Created_at</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse ($users as $index => $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $index }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->full_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role->name }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>
                                            @if($user->status == true)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-warning">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $user->created_at->diffForhumans() }}
                                        </td>
                                        <td>
                                            @permission('user-update')
                                            <a href="{{ route('app.user.edit', $user) }}">
                                                <i class="fa fa-edit mr-1"></i>
                                            </a>
                                            @endpermission
                                            @permission('user-delete')
                                            <a href="" wire:click.prevent="deleteConfirm({{ $user->id }})">
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
