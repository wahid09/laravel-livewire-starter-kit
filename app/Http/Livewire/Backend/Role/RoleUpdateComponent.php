<?php

namespace App\Http\Livewire\Backend\Role;

use App\Models\Role;
use App\Models\Module;
use App\Models\Permission;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class RoleUpdateComponent extends Component
{
    public $state = [];
    public $name;
    public $is_active;
    public $permissions = [];
    public $initial_permissions = [];
    public $role;


    public function mount($role)
    {
        //dd($role->permissions());
        $this->role = Role::with('permissions')->findOrFail($role);
        //$this->role = Module::with('permissions')->get();
        $this->name = $this->role->name;
        $this->is_active = $this->role->is_active;
        //dd($this->role->permissions);
        $ids = [];
        foreach ($this->role->permissions as $item){
            $ids[] = $item['id'];
        }
        //dd($ids);
        //$this->permissions = $this->role->permissions->toArray();
        $this->permissions = $ids;
        //dd($this->permissions = $this->role->permissions);
        //$this->role = $role;
        //$this->state = $this->role->toArray();
    }

    public function updateRole()
    {
        Gate::authorize('role-update');
//        $validatedData = Validator::make($this->state, [
//            'name' => 'required|min:3|unique:roles,name,' . $this->role->id,
//            'slug' => 'required|min:3|unique:roles,slug,' . $this->role->id,
//            'is_active' => 'required',
//        ])->validate();
        //dd($this->state['permissions']);
        //dd($this->permissions);
//        $ids = [];
//        foreach ($this->permissions as $item){
//            $ids[] = $item['id'];
//        }
        //dd($this->permissions);
        $this->role->update([
            'name' => $this->name,
            'slug' => str::slug($this->name),
            'is_active' => $this->is_active
        ]);
        $this->role->permissions()->sync($this->permissions);

        //$this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Role Added Successfully']);
        return redirect()->route('app.dev-console/roles');
    }

    public function render()
    {
        Gate::authorize('role-update');
        $modules = Module::with('permissions')->get();
        return view('livewire.backend.role.role-update-component', [
            'modules' => $modules
        ]);
    }
}
