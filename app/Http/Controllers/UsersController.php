<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;


class UsersController extends Controller
{


    /**
     *user詳細表示
     *
     * @param  User  $user
     * @param  Tweet  $tweet
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user,Tweet $tweet,Request $request){

        $login_user = Auth()->user();
        $lists = $tweet->getUserTweet($user->id);
        $tweet_count = $tweet->getTweetCount($user->id);

        $lists = new LengthAwarePaginator(
            $lists,
        count(Tweet::all()),
            5,
            $request->page,
            array('path' => $request->url())
        );

        return view('users.show',[
            'user' => $user,
            'name' => $user->name,
            'screen_name' => $user->screen_name,
            'profile_image' => Storage::disk('s3')->url($user->profile_image ? $user->profile_image : 'noimage.jpg'),
            'login_user' => $login_user,
            'tweet_count' => $tweet_count,
            'lists' => $lists
        ]);

    }
}