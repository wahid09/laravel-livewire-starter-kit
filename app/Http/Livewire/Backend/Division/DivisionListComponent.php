<?php

namespace App\Http\Livewire\Backend\Division;

use App\Models\Division;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Traits\withDataTable;

class DivisionListComponent extends Component
{
    use WithPagination, withDataTable;

    protected $paginationTheme = 'bootstrap';
    public $showEditModal = false;
    public $division;
    public $state = [];
    protected $queryString = ['searchTerm' => ['except' => '']];


    protected $listeners = [
        'delete'
    ];

    public function addNewDivision()
    {
        Gate::authorize('division-create');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createDivision()
    {
        Gate::authorize('division-create');
        try {
            $validatedData = Validator::make($this->state, [
                'division_name' => 'required|min:3|unique:divisions,division_name',
                'is_active' => 'required'
            ])->validate();

            Division::create([
                'division_name' => $this->state['division_name'],
                'is_active' => $this->state['is_active'],
                'created_by' => auth()->user()->id,
            ]);

            $this->dispatchBrowserEvent('hide-form');
            $this->dispatchBrowserEvent('toastr-success', ['message' => 'Division Created Successfully']);
            return redirect()->back();
        } catch (\Exception $e) {
            //throw $e;
            //$this->dispatchBrowserEvent('toastr-error', ['message' => $e->getMessage()]);
            //return redirect()->back();
            //report($e);

            //return false;
            return $e->getMessage();
        }
    }
    public function editDivision(Division $division){
        Gate::authorize('division-update');
        $this->division = $division;
        $this->state = $division->toArray();
        $this->showEditModal = true;
        $this->dispatchBrowserEvent('show-form');
    }
    public function updateDivision()
    {
        Gate::authorize('division-update');
        try {
            $validatedData = Validator::make($this->state, [
                'division_name' => 'required|min:3|unique:divisions,division_name,' . $this->division->id,
                'is_active' => 'required'
            ])->validate();

            $this->division->update([
                'division_name' => $this->state['division_name'],
                'is_active' => $this->state['is_active'],
                'created_by' => auth()->user()->id,
            ]);

            $this->dispatchBrowserEvent('hide-form');
            $this->dispatchBrowserEvent('toastr-success', ['message' => 'Division Updated Successfully']);
            return redirect()->back();
        } catch (\Exception $e) {
            //throw $e;
            //$this->dispatchBrowserEvent('toastr-error', ['message' => $e->getMessage()]);
            //return redirect()->back();
            //report($e);

            //return false;
            return $e->getMessage();
        }
    }

    public function deleteConfirm($id)
    {
        Gate::authorize('division-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Gate::authorize('division-delete');
        Division::findOrFail($id)->delete();
    }

    public function render()
    {
        Gate::authorize('division-index');
        $divisions = Division::query()
            ->where('division_name', 'like', '%' . $this->searchTerm . '%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.backend.division.division-list-component', [
            'divisions' => $divisions
        ]);
    }
}
