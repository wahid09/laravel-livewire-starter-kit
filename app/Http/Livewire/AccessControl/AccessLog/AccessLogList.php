<?php

namespace App\Http\Livewire\AccessControl\AccessLog;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use App\Traits\withDataTable;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;

class AccessLogList extends Component
{
    use WithPagination, withDataTable;

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['searchTerm' => ['except' => '']];

    public function render()
    {
        Gate::authorize('access-log-index');
        if (Auth::user()->role_id == 1) {
            //$accessLogs = Activity::latest()->get();
            $accessLogs = Activity::query()
                ->where('log_name', 'like', '%' . $this->searchTerm . '%')
                ->where('description', 'like', '%' . $this->searchTerm . '%')
                ->where('event', 'like', '%' . $this->searchTerm . '%')
                ->where('subject_type', 'like', '%' . $this->searchTerm . '%')
                ->orderBy($this->sortColumnName, $this->sortDirection)
                ->paginate($this->perPage);
        } else {
            //$accessLogs = Activity::latest()->where('causer_id', Auth::user()->id)->get();
            $accessLogs = Activity::query()
                ->where('log_name', 'like', '%' . $this->searchTerm . '%')
                ->where('description', 'like', '%' . $this->searchTerm . '%')
                ->where('event', 'like', '%' . $this->searchTerm . '%')
                ->where('subject_type', 'like', '%' . $this->searchTerm . '%')
                ->where('causer_id', Auth::user()->id)
                ->orderBy($this->sortColumnName, $this->sortDirection)
                ->paginate($this->perPage);
        }
        //dd($accessLogs);
        return view('livewire.access-control.access-log.access-log-list', [
            'accessLogs' => $accessLogs
        ]);
    }
}
