<?php

namespace App\Http\Controllers;

use App\Services\SdkService;
use App\Http\Requests\UserRequest;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


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
        $s3 = SdkService::sdkFunc();

        $profile_image = $s3->getObjectUrl(
            config('app.bucket'),
            $user->profile_image,
        );


        $lists = new LengthAwarePaginator(
            $lists,
            count(Tweet::all()),
            5,
            $request->page,
            array('path' => $request->url())
        );

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        if($user->id === Auth()->id()) {
            return view('users.edit', [
                'user_id' => $user->id,
                'screen_name' => $user->screen_name,
                'name' => $user->name,
                'email' => $user->email,
                'profile_image' => $user->profile_image
            ]);
        }else{
            return redirect('/');
        }

    }

/**
* @param  UserRequest  $request
* @param  User  $user
* @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
*/
    public function update(UserRequest $request,User $user)
    {
        $data = $request->all();


        $user->updateProfile($data);

        return redirect('user/'.$user->id);

    }
}
