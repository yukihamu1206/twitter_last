<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TweetsController extends Controller
{
    public function create()
    {
        $token = Auth()->user()->api_token;
        return view('tweets.create', ['token' => $token]);
    }

    /**
     * @param  Request  $request
     * @param  Tweet  $tweet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, Tweet $tweet)
    {
        $lists = $tweet->getTimeline();

        $lists = new LengthAwarePaginator(
            $lists,
            count(Tweet::all()),
            5,
            $request->page,
            array('path' => $request->url())
        );

        return view('tweets.index', ['lists' => $lists]);

    }
}
