<?php

namespace App\Http\Livewire\Backend\Role;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class AssignPermission extends ModalComponent
{
    public function render()
    {
        return view('livewire.backend.role.assign-permission');
    }
}
