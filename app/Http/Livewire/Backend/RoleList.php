<?php

namespace App\Http\Livewire\Backend;

use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoleList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $state=[];
    public $showEditModal = false;
    public $user;
    public $role;
    protected $listeners = [
        'delete'
    ];
    public $searchTerm = null;

    //public $role_id = '';

    // public $series = [
    //     'Wanda Vision',
    //     'Money Heist',
    //     'Lucifer',
    //     'Stranger Things',
    // ];

    

    public function addNew(){
        Gate::authorize('role-create');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }
    public function createRole(){
        Gate::authorize('role-create');
        $validatedData = Validator::make($this->state, [
            'name' => 'required|min:3',
            'is_active' => 'required'
        ])->validate();

        Role::create([
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
            'is_active' => $validatedData['is_active'],
        ]);
        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message'=> 'Role Added Successfully']);
        return redirect()->back();
    }
    public function editRole(Role $role){
        Gate::authorize('user-update');
        $this->showEditModal = true;
        $this->role = $role;
        $this->state = $role->toArray();
        $this->dispatchBrowserEvent('show-form');
    }
    public function updateRole(){
        Gate::authorize('user-update');
        $validatedData = Validator::make($this->state, [
            'name' => 'required|min:3',
            'is_active' => 'required'
        ])->validate();

        $this->role->update([
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
            'is_active' => $validatedData['is_active'],
        ]);
        $this->dispatchBrowserEvent('hide-form', ['message'=> 'Role updated Successfully']);
        return redirect()->back();
    }
    public function deleteConfirm($id){
        Gate::authorize('user-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            //'type' => 'warning',
            //'title' => 'Are you Sure?',
            //'text'  => '',
            'id' => $id, 
        ]);
    }
    public function delete($id){
        Gate::authorize('user-delete');
        Role::findOrFail($id)->delete();
    }
    public function render()
    {
        $roles = Role::latest()->paginate();
        return view('livewire.backend.role-list', [
            'roles' => $roles
        ]);
    }
}
