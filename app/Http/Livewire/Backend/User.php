<?php

namespace App\Http\Livewire\Backend;

use App\Models\User as ModelsUser;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $state=[];
    public $showEditModal = false;
    public $user;
    protected $listeners = ['delete'];
    public $searchTerm = null;

    public function addNew(){
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }
    public function createUser(){
        $validatedData = Validator::make($this->state, [
            'name' => 'required|min:3',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|confirmed|min:8'
        ])->validate();
        
        $validatedData['password'] = Hash::make($validatedData['password']);
        ModelsUser::create($validatedData);
        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message'=> 'User Added Successfully']);
        return redirect()->back();
    }
    public function editUser(ModelsUser $user){
        $this->showEditModal = true;
        $this->user = $user;
        $this->state = $user->toArray();
        $this->dispatchBrowserEvent('show-form');
    }
    public function updateUser(){
        $validatedData = Validator::make($this->state, [
            'name' => 'required|min:3',
            'email'=> 'required|email|unique:users,email,'.$this->user->id,
            'password'=> 'sometimes|confirmed|min:8'
        ])->validate();
        if(!empty($validatedData['password'])){
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $this->user->update($validatedData);
        $this->dispatchBrowserEvent('hide-form', ['message'=> 'User updated Successfully']);
        return redirect()->back();
    }
    public function deleteConfirm($id){
        $this->dispatchBrowserEvent('delete-confirm', [
            //'type' => 'warning',
            //'title' => 'Are you Sure?',
            //'text'  => '',
            'id' => $id, 
        ]);
    }
    public function delete($id){
        ModelsUser::findOrFail($id)->delete();
    }
    public function render()
    {
        //dd($this->searchTerm);
        $users = ModelsUser::query()
                 ->where('name', 'like', '%'.$this->searchTerm.'%')
                 ->where('email', 'like', '%'.$this->searchTerm.'%')
                 ->latest()->paginate(10);
        return view('livewire.backend.user', [
            'users' => $users
        ]);
    }
}
