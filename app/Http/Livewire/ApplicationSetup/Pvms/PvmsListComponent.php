<?php

namespace App\Http\Livewire\ApplicationSetup\Pvms;

use App\Models\Pvms;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Traits\withDataTable;

class PvmsListComponent extends Component
{
    use WithPagination, withDataTable;

    protected $paginationTheme = 'bootstrap';
    public $showEditModal = false;
    public $itemType;
    public $state = [];
    protected $queryString = ['searchTerm' => ['except' => '']];


    protected $listeners = [
        'delete'
    ];

    public function deleteConfirm($id)
    {
        Gate::authorize('pvm-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Gate::authorize('pvm-delete');
        Pvms::findOrFail($id)->delete();
    }
    public function updatedsearchTerm(){
        $this->resetPage();
    }
    public function render()
    {
        Gate::authorize('pvm-index');
        //dd($this->searchTerm);
        $pvms = Pvms::query()
            ->with('specification', 'account_unit')
            ->where('pvms', 'like', '%' . $this->searchTerm . '%')
            ->where('nomen_clature', 'like', '%' . $this->searchTerm . '%')
            //->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        //dd($pvms);
        return view('livewire.application-setup.pvms.pvms-list-component', [
            'pvms' => $pvms
        ]);
    }
}
