<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Level;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;


    public const ROLE_CUSTOMER = 2;
    public const ROLE_ADMIN = 1;
    public const ROLE_WHOLESALER = 3;

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->can('admin.panel.access');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'details',
        'is_wholesaler',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'current_level' => Level::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the role for the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if user has a specific permission.
     */
    public function hasPermission($permission): bool
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->hasPermission($permission);
    }

    /**
     * Check if user can perform an action (compatible with Laravel Gates).
     */
    public function can($ability, $arguments = []): bool
    {
        return $this->hasPermission($ability);
    }

    /**
     * Check if user has any of the given permissions.
     */
    public function hasAnyPermission($permissions): bool
    {
        return collect($permissions)->contains(function ($permission) {
            return $this->hasPermission($permission);
        });
    }

    /**
     * Check if user has all of the given permissions.
     */
    public function hasAllPermissions($permissions): bool
    {
        return collect($permissions)->every(function ($permission) {
            return $this->hasPermission($permission);
        });
    }

    public function getCurrentLevel(): string
    {
        return $this->current_level->value;
    }

    public function setCurrentLevel(Level $level): void
    {
        $this->current_level = $level;
        $this->save();
    }
    
    public function getNextLevel()
    {
        return match ($this->current_level->value) {
            Level::RETAILER->value => Level::RETAILER->value,
            Level::WHOLESALER_ONE->value => Level::WHOLESALER_TWO->value,
            Level::WHOLESALER_TWO->value => Level::DISTRIBUTOR_ONE->value,
            Level::DISTRIBUTOR_ONE->value => Level::DISTRIBUTOR_TWO->value,
            Level::DISTRIBUTOR_TWO->value => Level::DISTRIBUTOR_TWO->value,
        };
    }

    public function getPreviousLevel()
    {
        return match ($this->current_level->value) {
            Level::RETAILER->value => Level::RETAILER->value,
            Level::WHOLESALER_ONE->value => Level::WHOLESALER_ONE->value,
            Level::WHOLESALER_TWO->value => Level::WHOLESALER_ONE->value,
            Level::DISTRIBUTOR_ONE->value => Level::WHOLESALER_TWO->value,
            Level::DISTRIBUTOR_TWO->value => Level::DISTRIBUTOR_ONE->value,
        };
    }

    public function promoteToNextLevel(): void
    {
        $this->current_level = $this->getNextLevel();
        $this->save();
    }

    public function demoteToPreviousLevel(): void
    {
        $this->current_level = $this->getPreviousLevel();
        $this->save();
    }

    public function isAtMaxLevel(): bool
    {
        return $this->current_level === Level::DISTRIBUTOR_TWO;
    }

    public function isAtMinLevel(): bool
    {
        if($this->is_wholesaler){
            return $this->current_level === Level::WHOLESALER_ONE;
        }else{
            return $this->current_level === Level::RETAILER;
        }
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role && $this->role->isAdmin();
    }

    /**
     * Check if user is wholesaler.
     */
    public function isWholesaler(): bool
    {
        return $this->role_id === self::ROLE_WHOLESALER;
    }

    /**
     * Check if user is retailer.
     */
    public function isRetailer(): bool
    {
        return $this->role_id === self::ROLE_CUSTOMER;
    }

    /**
     * Get all permissions for the user.
     */
    public function getAllPermissions(): \Illuminate\Database\Eloquent\Collection
    {
        if (!$this->role) {
            return collect();
        }

        return $this->role->permissions;
    }

    public function firstName()
    {
        return explode(' ', $this->name)[0];
    }

    public function lastName()
    {
        return explode(' ', $this->name)[1];
    }

    public function audioBooks()
    {
        return $this->belongsToMany(AudioBook::class, 'audio_book_user')->withTimestamps()->withPivot('unlocked_at');
    }

    public function incrementAudioBookDownloadCount($audioBookId, $file)
    {
        $pivot = $this->audioBooks()->where('audio_book_id', $audioBookId)->first()?->pivot;
        if (!$pivot) return 0;
        $counts = $pivot->download_count ? json_decode($pivot->download_count, true) : [];
        $counts[$file] = ($counts[$file] ?? 0) + 1;
        $pivot->download_count = json_encode($counts);
        $pivot->save();
        return $counts[$file];
    }

    public function getAudioBookDownloadCount($audioBookId, $file)
    {
        $pivot = $this->audioBooks()->where('audio_book_id', $audioBookId)->first()?->pivot;
        if (!$pivot) return 0;
        $counts = $pivot->download_count ? json_decode($pivot->download_count, true) : [];
        return $counts[$file] ?? 0;
    }

    /**
     * Check if user has access to a specific audiobook
     * 
     * @param int $audioBookId
     * @return bool
     */
    public function hasAudioBookAccess($audioBookId): bool
    {
        return $this->audioBooks()->where('audio_book_id', $audioBookId)->exists();
    }

    /**
     * Get all audiobooks the user has access to
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAccessibleAudioBooks()
    {
        return $this->audioBooks()->with('products')->get();
    }
}
