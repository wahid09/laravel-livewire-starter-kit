<div>
{{--    <x-loading-indicator/>--}}
<!-- Content Header (Page header) -->
    @section('title')
        Access-Log
    @endsection
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Access Logs</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Access Logs</li>
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
                            <h5 class="m-0 float-left">Access Log Management</h5>
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
                                    <th>
                                        Log Name
                                        <x-sort-by wire:click="sortBy('log_name')" :sortColumnName=$sortColumnName :sortDirection=$sortDirection />
                                    </th>
                                    <th>User</th>
                                    <th>Description</th>
                                    <th>
                                        Subject
                                        <x-sort-by wire:click="sortBy('event')" :sortColumnName=$sortColumnName :sortDirection=$sortDirection />
                                    </th>
                                    <th>
                                        Event
                                        <x-sort-by wire:click="sortBy('event')" :sortColumnName=$sortColumnName :sortDirection=$sortDirection />
                                    </th>
                                    <th>Event Time</th>
                                    {{--                                    <th>Location</th>--}}
                                </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted">
                                @forelse ($accessLogs as $item)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $item->log_name }}</td>
                                        <td>
                                            @if($item->causer_id)
                                                {{ Auth::user()->find($item->causer_id)->full_name }}
                                            @else
                                                <span class="text-center">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->description }}</td>
                                        {{--                                        <td>--}}
                                        {{--                                            @if($item->login_successful == 1)--}}
                                        {{--                                                <span class="badge badge-success">Successful</span>--}}
                                        {{--                                            @else--}}
                                        {{--                                                <span class="badge badge-warning">Failed</span>--}}
                                        {{--                                            @endif--}}
                                        {{--                                        </td>--}}
                                        <td>{{ $item->subject_type }}</td>
                                        <td>{{ $item->event }}</td>
                                        <td>{{ $item->created_at }}</td>
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
                            {{ $accessLogs->links() }}
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


