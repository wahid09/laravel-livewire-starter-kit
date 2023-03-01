<?php

namespace App\Http\Livewire\Backend\Role;

use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoleCreateComponent extends Component
{
    public $state = [];
    public $name;
    public $is_active;
    public $permissions = [];
    public $initial_permissions = [];

    protected $rules = [
        'name' => 'required|min:3',
        'is_active' => 'required',
    ];
    public function mount(Permission $permissions){
        //$this->initial_permissions = $permissions;
    }


    public function createRole()
    {
        Gate::authorize('role-create');
        $this->validate();
        Role::create([
            'name' => $this->name,
            'slug' => str::slug($this->name),
            'is_active' => $this->is_active
        ])->permissions()->sync($this->permissions);

        //$this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Role Added Successfully']);
        return redirect()->route('app.dev-console/roles');
    }

    public function render()
    {
        Gate::authorize('role-create');
        $modules = Module::with('permissions')->get();
        return view('livewire.backend.role.role-create-component', [
            'modules' => $modules
        ]);
    }
}
