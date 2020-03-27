<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Aws\S3\S3Client;


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
    public function show(User $user, Tweet $tweet, Request $request)
    {

        $login_user = Auth()->user();
        $lists = $tweet->getUserTweet($user->id);
        $tweet_count = $tweet->getTweetCount($user->id);

//        create a S3Client
        $s3 = new S3Client([
            'version' => 'latest',
            'region' => config('app.region'),
        ]);

        $profile_image = $s3->getObject([
            'Bucket' => config('app.bucket'),
            'Key' => $user->profile_image,
        ]);

        return view('users.show',[
            'login_user' => $login_user,
            'name' => $user->name,
            'screen_name' => $user->screen_name,
            'user_id' => $user->id,
            'lists' => $lists,
            'tweet_count' => $tweet_count,
            'profile_image' => $profile_image
        ]);





    }


    /**
     * ユーザー情報編集
     *
     * @param  User  $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user_id' => $user->id,
            'screen_name' => $user->screen_name,
            'name' => $user->name,
            'email' => $user->email,
            'profile_image' => $user->profile_image
        ]);

    }
}
