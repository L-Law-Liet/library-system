<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    /**
     * @return BelongsToMany
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    /**
     * @return HasMany
     */
    public function book_authors(): HasMany
    {
        return $this->hasMany(AuthorBook::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
