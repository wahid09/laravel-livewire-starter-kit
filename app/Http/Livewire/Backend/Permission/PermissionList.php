<?php

namespace App\Http\Livewire\Backend\Permission;

use App\Models\Module;
use App\Models\Permission;
use App\Traits\withDataTable;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class PermissionList extends Component
{
    use WithPagination, withDataTable;

    protected $paginationTheme = 'bootstrap';

    public $showEditModal = false;
    public $state = [];
    public $permission;
    protected $queryString = ['searchTerm' => ['except' => '']];


    protected $listeners = [
        'delete'
    ];


    public function addNewPermission(){
        Gate::authorize('permission-create');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }
    public function createPermission(){
        Gate::authorize('permission-create');
        $validatedData = Validator::make($this->state, [
            'module_id' => 'required',
            'name' => 'required|min:3',
            'is_active' => 'required'
        ])->validate();
        //dd($this->state);
        Permission::create([
            'name' => $this->state['name'],
            'module_id' => $this->state['module_id'],
            'slug' => Str::slug($this->state['name']),
            'is_active' => $this->state['is_active']
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Role Permission Successfully']);
        return redirect()->back();
    }
    public function editPermission(Permission $permission){
        Gate::authorize('permission-update');
        $this->permission = $permission;
        $this->state = $permission->toArray();
        $this->showEditModal = true;
        $this->dispatchBrowserEvent('show-form');
    }
    public function updatePermission(){
        Gate::authorize('permission-update');
        $validatedData = Validator::make($this->state, [
            'module_id' => 'required',
            'name' => 'required|min:3',
            'slug' => 'required|min:3|unique:permissions,slug,'.$this->permission->id,
            'is_active' => 'sometimes'
        ])->validate();
        $this->permission->update([
            'name' => $this->state['name'],
            'module_id' => $this->state['module_id'],
            'slug' => Str::slug($this->state['name']),
            'is_active' => $this->state['is_active']
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Role Updated Successfully']);
        return redirect()->back();
    }
    public function deleteConfirm($id)
    {
        Gate::authorize('permission-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Gate::authorize('permission-delete');
        Permission::findOrFail($id)->delete();
    }
    public function updatedsearchTerm(){
        $this->resetPage();
    }

    public function render()
    {
        Gate::authorize('permission-index');
        $modules = Module::active()->latest()->get();
        $permissions = Permission::query()
            ->where('name', 'like', '%' . $this->searchTerm . '%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.backend.permission.permission-list', [
            'permissions' => $permissions,
            'modules' => $modules
        ]);
    }
}
