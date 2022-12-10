<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function scopeActive($q){
        return $q->where('is_active', true);
    }
}
