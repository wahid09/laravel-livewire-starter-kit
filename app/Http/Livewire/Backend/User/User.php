<?php

namespace App\Http\Livewire\Backend\User;

use App\Models\Role;
use App\Traits\withDataTable;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class User extends Component
{
    use WithPagination, withDataTable;

    protected $paginationTheme = 'bootstrap';

    public $state = [];
    public $showEditModal = false;
    public $user;
    protected $listeners = [
        'delete'
    ];
    public $searchTerm = null;
    protected $queryString = ['searchTerm' => ['except' => '']];

    public $selected = '';

    public $invoiceStatuses = [
        'Wanda Vision',
        'Money Heist',
        'Lucifer',
        'Stranger Things',
    ];

    public function createUser()
    {
        Gate::authorize('user-create');
        $validatedData = Validator::make($this->state, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8'
        ])->validate();

        $validatedData['password'] = Hash::make($validatedData['password']);
        ModelsUser::create($validatedData);
        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'User Added Successfully']);
        return redirect()->back();
    }
    public function editUser(ModelsUser $user)
    {
        Gate::authorize('user-update');
        $this->showEditModal = true;
        $this->user = $user;
        $this->state = $user->toArray();


        $this->dispatchBrowserEvent('show-form');
    }
    public function updateUser()
    {
        Gate::authorize('user-update');
        $validatedData = Validator::make($this->state, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'sometimes|confirmed|min:8'
        ])->validate();
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $this->user->update($validatedData);
        $this->dispatchBrowserEvent('hide-form', ['message' => 'User updated Successfully']);
        return redirect()->back();
    }
    public function deleteConfirm($id)
    {
        Gate::authorize('user-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            'id' => $id,
        ]);
    }
    public function delete($id)
    {
        Gate::authorize('user-delete');
        ModelsUser::findOrFail($id)->delete();
    }
    public function render()
    {
        Gate::authorize('user-index');
        $roles = Role::active()->latest()->get();
        $users = ModelsUser::query()
            ->where('first_name', 'like', '%' . $this->searchTerm . '%')
            ->where('email', 'like', '%' . $this->searchTerm . '%')
            ->where('username', 'like', '%' . $this->searchTerm . '%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.backend.user.user', [
            'users' => $users,
            'roles' => $roles
        ]);
    }
}
