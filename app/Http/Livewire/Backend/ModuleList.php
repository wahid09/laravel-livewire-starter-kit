<?php

namespace App\Http\Livewire\Backend;

use App\Models\Module;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ModuleList extends Component
{
    use WithPagination;

    public $showEditModal = false;
    protected $paginationTheme = 'bootstrap';
    public $searchTerm = null;
    public $showMore = 0;
    public $module;
    public $state = [];

    public function addNew(){
        Gate::authorize('module-create');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }
    public function editModule(Module $module){
        Gate::authorize('module-update');
        $this->module = $module;
        $this->state = $module->toArray();
        $this->dispatchBrowserEvent('show-form');
    }
    public function open($id){
        $this->showMore = $id;
    }
    public function close($id){
        $this->showMore = 0;
    }
    public function updated($field){
        $this->validateOnly($field, [
            'state.name' => 'required|min:3|max:255|string|unique:modules,name',
            'state.sort_order' => 'required|unique:modules,sort_order',
        ]);
    }
    public function createModule(){
        $data = Validator::make($this->state, [
            'name' => 'required|min:3|max:255|string|unique:modules,name',
            'sort_order' => 'required|unique:modules,sort_order',
            'url' => 'sometimes',
            'icon' => 'sometimes',
            'is_active' => 'sometimes'
        ])->validate();

        Module::create($data);
        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message'=> 'User Added Successfully']);
        return redirect()->back();
    }

    public function render()
    {
        Gate::authorize('module-index');
        $modules = Module::with('children')->where('parent_id', 0)->paginate(10);
        return view('livewire.backend.module-list', [
            'modules' => $modules
        ]);
    }
}
