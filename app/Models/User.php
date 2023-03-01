<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\Models\Unit;
use App\Models\Rank;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];

    public function setCreatedAtAttribute($date)
    {
        $this->attributes['created_at'] = empty($date) ? Carbon::now() : Carbon::parse($date);
    }

    public function setUpdatedAtAttribute($date)
    {
        $this->attributes['updated_at'] = empty($date) ? Carbon::now() : Carbon::parse($date);
    }

    //protected $fillable = ['username', 'first_name', 'last_name', 'email'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['username', 'first_name', 'last_name', 'email'])
            ->setDescriptionForEvent(fn (string $eventName) => "User model has been {$eventName}")
            ->useLogName('User');
        // Chain fluent methods for configuration options
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
        //return $this->belongsToMany(Role::class);
    }

    public function hasPermission($permission): bool
    {
        //dd($this->roles());
        return $this->role->permissions()->where('slug', $permission)->first() ? true : false;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    protected $appends = [
        'avatar_url',
        'full_name',
    ];

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar && Storage::disk('avatars')->exists($this->avatar)) {
            return Storage::disk('avatars')->url($this->avatar);
        }

        return asset('images/logo/profile.jpg');
    }

    public function getFullNameAttribute()
    {
        return ucwords("{$this->first_name} {$this->last_name}");
    }
}