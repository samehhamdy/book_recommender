<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookUser extends Model
{
    protected $table = 'book_user';

    protected $fillable = ['start_page', 'end_page', 'type', 'user_id', 'book_id'];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
