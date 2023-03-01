<?php

namespace App\Http\Livewire\Backend\User;

use Livewire\Component;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Unit;
use App\Models\Rank;

class EditUserComponent extends Component
{
    public $state = [];
    public $user;
    public $role_id = '';
    public $unit_id = '';
    public $rank_id = '';

    public function mount(User $user)
    {
        $this->user = $user;
        $this->state = $user->toArray();
    }

    public function updated()
    {
        $this->state['role_id'] = $this->role_id ? $this->role_id : $this->state['role_id'];
        $this->state['unit_id'] = $this->unit_id ? $this->unit_id : $this->state['unit_id'];
        $this->state['rank_id'] = $this->rank_id ? $this->rank_id : $this->state['rank_id'];
    }

    public function updateUser()
    {
        //dd($this->user->email);
        Gate::authorize('user-update');
        try {
            $validatedData = Validator::make($this->state, [
                'role_id' => 'required',
                'unit_id' => 'required',
                'rank_id' => 'required',
                'username' => 'required|min:3|unique:users,username,' . $this->user->id,
                'email' => 'required|unique:users,email,' . $this->user->id,
                'first_name' => 'nullable|string|min:2|max:100',
                'last_name' => 'nullable|string|min:2|max:100',
                'address' => 'nullable|string|min:2|max:255',
                'phone' => 'nullable|string|min:11|max:11|unique:users,phone,' . $this->user->id,
                'status' => 'nullable',
                'password' => 'sometimes|confirmed|min:8'
            ])->validate();

            //dd($validatedData);

            if (!empty($validatedData['password'])) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            }

            $this->user->update($validatedData);
            //$this->dispatchBrowserEvent('hide-form');
            $this->dispatchBrowserEvent('toastr-success', ['message' => 'User Added Successfully']);
            return redirect()->route('app.access-control/users');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function render()
    {
        Gate::authorize('user-update');
        $roles = Role::active()->latest()->get();
        $units = Unit::active()->latest()->get();
        $ranks = Rank::active()->latest()->get();
        return view('livewire.backend.user.edit-user-component', [
            'roles' => $roles,
            'units' => $units,
            'ranks' => $ranks
        ]);
    }
}
