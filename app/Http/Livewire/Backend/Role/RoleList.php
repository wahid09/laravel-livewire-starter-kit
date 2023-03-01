<?php

namespace App\Http\Livewire\Backend\Role;

use App\Models\Role;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class RoleList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $searchTerm = null;
    public $state = [];
    public $showEditModal = false;
    public $role;

    protected $listeners = [
        'delete'
    ];

    public function addNewRole()
    {
        Gate::authorize('role-create');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createRole()
    {
        Gate::authorize('role-create');
        $validatedData = Validator::make($this->state, [
            'name' => 'required|min:3',
            //'slug' => 'required',
            'deletable' => 'nullable',
            'is_active' => 'nullable'
        ])->validate();

        Role::create([
            'name' => $this->state['name'],
            'slug' => Str::slug($this->state['name']),
            'deletable' => $this->state['deletable'],
            'is_active' => $this->state['is_active']
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Role Added Successfully']);
        return redirect()->back();
    }

    public function editRole(Role $role)
    {
        Gate::authorize('role-update');
        $this->role = $role;
        $this->state = $role->toArray();
        $this->showEditModal = true;
        $this->dispatchBrowserEvent('show-form');
    }

    public function updateRole()
    {
        Gate::authorize('role-update');
        $validatedData = Validator::make($this->state, [
            'name' => 'required|min:3',
            //'slug' => 'required',
            'deletable' => 'nullable',
            'is_active' => 'nullable'
        ])->validate();

        $this->role->update([
            'name' => $this->state['name'],
            'slug' => Str::slug($this->state['name']),
            'deletable' => $this->state['deletable'],
            'is_active' => $this->state['is_active']
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Role Updated Successfully']);
        return redirect()->back();
    }

    public function deleteConfirm($id)
    {
        Gate::authorize('role-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Gate::authorize('role-delete');
        Role::findOrFail($id)->delete();
    }

    public function render()
    {
        Gate::authorize('role-index');
        $roles = Role::query()
            ->withCount('permissions')
            ->where('name', 'like', '%' . $this->searchTerm . '%')
            ->latest()->paginate(10);
        return view('livewire.backend.role.role-list', [
            'roles' => $roles
        ]);
    }
}
