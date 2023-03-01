<?php

namespace App\Http\Livewire\ApplicationSetup\Pvms;

use App\Models\AccountUnit;
use App\Models\ItemDepartment;
use App\Models\ItemGroup;
use App\Models\ItemSection;
use App\Models\ItemType;
use App\Models\Pvms;
use App\Models\Specification;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class PvmsCreateComponent extends Component
{
    public $state = [];
    public $specification_id = '';
    public $item_section_id = '';
    public $account_unit_id = '';
    public $item_group_id = '';
    public $item_type_id = '';
    public $item_department_id = '';

    public function updated(){
        $this->state['specification_id'] = $this->specification_id;
        $this->state['item_section_id'] = $this->item_section_id;
        $this->state['account_unit_id'] = $this->account_unit_id;
        $this->state['item_group_id'] = $this->item_group_id;
        $this->state['item_type_id'] = $this->item_type_id;
        $this->state['item_department_id'] = $this->item_department_id;
    }
    public function createPvms(){
        Gate::authorize('user-create');
        $validatedData = Validator::make($this->state, [
            'specification_id' => 'required',
            'item_section_id' => 'required',
            'account_unit_id' => 'required',
            'item_group_id' => 'required',
            'item_type_id' => 'required',
            'item_department_id' => 'required',
            'pvms' => 'required|string|min:2|max:100',
            'control_flag' => 'required',
            'nomen_clature' => 'required|string|min:2|max:255',
            'is_active' => 'required'
        ])->validate();
        dd($this->state);
        Pvms::create([
            'specification_id' => $this->state['specification_id'],
            'item_section_id' => $this->state['item_section_id'],
            'account_unit_id' => $this->state['account_unit_id'],
            'item_group_id' => $this->state['item_group_id'],
            'item_type_id' => $this->state['item_type_id'],
            'item_department_id' => $this->state['item_department_id'],
            'pvms' => $this->state['pvms'],
            'old_pvms' => $this->state['old_pvms'] ?? '',
            'control_flag' => $this->state['control_flag'],
            'nomen_clature' => $this->state['nomen_clature'],
            'page_no' => $this->state['page_no'] ?? '',
            'remarks' => $this->state['remarks'] ?? '',
            'is_active' => $this->state['is_active'],
            'warning_amount' => 0,
        ]);
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Pvms Added Successfully']);
        return redirect()->route('app.application-setup/pvms');
    }
    public function render()
    {
        $specifications = Specification::select('id', 'specification_name')->active()->get();
        $itemSections = ItemSection::select('id', 'item_section_name', 'item_section_code')->active()->get();
        $accountUnits = AccountUnit::select('id', 'account_unit_name')->active()->get();
        $itemGroups = ItemGroup::select('id', 'group_name', 'group_code')->active()->get();
        $itemTypes = ItemType::select('id', 'item_type_name')->active()->get();
        $itemDepartment = ItemDepartment::select('id', 'department_name')->active()->get();
        return view('livewire.application-setup.pvms.pvms-create-component', [
            'specifications' => $specifications,
            'itemSections' => $itemSections,
            'accountUnits' => $accountUnits,
            'itemGroups' => $itemGroups,
            'itemTypes' => $itemTypes,
            'itemDepartment' => $itemDepartment
        ]);
    }
}
