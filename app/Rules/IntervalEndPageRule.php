<?php

namespace App\Rules;

use App\Models\Book;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class IntervalEndPageRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $book = Book::find(request('book_id'));
        if (request('end_page') < request('start_page')) {
            $fail('The end page must be greater than or equal to the start page.');
        }
        if ($book->pages < request('end_page')) {
            $fail("The end page can't be greater than the total number of pages in the book.");
        }
    }
}
