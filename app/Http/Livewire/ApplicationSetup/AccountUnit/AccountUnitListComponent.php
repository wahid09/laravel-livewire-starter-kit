<?php

namespace App\Http\Livewire\ApplicationSetup\AccountUnit;

use App\Models\AccountUnit;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Traits\withDataTable;

class AccountUnitListComponent extends Component
{
    use WithPagination, withDataTable;

    protected $paginationTheme = 'bootstrap';
    public $showEditModal = false;
    public $accountUnit;
    public $state = [];
    protected $queryString = ['searchTerm' => ['except' => '']];


    protected $listeners = [
        'delete'
    ];

    public function addNewAccountUnit()
    {
        Gate::authorize('account-unit-create');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createAccountUnit()
    {
        $validatedData = Validator::make($this->state, [
            'account_unit_name' => 'required|min:2|max:100',
            'is_active' => 'required'
        ])->validate();
        AccountUnit::create([
            'account_unit_name' => $this->state['account_unit_name'],
            'is_active' => $this->state['is_active'],
            'created_by' => auth()->user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Account Unit Created Successfully']);
        return redirect()->back();
    }

    public function editAccountUnit(AccountUnit $accountUnit)
    {
        Gate::authorize('account-unit-update');
        $this->accountUnit = $accountUnit;
        $this->state = $accountUnit->toArray();
        $this->showEditModal = true;
        $this->dispatchBrowserEvent('show-form');
    }

    public function updateAccountUnit()
    {
        $validatedData = Validator::make($this->state, [
            'account_unit_name' => 'required|min:2|max:100',
            'is_active' => 'nullable'
        ])->validate();
        $this->accountUnit->update([
            'account_unit_name' => $this->state['account_unit_name'],
            'is_active' => $this->state['is_active'],
            'updated_by' => auth()->user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Account Unit Updated Successfully']);
        return redirect()->back();
    }

    public function deleteConfirm($id)
    {
        Gate::authorize('account-unit-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Gate::authorize('item-type-delete');
        AccountUnit::findOrFail($id)->delete();
    }

    public function render()
    {
        Gate::authorize('account-unit-index');
        $accountUnits = AccountUnit::query()
            ->where('account_unit_name', 'like', '%' . $this->searchTerm . '%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.application-setup.account-unit.account-unit-list-component', [
            'accountUnits' => $accountUnits
        ]);
    }
}
