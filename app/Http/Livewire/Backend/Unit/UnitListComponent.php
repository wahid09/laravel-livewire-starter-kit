<?php

namespace App\Http\Livewire\Backend\Unit;

use App\Models\Division;
use App\Models\Service;
use App\Models\Unit;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Traits\withDataTable;

class UnitListComponent extends Component
{
    use WithPagination, withDataTable;

    protected $paginationTheme = 'bootstrap';
    public $showEditModal = false;
    public $unit;
    public $state = [];
    protected $queryString = ['searchTerm' => ['except' => '']];

    //public $service_id = '';


    protected $listeners = [
        'delete'
    ];

    public function addNewUnit()
    {
        Gate::authorize('unit-create');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createUnit()
    {
        Gate::authorize('unit-create');
        //dd($this->state);
        try {
            $validatedData = Validator::make($this->state, [
                'unit_name' => 'required|min:3|max:100',
                'unit_code' => 'nullable',
                'serial_no' => 'nullable',
                'service_id' => 'required',
                'division_id' => 'required',
                'is_active' => 'required'
            ])->validate();

            Unit::create([
                'unit_name' => $this->state['unit_name'],
                'unit_code' => $this->state['unit_code'],
                'serial_no' => $this->state['serial_no'],
                'service_id' => $this->state['service_id'],
                'division_id' => $this->state['division_id'],
                'is_active' => $this->state['is_active'],
                'created_by' => auth()->user()->id,
            ]);

            $this->dispatchBrowserEvent('hide-form');
            $this->dispatchBrowserEvent('toastr-success', ['message' => 'Unit Created Successfully']);
            return redirect()->back();
        } catch (\Exception $e) {
            throw $e;
            //$this->dispatchBrowserEvent('toastr-error', ['message' => $e->getMessage()]);
            //return redirect()->back();
            //report($e);

            //return false;
        }
    }

    public function editUnit(Unit $unit)
    {
        Gate::authorize('unit-update');
        $this->unit = $unit;
        $this->state = $unit->toArray();
        $this->showEditModal = true;
        $this->dispatchBrowserEvent('show-form');
    }

    public function updateUnit()
    {
        try {
            $validatedData = Validator::make($this->state, [
                'unit_name' => 'required|min:3|max:100',
                'unit_code' => 'nullable',
                'serial_no' => 'nullable',
                'service_id' => 'required',
                'division_id' => 'required',
                'is_active' => 'nullable'
            ])->validate();

            $this->unit->update([
                'unit_name' => $this->state['unit_name'],
                'unit_code' => $this->state['unit_code'],
                'serial_no' => $this->state['serial_no'],
                'service_id' => $this->state['service_id'],
                'division_id' => $this->state['division_id'],
                'is_active' => $this->state['is_active'],
                'updated_by' => auth()->user()->id,
            ]);

            $this->dispatchBrowserEvent('hide-form');
            $this->dispatchBrowserEvent('toastr-success', ['message' => 'Unit Updated Successfully']);
            return redirect()->back();
        } catch (\Exception $e) {
            throw $e;
            //$this->dispatchBrowserEvent('toastr-error', ['message' => $e->getMessage()]);
            //return redirect()->back();
            //report($e);

            //return false;
        }
    }

    public function deleteConfirm($id)
    {
        Gate::authorize('unit-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Gate::authorize('unit-delete');
        Unit::findOrFail($id)->delete();
    }

    public function updatedsearchTerm()
    {
        $this->resetPage();
    }

    public function render()
    {
        Gate::authorize('unit-index');
        $units = Unit::query()
            ->with('division', 'service')
            ->where('unit_name', 'like', '%' . $this->searchTerm . '%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        //dd($units);
        $services = Service::select('id', 'service_name')->active()->get();
        //dd($services);
        //$services = Service::active()->get();
        $divisions = Division::select('id', 'division_name')->active()->get();
        //$divisions = Division::active()->get();
        return view('livewire.backend.unit.unit-list-component', [
            'units' => $units,
            'services' => $services,
            'divisions' => $divisions
        ]);
    }
}
