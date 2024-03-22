<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IntervalRequest;
use App\Models\User;
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
        $user = User::find($data['user_id']);
        $user->intervals()->attach([$data['book_id'] => [
            'start_page' => $data['start_page'],
            'end_page' => $data['end_page'],
        ]]);
        return response()->json(['message' => 'Interval created successfully.']);
    }
}
