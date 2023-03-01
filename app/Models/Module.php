<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function parent()
    {
        return $this->hasOne('App\Models\Module', 'id', 'parent_id')->orderBy('sort_order', 'asc');
    }

    public function children()
    {

        return $this->hasMany('App\Models\Module', 'parent_id', 'id')->active()->orderBy('sort_order', 'asc');
    }

    public static function tree()
    {
        return static::with(implode('.', array_fill(0, 100, 'children')))->where('parent_id', '=', '0')->orderBy('sort_order')->get();
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'sort_order', 'is_active'])
            ->setDescriptionForEvent(fn(string $eventName) => "Module model has been {$eventName}")
            ->useLogName('Module');
        // Chain fluent methods for configuration options
    }
}
