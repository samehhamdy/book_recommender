<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'pages'];

    public function intervals(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps()
            ->withPivot('start_page', 'end_page', 'type');
    }

    public function uniqueReads(): HasMany
    {
        return $this->hasMany(BookUser::class)->whereNull('user_id');
    }

    public function previousUniqueReadRange($start, $end): HasMany
    {
        return $this->uniqueReads()
            ->where(function ($query) use ($start, $end) {
                $query->where('start_page', '<=', $start)
                    ->where('end_page', '>=', $start)
                    ->orWhere(function ($query) use ($start, $end) {
                        $query->where('start_page', '<=', $end)
                            ->where('end_page', '>=', $end);
                    });
            });
    }

    public function previousUniqueReadToBeIncluded($start, $end): HasMany
    {
        return $this->uniqueReads()
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_page', [$start, $end])
                    ->orWhereBetween('end_page', [$start, $end]);
            });
    }

    /**
     * Get the top recommended books
     *
     * based on the number of unique pages that users have read
     *
     * @param $query
     * @return mixed
     */
    public function scopeOfTopRecommended($query): mixed
    {
        return $query->join('book_user as bu', 'books.id', '=', 'bu.book_id')
            ->select('books.id as book_id', 'books.name as book_name', DB::raw('SUM(IF(bu.start_page = 1, bu.end_page - bu.start_page + 1, bu.end_page - bu.start_page)) as num_of_read_pages'))
            ->whereNull('bu.user_id')
            ->groupBy('books.id', 'books.name')
            ->orderByDesc('num_of_read_pages');
    }



}
