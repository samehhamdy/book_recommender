<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'pages'];

    public function intervals(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps()
            ->withPivot('start_page', 'end_page');
    }
}
