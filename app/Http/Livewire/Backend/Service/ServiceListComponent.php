<?php

namespace App\Http\Livewire\Backend\Service;

use App\Models\Service;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use App\Traits\withDataTable;

class ServiceListComponent extends Component
{
    use WithPagination, withDataTable;

    protected $paginationTheme = 'bootstrap';
    public $showEditModal = false;
    public $state = [];
    public $searchTerm = null;
    //public Service $service;
    public $service;
    protected $queryString = ['searchTerm' => ['except' => '']];


    protected $listeners = [
        'delete'
    ];

    public function addNewService()
    {
        Gate::authorize('service-create');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createService()
    {
        Gate::authorize('service-create');
        Validator::make($this->state, [
            'service_name' => 'required|min:3|unique:services,service_name',
            'is_active' => 'sometimes',
        ])->validate();
        Service::create([
            'service_name' => $this->state['service_name'],
            'is_active' => $this->state['is_active'],
            'created_by' => Auth()->user()->id,
        ]);
        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Service Added Successfully']);
        return redirect()->back();
    }

    public function updated($name)
    {
        $this->validateOnly($name, [
            'state.service_name' => 'required|min:3|unique:services,service_name',
        ]);
    }

    public function editService(Service $service)
    {
        Gate::authorize('service-update');
        $this->service = $service;
        $this->state = $service->toArray();
        $this->showEditModal = true;
        $this->dispatchBrowserEvent('show-form');
    }

    public function updateService()
    {
        Gate::authorize('service-update');
        $data = Validator::make($this->state, [
            'service_name' => 'required|min:3|unique:services,service_name,' . $this->service->id,
            'is_active' => 'sometimes',
        ])->validate();

        $this->service->update([
            'service_name' => $this->state['service_name'],
            'is_active' => $this->state['is_active'],
            'created_by' => Auth()->user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Service Updated Successfully']);
        return redirect()->back();
    }

    public function deleteConfirm($id)
    {
        Gate::authorize('service-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Gate::authorize('service-delete');
        Service::findOrFail($id)->delete();
    }

    public function render()
    {
        Gate::authorize('service-index');
        //$services = Service::latest()->paginate(10);
        $services = Service::query()
            ->where('service_name', 'like', '%' . $this->searchTerm . '%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.backend.service.service-list-component', [
            'services' => $services
        ]);
    }
}
