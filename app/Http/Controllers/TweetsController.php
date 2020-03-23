<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class TweetsController extends Controller
{
    /**
     *createページを表示する
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $token = Auth()->user()->api_token;
        return view('tweets.create', ['token' => $token]);
    }

    /**
     * タイムラインを表示する
     *
     * @param  Request  $request
     * @param  Tweet  $tweet
     *
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


    /**
     * @param  Tweet  $tweet
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(Tweet $tweet){

        $user = Auth()->user();
        $tweet = $tweet->getEditTweet($user->id, $tweet->id);

        if(!isset($tweet)){
            return redirect('/');
        }

        return view('tweets.edit',[
            'profile_image' => Storage::disk('s3')->url($user->profile_image ? $user->profile_image : 'noimage.jpg'),
            'name' => $user->name,
            'screen_name' => $user->screen_name,
            'api_token' => $user->api_token,
            'text' => $tweet->text,
            'created_at' => $tweet->created_at,
            'tweet_id' => $tweet->id,
            'favorite_count' => $tweet->favorites->count()
        ]);
    }
}
