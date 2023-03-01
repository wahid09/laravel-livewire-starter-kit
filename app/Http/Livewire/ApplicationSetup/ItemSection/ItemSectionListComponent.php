<?php

namespace App\Http\Livewire\ApplicationSetup\ItemSection;

use App\Models\ItemSection;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Traits\withDataTable;

class ItemSectionListComponent extends Component
{
    use WithPagination, withDataTable;

    protected $paginationTheme = 'bootstrap';
    public $showEditModal = false;
    public $itemSection;
    public $state = [];
    protected $queryString = ['searchTerm' => ['except' => '']];


    protected $listeners = [
        'delete'
    ];
    public function addNewItemSection(){
        Gate::authorize('item-section-create');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }
    public function createItemSection(){
        //dd($this->state);
        Gate::authorize('item-section-create');
        $validatedData = Validator::make($this->state, [
            'item_section_name' => 'required|min:2|max:100',
            'item_section_code' => 'nullable|min:1|unique:item_sections,item_section_code',
            'is_active' => 'required'
        ])->validate();

        ItemSection::create([
            'item_section_name' => $this->state['item_section_name'],
            'item_section_code' => $this->state['item_section_code'] ?? '',
            'is_active' => $this->state['is_active'],
            'created_by' => auth()->user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Item Section Created Successfully']);
        return redirect()->back();
    }
    public function editItemSection(ItemSection $itemSection){
        Gate::authorize('item-section-update');
        $this->itemSection = $itemSection;
        $this->state = $itemSection->toArray();
        $this->showEditModal = true;
        $this->dispatchBrowserEvent('show-form');
    }
    public function updateItemSection(){
        Gate::authorize('item-section-update');
        $validatedData = Validator::make($this->state, [
            'item_section_name' => 'required|min:2|max:100',
            'item_section_code' => 'nullable|min:1|unique:item_sections,item_section_code,' . $this->itemSection->id,
            'is_active' => 'nullable'
        ])->validate();

        $this->itemSection->update([
            'item_section_name' => $this->state['item_section_name'],
            'item_section_code' => $this->state['item_section_code'],
            'is_active' => $this->state['is_active'],
            'updated_by' => auth()->user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Item Section Updated Successfully']);
        return redirect()->back();
    }
    public function deleteConfirm($id)
    {
        Gate::authorize('item-section-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Gate::authorize('item-section-delete');
        ItemSection::findOrFail($id)->delete();
    }
    public function render()
    {
        Gate::authorize('item-section-index');
        $itemSections = ItemSection::query()
            ->where('item_section_name', 'like', '%' . $this->searchTerm . '%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.application-setup.item-section.item-section-list-component', [
            'itemSections' => $itemSections
        ]);
    }
}
