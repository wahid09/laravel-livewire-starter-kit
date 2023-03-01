<?php

namespace App\Http\Livewire\Backend\User;

use App\Models\Rank;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AddUser extends Component
{

    public $state = [];
    public $user;
    public $role_id = '';
    public $unit_id = '';
    public $rank_id = '';


    public function updated()
    {
        $this->state['role_id'] = $this->role_id;
        $this->state['unit_id'] = $this->unit_id;
        $this->state['rank_id'] = $this->rank_id;
    }

    public function createUser()
    {
        //dd($this->state);
        Gate::authorize('user-create');
        $validatedData = Validator::make($this->state, [
            'role_id' => 'required',
            'unit_id' => 'required',
            'rank_id' => 'required',
            'username' => 'required|min:3|unique:users,username',
            'email' => 'required|email|unique:users',
            'first_name' => 'nullable|string|min:2|max:100',
            'last_name' => 'nullable|string|min:2|max:100',
            'address' => 'nullable|string|min:2|max:255',
            'phone' => 'nullable|string|min:11|max:11|unique:users,phone',
            'is_active' => 'nullable',
            'password' => 'required|confirmed|min:8'
        ])->validate();

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'User Added Successfully']);
        return redirect()->route('app.access-control/users');
    }

    public function render()
    {
        Gate::authorize('user-create');
        $roles = Role::active()->latest()->get();
        return view('livewire.backend.user.add-user', [
            'roles' => $roles
        ]);
    }
}