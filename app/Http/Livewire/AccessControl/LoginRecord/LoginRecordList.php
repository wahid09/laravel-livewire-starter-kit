<?php

namespace App\Http\Livewire\AccessControl\LoginRecord;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Traits\withDataTable;

class LoginRecordList extends Component
{
    use WithPagination, withDataTable;

    protected $paginationTheme = 'bootstrap';
    public $searchTerm = null;
    public function render()
    {
        if(Auth::user()->role_id == 1){
            $loginLogs = DB::table('authentication_log')
                            ->where('ip_address', 'like', '%' . $this->searchTerm . '%')
                            ->orderBy('login_at', 'desc')
                            ->paginate($this->perPage);
        }else{
            $loginLogs = User::find(Auth::user()->id)->authentications()
                            ->where('ip_address', 'like', '%' . $this->searchTerm . '%')
                            ->paginate($this->perPage);
        }
        //dd($loginLogs);
        return view('livewire.access-control.login-record.login-record-list', [
            'loginLogs' => $loginLogs
        ]);
    }
}
