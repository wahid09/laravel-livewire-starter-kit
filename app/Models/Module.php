<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
    public function parent()
    {
        return $this->hasOne('App\Models\Module', 'id', 'parent_id')->orderBy('sort_order');
    }
    
    public function children()
    {
    
        return $this->hasMany('App\Models\Module', 'parent_id', 'id')->orderBy('sort_order');
    }
    public static function tree()
    {
        return static::with(implode('.', array_fill(0, 100, 'children')))->where('parent_id', '=', '0')->orderBy('sort_order')->get();
    }
}
