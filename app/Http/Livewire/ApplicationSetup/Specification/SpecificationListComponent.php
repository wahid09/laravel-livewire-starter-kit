<?php

namespace App\Http\Livewire\ApplicationSetup\Specification;

use App\Models\Specification;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Traits\withDataTable;

class SpecificationListComponent extends Component
{
    use WithPagination, withDataTable;

    protected $paginationTheme = 'bootstrap';
    public $showEditModal = false;
    public $specification;
    public $state = [];
    protected $queryString = ['searchTerm' => ['except' => '']];


    protected $listeners = [
        'delete'
    ];

    public function addNewSpecification()
    {
        Gate::authorize('specification-create');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createSpecification()
    {
        Gate::authorize('specification-create');
        $validatedData = Validator::make($this->state, [
            'specification_name' => 'required|min:2|max:100',
            'is_active' => 'required'
        ])->validate();

        Specification::create([
            'specification_name' => $this->state['specification_name'],
            'is_active' => $this->state['is_active'],
            'created_by' => auth()->user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Specification Created Successfully']);
        return redirect()->back();
    }

    public function editSpecification(Specification $specification)
    {
        Gate::authorize('specification-update');
        $this->specification = $specification;
        $this->state = $specification->toArray();
        $this->showEditModal = true;
        $this->dispatchBrowserEvent('show-form');
    }

    public function updateSpecification()
    {
        Gate::authorize('specification-update');
        $validatedData = Validator::make($this->state, [
            'specification_name' => 'required|min:2|max:100',
            'is_active' => 'nullable'
        ])->validate();

        $this->specification->update([
            'specification_name' => $this->state['specification_name'],
            'is_active' => $this->state['is_active'],
            'updated_by' => auth()->user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Specification Updated Successfully']);
        return redirect()->back();
    }

    public function deleteConfirm($id)
    {
        Gate::authorize('specification-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Gate::authorize('specification-delete');
        Specification::findOrFail($id)->delete();
    }

    public function render()
    {
        Gate::authorize('specification-index');
        $specifications = Specification::query()
            ->where('specification_name', 'like', '%' . $this->searchTerm . '%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.application-setup.specification.specification-list-component', [
            'specifications' => $specifications
        ]);
    }
}
