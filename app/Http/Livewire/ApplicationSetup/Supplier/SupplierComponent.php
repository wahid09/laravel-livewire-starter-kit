<?php

namespace App\Http\Livewire\ApplicationSetup\Supplier;

use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Traits\withDataTable;

class SupplierComponent extends Component
{
    use WithPagination, withDataTable;

    protected $paginationTheme = 'bootstrap';
    public $showEditModal = false;
    public $supplier;
    public $state = [];
    protected $queryString = ['searchTerm' => ['except' => '']];


    protected $listeners = [
        'delete'
    ];

    public function addNewSupplier()
    {
        Gate::authorize('supplier-create');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createSupplier()
    {
        Gate::authorize('supplier-create');
        $validatedData = Validator::make($this->state, [
            'sup_name' => 'required|min:2|max:100',
            'sup_code' => 'nullable|min:1|max:100',
            'address' => 'nullable|min:1|max:1000',
            'contact_no' => 'nullable|integer|min:4',
            'is_active' => 'nullable'
        ])->validate();

        Supplier::create([
            'sup_name' => $this->state['sup_name'],
            'sup_code' => $this->state['sup_code'],
            'address' => $this->state['address'],
            'contact_no' => $this->state['contact_no'],
            'is_active' => $this->state['is_active'],
            'created_by' => Auth::user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Supplier Added Successfully']);
        return redirect()->back();
    }

    public function editSupplier(Supplier $supplier)
    {
        Gate::authorize('supplier-update');
        $this->supplier = $supplier;
        $this->state = $supplier->toArray();
        $this->showEditModal = true;
        $this->dispatchBrowserEvent('show-form');
    }

    public function updateSupplier()
    {
        Gate::authorize('supplier-update');
        $validatedData = Validator::make($this->state, [
            'sup_name' => 'required|min:2|max:100',
            'sup_code' => 'nullable|min:1|max:100',
            'address' => 'nullable|min:1|max:1000',
            'contact_no' => 'nullable|integer|min:4',
            'is_active' => 'nullable'
        ])->validate();
        //dd($this->state);
        $this->supplier->update([
            'sup_name' => $this->state['sup_name'],
            'sup_code' => $this->state['sup_code'],
            'address' => $this->state['address'],
            'contact_no' => $this->state['contact_no'],
            'is_active' => $this->state['is_active'],
            'updated_by' => Auth::user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Supplier Updated Successfully']);
        return redirect()->back();
    }

    public function deleteConfirm($id)
    {
        Gate::authorize('supplier-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Gate::authorize('supplier-delete');
        Supplier::findOrFail($id)->delete();
    }

    public function updatedsearchTerm()
    {
        $this->resetPage();
    }

    public function render()
    {
        Gate::authorize('specification-index');
        $suppliers = Supplier::query()
            ->where('sup_name', 'like', '%' . $this->searchTerm . '%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.application-setup.supplier.supplier-component', [
            'suppliers' => $suppliers
        ]);
    }
}
