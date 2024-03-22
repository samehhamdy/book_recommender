<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'pages'];

    public function intervals(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps()
            ->withPivot('start_page', 'end_page');
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
        return $query->select('ub.book_id', 'books.name as book_name')
            ->selectRaw('IFNULL(
                (
                    SELECT MAX(ub2.end_page) - MIN(ub2.start_page)
                    FROM book_user ub2
                    LEFT JOIN book_user ub3 ON ub3.book_id = ub2.book_id AND ub3.user_id != ub2.user_id
                    WHERE ub2.book_id = ub.book_id
                      AND ub3.start_page <= ub2.end_page
                      AND ub3.end_page >= ub2.start_page
                ),
                IF(MIN(ub.start_page) != 1, SUM(ub.end_page - ub.start_page), SUM(ub.end_page - ub.start_page) + 1)
            ) AS num_of_read_pages')
            ->join('books', 'books.id', '=', 'ub.book_id')
            ->fromSub(function ($query) {
                $query->selectRaw('DISTINCT book_id, start_page, end_page')
                    ->from('book_user');
            }, 'ub')
            ->groupBy('ub.book_id');
    }


}
