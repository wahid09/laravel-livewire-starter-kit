<?php

namespace App\Http\Livewire\Backend\Rank;

use App\Models\Rank;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Traits\withDataTable;

class RankListComponent extends Component
{
    use WithPagination, withDataTable;

    protected $paginationTheme = 'bootstrap';

    public $showEditModal = false;
    public $state = [];
    public $rank;
    protected $queryString = ['searchTerm' => ['except' => '']];

    protected $listeners = [
        'delete'
    ];

    public function addNewRank()
    {
        Gate::authorize('rank-create');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }
    public function createRank(){
        $validatedData = Validator::make($this->state, [
            //'rank_name' => 'required|min:3|unique:ranks,rank_name',
            'rank_name'=>'required|min:3|unique:ranks,rank_name,NULL,id,deleted_at,NULL',
            //'rank_short_name' => 'required|min:2|unique:ranks,rank_short_name',
            'rank_short_name'=>'required|min:2|unique:ranks,rank_short_name,NULL,id,deleted_at,NULL',
            'is_active' => 'nullable'
        ])->validate();
        $oderNumber = Rank::max('rank_order');
        Rank::create([
            'rank_name' => $this->state['rank_name'],
            'rank_short_name' => $this->state['rank_short_name'],
            'is_active' => $this->state['is_active'],
            'rank_order' => $oderNumber + 1,
            'created_by' => auth()->user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Rank Created Successfully']);
        return redirect()->back();
    }
    public function editRank(Rank $rank){
        Gate::authorize('rank-update');
        $this->rank = $rank;
        $this->state = $rank->toArray();
        $this->showEditModal = true;
        $this->dispatchBrowserEvent('show-form');
    }
    public function updateRank(){
        $validatedData = Validator::make($this->state, [
            'rank_name' => 'required|min:3|unique:ranks,rank_name,' . $this->rank->id,
            'rank_short_name' => 'required|min:2|unique:ranks,rank_short_name,' . $this->rank->id,
            'is_active' => 'nullable'
        ])->validate();

        $this->rank->update([
            'rank_name' => $this->state['rank_name'],
            'rank_short_name' => $this->state['rank_short_name'],
            'is_active' => $this->state['is_active'],
            'updated_by' => auth()->user()->id,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Rank Updated Successfully']);
        return redirect()->back();
    }

    public function deleteConfirm($id)
    {
        Gate::authorize('rank-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Gate::authorize('rank-delete');
        Rank::findOrFail($id)->delete();
    }

    public function updatedsearchTerm()
    {
        $this->resetPage();
    }

    public function updateRankOrder($items)
    {
        //dd($items);
        foreach ($items as $item) {
            //dd($item['value']);
            Rank::find($item['value'])->update(['rank_order' => $item['order']]);
        }

        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Appointments sorted successfully.']);
    }

    public function render()
    {
        Gate::authorize('rank-index');
        $ranks = Rank::query()
            ->where('rank_name', 'like', '%' . $this->searchTerm . '%')
            ->where('rank_short_name', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('rank_order', 'asc')
            ->paginate($this->perPage);
        return view('livewire.backend.rank.rank-list-component', [
            'ranks' => $ranks
        ]);
    }
}
