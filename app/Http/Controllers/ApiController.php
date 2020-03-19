<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ApiController extends Controller
{

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function post_tweet(Request $request)
    {
        $tweet = new Tweet;
        $tweet->text = $request->tweet;
        $tweet->user_id = Auth()->id();

        $request->validate([
            'tweet' => ['required','max:140']
        ]);

        $tweet->save();

        return response()->json(
            ['tweet' => $tweet],
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}
