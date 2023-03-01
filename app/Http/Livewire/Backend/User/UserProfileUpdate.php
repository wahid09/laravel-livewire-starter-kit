<?php

namespace App\Http\Livewire\Backend\User;

use Livewire\Component;
use App\Models\User;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class UserProfileUpdate extends Component
{
    use WithFileUploads;
    public $user;
    public $state = [];
    public $image;

    public function mount(User $user)
    {
        $this->user = $user;
        //$this->state = $this->user->toArray();
        $this->state = auth()->user()->only(['first_name', 'last_name', 'email', 'phone', 'address']);
    }

    public function updatedImage()
    {
        $previousPath = auth()->user()->avatar;

        $path = $this->image->store('/', 'avatars');

        auth()->user()->update(['avatar' => $path]);

        Storage::disk('avatars')->delete($previousPath);

        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Profile changed successfully!']);
    }

    public function updateProfile()
    {
        $validatedData = Validator::make($this->state, [
            'email' => 'required|unique:users,email,' . $this->user->id,
            'first_name' => 'required|string|min:2|max:100',
            'last_name' => 'nullable|string|min:2|max:100',
            'address' => 'nullable|string|min:2|max:255',
            'phone' => 'nullable|string|min:11|max:11|unique:users,phone,' . $this->user->id
        ])->validate();
        $this->user->update([
            'first_name' => $this->state['first_name'],
            'last_name' => $this->state['last_name'],
            'email' => $this->state['email'],
            'phone' => $this->state['phone'],
            'address' => $this->state['address']
        ]);

        $this->emit('nameChanged', auth()->user()->full_name);
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'User updated Successfully']);
    }

    public function changePassword(UpdatesUserPasswords $updater)
    {
        $updater->update(
            auth()->user(),
            $attributes = Arr::only($this->state, ['current_password', 'password', 'password_confirmation'])
        );

        collect($attributes)->map(fn ($value, $key) => $this->state[$key] = '');

        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Password changed successfully!']);
    }

    public function render()
    {
        $user = User::with('role')->findOrFail($this->user->id);
        //dd(auth()->user()->avatar_url);
        return view('livewire.backend.user.user-profile-update', [
            'user' => $user
        ]);
    }
}