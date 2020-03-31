<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Services\SdkService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


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
     * ツイート編集
     *
     * @param  Tweet  $tweet
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(Tweet $tweet)
    {

        $user = Auth()->user();
        $tweet_id = $tweet->id;
        $tweet_exist = $tweet->getEditTweet($user->id, $tweet_id);


        $s3 = SdkService::sdkFunc();

        $profile_image = $s3->getObjectUrl(config('app.aws.bucket'),
            $user->profile_image ? $user->profile_image : 'noimage.jpg');

        if (!isset($tweet_exist)) {
            return redirect('/');
        }

        return view('tweets.edit', [
            'user_id' => $user->id,
            'profile_image' => $profile_image,
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
