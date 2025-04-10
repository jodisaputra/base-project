<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Role;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'route',
        'parent_id',
        'order'
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'menu_role');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')
            ->orderBy('order');
    }

    public function allChildren(): HasMany
    {
        return $this->children()->with('allChildren');
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function hasChildren(): bool
    {
        return $this->children()->count() > 0;
    }

    public function isAccessibleBy($user): bool
    {
        return $this->roles->isEmpty() || $user->roles->pluck('id')->intersect($this->roles->pluck('id'))->isNotEmpty();
    }
}
