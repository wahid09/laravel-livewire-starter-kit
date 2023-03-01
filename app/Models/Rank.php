<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rank extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany(User::class);
        //return $this->belongsToMany(User::class);
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
