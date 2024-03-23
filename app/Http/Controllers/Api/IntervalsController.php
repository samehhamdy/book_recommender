<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IntervalRequest;
use App\Models\Book;
use App\Models\User;
use App\Notifications\ReadingIntervalNotification;
use Illuminate\Http\JsonResponse;

/**
 *
 * Class IntervalsController
 * @package App\Http\Controllers\Api
 */
class IntervalsController extends Controller
{
    /**
     * submit a user reading interval
     *
     * @bodyParam user_id int required The id of the user. Example: 1
     * @bodyParam book_id int required The id of the book. Example: 1
     * @bodyParam start_page int required The start page of the interval. Example: 1
     * @bodyParam end_page int required The end page of the interval. Example: 10
     *
     * @param IntervalRequest $request
     * @return JsonResponse
     */
    public function __invoke(IntervalRequest $request)
    {
        $data = $request->validated();
        $start = $data['start_page'];
        $end = $data['end_page'];
        $user = User::find($data['user_id']);
        $book = Book::find($data['book_id']);
        $user->intervals()->attach([$data['book_id'] => [
            'start_page' => $start,
            'end_page' => $end
        ]]);
        // get overlapped interval read
        $previousReadRange = $book->previousUniqueReadRange($start, $end)->first();
        if ($previousReadRange) {
            // delete the newly overlapped interval reads
            $book->previousUniqueReadToBeIncluded($start, $end)
                ->where('id','!=', $previousReadRange->id)->delete();
            // update the previous overlapped interval reads
            $book->previousUniqueReadRange($start, $end)->update([
                'start_page' => min($start, $previousReadRange->start_page),
                'end_page' => max($end, $previousReadRange->end_page)
            ]);
        }else {
            // create a new interval read
            $book->uniqueReads()->create([
                'start_page' => $start,
                'end_page' => $end,
            ]);
        }
        $user->notify(new ReadingIntervalNotification());
        return response()->json(['message' => 'Interval created successfully.']);
    }
}
