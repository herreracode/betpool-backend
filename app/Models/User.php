<?php

namespace App\Models;

use App\Models\Enums\RoleUsers;
use Betpool\Pool\Domain\Pool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    protected $guard_name = 'sanctum';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * get Pools user
     */
    public function pools()
    {
        return $this->belongsToMany(Pool::class, 'users_pools');
    }

    /**
     * get Predictions
     */
    public function predictions()
    {
        return $this->hasMany(Prediction::class);
    }

    public function addRoleUserCreatorByPool(Pool $Pool)
    {
        setPermissionsTeamId($Pool->id);

        $RolePoolAdmin = Role::create([
            'name' => RoleUsers::PoolAdmin
        ]);

        $this->assignRole($RolePoolAdmin);
    }

    public function hasRolePoolAdmin(Pool $Pool):bool
    {
        setPermissionsTeamId($Pool->id);

        $RolePoolAdmin = Role::findByName('_POOL_ADMIN_');

        return $this->hasRole($RolePoolAdmin);
    }
}
