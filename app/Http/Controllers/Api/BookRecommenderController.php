<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\JsonResponse;

/**
 *
 * Class BookRecommenderController
 * @package App\Http\Controllers\Api
 */
class BookRecommenderController extends Controller
{
    /**
     * Calculate the most recommended five books
     *
     * @return JsonResponse
     */
    public function __invoke()
    {
        $recommendedBooks = Book::ofTopRecommended()->limit(5)->get();
        return response()->json($recommendedBooks);
    }
}
