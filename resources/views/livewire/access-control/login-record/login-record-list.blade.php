<div>
{{--    <x-loading-indicator/>--}}
<!-- Content Header (Page header) -->
    @section('title')
        Login-Record
    @endsection
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Login Records</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Login Records</li>
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
                            <h5 class="m-0 float-left">Login Records Management</h5>
                            {{--                            @permission('create')--}}
                            {{--                            <button wire:click.prevent="addNewService" class="btn btn-primary float-right"><i--}}
                            {{--                                    class="fa fa-plus-circle mr-1"></i> Add New--}}
                            {{--                            </button>--}}
                            {{--                            @endpermission--}}
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
                                    <th>User</th>
                                    <th>Ip Address</th>
                                    <th>Login Status</th>
                                    <th>Login at</th>
                                    <th>Logout at</th>
                                    {{--                                    <th>Location</th>--}}
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse ($loginLogs as $item)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ Auth::user()->find($item->authenticatable_id)->full_name }}</td>
                                        <td>{{ $item->ip_address }}</td>
                                        <td>
                                            @if($item->login_successful == 1)
                                                <span class="badge badge-success">Successful</span>
                                            @else
                                                <span class="badge badge-warning">Failed</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->login_at }}</td>
                                        <td>{{ $item->logout_at }}</td>
                                        {{--                                        <td>{{ $item->location }}</td>--}}
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
                            {{ $loginLogs->links() }}
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
@endpush


