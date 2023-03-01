<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }

    public function setCreatedAtAttribute($date)
    {
        $this->attributes['created_at'] = empty($date) ? Carbon::now() : Carbon::parse($date);
    }

    public function setUpdatedAtAttribute($date)
    {
        $this->attributes['updated_at'] = empty($date) ? Carbon::now() : Carbon::parse($date);
    }

    public function setCreatedByAttribute($data)
    {
        $this->attributes['created_by'] = empty($data) ? 1 : $data;
    }
    public function setIsActiveAttribute($data)
    {
        $this->attributes['is_active'] = ($data==true) ? 1 : 0;
    }
}
