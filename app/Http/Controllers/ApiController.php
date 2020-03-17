<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\TweetRequest;

class ApiController extends Controller
{
    public function get_user()
    {
        $user = auth()->user();
        Log::debug($user);
        $token = $user->api_token;
        $profile_image = $user->profile_image ? $user->profile_image : 'noimage.jpg';
        $name = $user->name;
        $screen_name = $user->screen_name;

        return response()->json(
            [   'user' => $user,
                'profile_image' => $profile_image,
                'name' => $name,
                'screen_name' => $screen_name,
                'token' => $token],
            200, [],
            JSON_UNESCAPED_UNICODE);
        }

    public function post_tweet(TweetRequest $request)
    {

        $tweet = new Tweet;
        $tweet->text = $request->text;
        $tweet->user_id = Auth()->id();


        $tweet->save();

        return response()->json(
            ['tweet' => $tweet],
            200, [],
            JSON_UNESCAPED_UNICODE);
        }


}
