<?php

namespace App\Http\Livewire\ApplicationSetup\ItemGroup;

use App\Models\ItemGroup;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Traits\withDataTable;

class ItemGroupListComponent extends Component
{
    use WithPagination, withDataTable;

    protected $paginationTheme = 'bootstrap';
    public $showEditModal = false;
    public $itemGroup;
    public $state = [];
    protected $queryString = ['searchTerm' => ['except' => '']];


    protected $listeners = [
        'delete'
    ];

    public function addNewItemGroup()
    {
        Gate::authorize('item-group-create');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createItemGroup()
    {
        Gate::authorize('item-group-create');
        $validatedData = Validator::make($this->state, [
            'group_name' => 'required|min:2|max:100|unique:item_groups,group_name',
            'group_code' => 'nullable|min:1|unique:item_groups,group_code',
            'is_active' => 'required'
        ])->validate();
        ItemGroup::create([
            'group_name' => $this->state['group_name'],
            'group_code' => $this->state['group_code'],
            'is_active' => $this->state['is_active'],
            'created_by' => auth()->user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Item Group Created Successfully']);
        return redirect()->back();
    }

    public function editItemGroup(ItemGroup $itemGroup)
    {
        Gate::authorize('item-group-update');
        $this->itemGroup = $itemGroup;
        $this->state = $itemGroup->toArray();
        $this->showEditModal = true;
        $this->dispatchBrowserEvent('show-form');
    }

    public function updateItemGroup()
    {
        Gate::authorize('item-group-update');
        $validatedData = Validator::make($this->state, [
            'group_name' => 'required|min:2|max:100|unique:item_groups,group_name,' . $this->itemGroup->id,
            'group_code' => 'nullable|min:1|unique:item_groups,group_code,' . $this->itemGroup->id,
            'is_active' => 'required'
        ])->validate();
        $this->itemGroup->update([
            'group_name' => $this->state['group_name'],
            'group_code' => $this->state['group_code'],
            'is_active' => $this->state['is_active'],
            'created_by' => auth()->user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Item Group Updated Successfully']);
        return redirect()->back();
    }

    public function deleteConfirm($id)
    {
        Gate::authorize('item-group-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Gate::authorize('item-group-delete');
        ItemGroup::findOrFail($id)->delete();
    }

    public function render()
    {
        Gate::authorize('item-group-index');
        $itemGroups = ItemGroup::query()
            ->where('group_name', 'like', '%' . $this->searchTerm . '%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.application-setup.item-group.item-group-list-component', [
            'itemGroups' => $itemGroups
        ]);
    }
}
