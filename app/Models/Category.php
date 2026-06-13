<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    // ── Relationship ──────────────────────────────────────────
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // ── Scope ─────────────────────────────────────────────────
    //challenge bab3 - scope untuk memfilter kategori yang aktif saja
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
