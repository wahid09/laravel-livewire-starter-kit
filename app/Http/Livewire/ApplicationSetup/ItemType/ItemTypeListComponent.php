<?php

namespace App\Http\Livewire\ApplicationSetup\ItemType;

use App\Models\ItemType;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Traits\withDataTable;

class ItemTypeListComponent extends Component
{
    use WithPagination, withDataTable;

    protected $paginationTheme = 'bootstrap';
    public $showEditModal = false;
    public $itemType;
    public $state = [];
    protected $queryString = ['searchTerm' => ['except' => '']];


    protected $listeners = [
        'delete'
    ];

    public function addNewItemType()
    {
        Gate::authorize('item-type-create');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createItemType()
    {
        Gate::authorize('item-type-create');
        $validatedData = Validator::make($this->state, [
            'item_type_name' => 'required|min:2|max:100',
            'item_type_code' => 'nullable|min:1|unique:item_types,item_type_code',
            'anx' => 'required|unique:item_types,anx',
            'is_active' => 'required'
        ])->validate();

        ItemType::create([
            'item_type_name' => $this->state['item_type_name'],
            'item_type_code' => $this->state['item_type_code'],
            'anx' => $this->state['anx'],
            'is_active' => $this->state['is_active'],
            'created_by' => auth()->user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Item Type Created Successfully']);
        return redirect()->back();
    }

    public function editItemType(ItemType $itemType)
    {
        Gate::authorize('item-type-update');
        $this->itemType = $itemType;
        $this->state = $itemType->toArray();
        $this->showEditModal = true;
        $this->dispatchBrowserEvent('show-form');
    }

    public function updateItemType()
    {
        Gate::authorize('item-type-update');
        $validatedData = Validator::make($this->state, [
            'item_type_name' => 'required|min:2|max:100',
            'item_type_code' => 'nullable|min:1|unique:item_types,item_type_code,' . $this->itemType->id,
            'anx' => 'required|unique:item_types,anx,' . $this->itemType->id,
            'is_active' => 'required'
        ])->validate();

        $this->itemType->update([
            'item_type_name' => $this->state['item_type_name'],
            'item_type_code' => $this->state['item_type_code'],
            'anx' => $this->state['anx'],
            'is_active' => $this->state['is_active'],
            'updated_by' => auth()->user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Item Type Updated Successfully']);
        return redirect()->back();
    }

    public function deleteConfirm($id)
    {
        Gate::authorize('item-type-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Gate::authorize('item-type-delete');
        ItemType::findOrFail($id)->delete();
    }

    public function render()
    {
        Gate::authorize('item-type-index');
        $itemTypes = ItemType::query()
            ->where('item_type_name', 'like', '%' . $this->searchTerm . '%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.application-setup.item-type.item-type-list-component', [
            'itemTypes' => $itemTypes
        ]);
    }
}
