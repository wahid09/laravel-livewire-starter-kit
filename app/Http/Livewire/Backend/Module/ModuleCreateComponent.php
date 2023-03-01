<?php

namespace App\Http\Livewire\Backend\Module;

use Livewire\Component;
use App\Models\Module;

class ModuleCreateComponent extends Component
{
    public function render()
    {
        $modules = Module::latest()
                   ->where('parent_id', 0)
                   ->paginate(10);
        return view('livewire.backend.module.module-create-component', [
            'modules'=> $modules
        ]);
    }
}
