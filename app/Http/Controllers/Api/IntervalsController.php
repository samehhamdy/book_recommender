<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IntervalRequest;
use App\Models\User;

class IntervalsController extends Controller
{
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
