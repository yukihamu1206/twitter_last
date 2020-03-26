<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Aws\S3\S3Client;

use Aws\Exception\AwsException;

require 'vendor/autoload.php';


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
        $s3 = new Aws\S3\S3Client([
            'profile' => 'default',
            'version' => 'latest',
            'region' => config('region')

        ]);








//        $s3 = App::make('aws')->createClient('s3');
//        $key = $user->profile_image ? $user->profile_image : 'noimage.jpg';
//        $bucket = env('AWS_BUCKET');
//
//        $profile_image = $s3->getObjectUrl($bucket, $key);
//
//        $lists = new LengthAwarePaginator(
//            $lists,
//            count(Tweet::all()),
//            5,
//            $request->page,
//            array('path' => $request->url())
//        );
//
//        return view('users.show', [
//            'user' => $user,
//            'name' => $user->name,
//            'screen_name' => $user->screen_name,
//            'profile_image' => $profile_image,
//            'login_user' => $login_user,
//            'tweet_count' => $tweet_count,
//            'lists' => $lists
//        ]);

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
