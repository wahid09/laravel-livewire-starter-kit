<?php

namespace App\Http\Livewire\ApplicationSetup\ItemDepartment;

use App\Models\ItemDepartment;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Traits\withDataTable;

class ItemDepartmentListComponent extends Component
{
    use WithPagination, withDataTable;

    protected $paginationTheme = 'bootstrap';
    public $showEditModal = false;
    public $itemDepartment;
    public $state = [];
    protected $queryString = ['searchTerm' => ['except' => '']];


    protected $listeners = [
        'delete'
    ];

    public function addNewItemDepartment()
    {
        Gate::authorize('item-department-create');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createItemDepartment()
    {
        Gate::authorize('item-department-create');
        $validatedData = Validator::make($this->state, [
            'department_name' => 'required|min:3|unique:item_departments,department_name',
            'is_active' => 'required'
        ])->validate();

        ItemDepartment::create([
            'department_name' => $this->state['department_name'],
            'is_active' => $this->state['is_active'],
            'created_by' => auth()->user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Item Department Created Successfully']);
        return redirect()->back();
    }
    public function editItemDepartment(ItemDepartment $itemDepartment){
        Gate::authorize('item-department-update');
        $this->itemDepartment = $itemDepartment;
        $this->state = $itemDepartment->toArray();
        $this->showEditModal = true;
        $this->dispatchBrowserEvent('show-form');
    }
    public function updateItemDepartment(){
        Gate::authorize('item-department-update');
        $validatedData = Validator::make($this->state, [
            'department_name' => 'required|min:3|unique:item_departments,department_name,' . $this->itemDepartment->id,
            'is_active' => 'nullable'
        ])->validate();

        $this->itemDepartment->update([
            'department_name' => $this->state['department_name'],
            'is_active' => $this->state['is_active'],
            'updated_by' => auth()->user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Item Department Updated Successfully']);
        return redirect()->back();
    }

    public function deleteConfirm($id)
    {
        Gate::authorize('item-department-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Gate::authorize('item-department-delete');
        ItemDepartment::findOrFail($id)->delete();
    }

    public function render()
    {
        Gate::authorize('item-department-index');
        $departments = ItemDepartment::query()
            ->where('department_name', 'like', '%' . $this->searchTerm . '%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.application-setup.item-department.item-department-list-component', [
            'departments' => $departments
        ]);
    }
}
