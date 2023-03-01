<?php

namespace App\Http\Livewire\Backend\Module;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ModuleList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $showMore = 0;
    public $showEditModal = false;
    public $subModule = false;
    public $searchTerm = null;
    public $state = [];
    public $module;

    protected $listeners = [
        'delete'
    ];

    public function open($id)
    {
        $this->showMore = $id;
    }

    public function close($id)
    {
        $this->showMore = 0;
    }

    public function addNewModule()
    {
        Gate::authorize('module-create');
        $this->state = [];
        $this->subModule = false;
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function editModule(Module $module)
    {
        Gate::authorize('module-update');
        $this->module = $module;
        $this->state = $module->toArray();
        $this->showEditModal = true;
        $this->dispatchBrowserEvent('show-form');
    }

    public function addNewSubModule(Module $module)
    {
        Gate::authorize('module-create');
        $this->module = $module;
        $this->subModule = true;
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createSubModule()
    {
        dd("submodule here");
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'state.name' => 'required|min:3|max:255|unique:modules,name',
            'state.sort_order' => 'required|unique:modules,sort_order',
        ]);
    }

    public function createModule()
    {
        Gate::authorize('module-create');
        $validatedData = Validator::make($this->state, [
            'name' => 'required|min:3|max:255|unique:modules,name',
            'sort_order' => 'required|unique:modules,sort_order',
            'is_active' => 'required',
            'url' => 'required',
            'icon' => 'required',
        ])->validate();

        if ($this->subModule && $this->module) {
            DB::beginTransaction();
            try {

                $subModule = Module::create([
                    'name' => $this->state['name'],
                    'parent_id' => $this->module->id,
                    'slug' => Str::slug(Str::singular($this->state['name'])),
                    'sort_order' => $this->state['sort_order'],
                    'is_active' => $this->state['is_active'],
                    'url' => $this->state['url'],
                    'icon' => $this->state['icon']
                ]);
                $this->permission_automation($subModule->id, Str::singular($subModule->name));
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } else {
            DB::beginTransaction();
            try {
                $module = Module::create([
                    'name' => $this->state['name'],
                    'slug' => Str::slug(Str::singular($this->state['name'])),
                    'sort_order' => $this->state['sort_order'],
                    'is_active' => $this->state['is_active'],
                    'url' => $this->state['url'],
                    'icon' => $this->state['icon']
                ]);
                $this->single_permission($module->id, Str::singular($module->name));
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Module Added Successfully']);
        return redirect()->back();
    }

    public function updateModule()
    {
        Gate::authorize('module-update');
        $validatedData = Validator::make($this->state, [
            'name' => 'required|min:3|max:255|unique:modules,name,' . $this->module->id,
            'sort_order' => 'required|unique:modules,sort_order,' . $this->module->id,
            'is_active' => 'required',
            'url' => 'required',
            'icon' => 'required',
        ])->validate();
        if ($this->module->parent_id && $this->module->parent_id != 0) {
            DB::beginTransaction();
            try {
                $module = $this->module->update([
                    'parent_id' => $this->module->parent_id,
                    'name' => $this->state['name'],
                    'slug' => Str::slug(Str::singular($this->state['name'])),
                    'sort_order' => $this->state['sort_order'],
                    'is_active' => $this->state['is_active'],
                    'url' => $this->state['url'],
                    'icon' => $this->state['icon']
                ]);
                $this->update_permission_automation($this->module->id, $this->module->name);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } else {
            DB::beginTransaction();
            try {
                $module = $this->module->update([
                    'name' => $this->state['name'],
                    'slug' => Str::slug(Str::singular($this->state['name'])),
                    'sort_order' => $this->state['sort_order'],
                    'is_active' => $this->state['is_active'],
                    'url' => $this->state['url'],
                    'icon' => $this->state['icon']
                ]);
                $this->update_single_permission($this->module->id, $this->module->name);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('toastr-success', ['message' => 'Module updated Successfully']);
        return redirect()->back();
    }

    public function deleteConfirm($id)
    {
        Gate::authorize('module-delete');
        $this->dispatchBrowserEvent('delete-confirm', [
            'id' => $id,
        ]);
    }

    public function delete($id)
    {
        Gate::authorize('module-delete');
        $module = Module::findOrFail($id);
        if ($module->permissions()->count()) {
            $this->dispatchBrowserEvent('toastr-success', ['message' => "Can't delete, Module has permission record."]);
            return redirect()->back();
        }
        Module::findOrFail($id)->delete();
    }

    public function permission_automation($module_id, $module_name)
    {
        $prefix = ['index', 'create', 'update', 'delete'];
        for ($i = 0; $i < count($prefix); $i++) {
            $fields = [
                'module_id' => $module_id,
                'name' => str::singular($module_name) . ' ' . $prefix[$i],
                'slug' => str::slug(str::singular($module_name)) . '-' . $prefix[$i]
            ];

            $permissios = Permission::create($fields);
        }

        return $permissios;
    }

    public function single_permission($module_id, $module_name)
    {
        $fields = [
            'module_id' => $module_id,
            'name' => str::singular($module_name) . ' ' . 'Index',
            'slug' => str::slug(str::singular($module_name)) . '-' . 'index'
        ];
        $permissios = Permission::create($fields);
    }

    public function update_permission_automation($module_id, $module_name)
    {
        $prefix = ['index', 'create', 'update', 'delete'];
        $permissions_id = DB::table('permissions')
            ->select('id')
            ->where('module_id', $module_id)
            ->get();
        $id = json_decode(json_encode($permissions_id), true);

        for ($i = 0; $i < count($prefix); $i++) {
            $permission = Permission::findOrFail($id[$i]);

            $fields = [
                'module_id' => $module_id,
                'name' => str::singular($module_name) . ' ' . $prefix[$i],
                'slug' => str::slug(str::singular($module_name)) . '-' . $prefix[$i]
            ];

            DB::table('permissions')->where('id', $id[$i])->update($fields);
        }

        //return $permissios;
    }

    public function update_single_permission($module_id, $module_name)
    {
        $permissions_id = DB::table('permissions')
            ->select('id')
            ->where('module_id', $module_id)
            ->first();
        //dd($permissions_id);
        $fields = [
            'module_id' => $module_id,
            'name' => str::singular($module_name) . ' ' . 'Index',
            'slug' => str::slug(str::singular($module_name)) . '-' . 'index'
        ];
        DB::table('permissions')->where('id', $permissions_id->id)->update($fields);
    }

    public function render()
    {
        Gate::authorize('module-index');
        //DB::connection()->enableQueryLog();
//        $modules = Cache::remember('modules', 60*60*24, function (){
//            return Module::with('children')->latest()
//                   ->where('parent_id', 0)
//                   //->paginate(10);
//            ->get();
//        });
        $modules = Module::with('children')->latest()
            ->where('parent_id', 0)
            ->paginate(10);
        return view('livewire.backend.module.module-list', [
            'modules' => $modules
        ]);
    }
}
