<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;

class BookRecommenderController extends Controller
{
    public function __invoke()
    {
        $recommendedBooks = Book::ofTopRecommended(auth()->id())->limit(5)->get();
        return response()->json($recommendedBooks);
    }
}
