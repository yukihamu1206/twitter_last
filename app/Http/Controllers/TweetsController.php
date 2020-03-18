<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class TweetsController extends Controller
{
    public function create()
    {
        $token = Auth()->user()->api_token;
        return view('tweets.create',['token' => $token]);
    }

    public function index(Tweet $tweet)
    {
        $tweets = Tweet::all();

        $lists = [];

        foreach($tweets as $tweet){
            $elm = [
                'text' => $tweet->text,
                'created_at' => $tweet->created_at->format('Y-m-d H:i'),
                'profile_image' => Storage::disk('s3')->url($tweet->user->profile_image ? $tweet->user->profile_image : 'noimage.jpg'),
                'name' => $tweet->user->name,
                'screen_name' => $tweet->user->screen_name,
                'user_id' => $tweet->user->id,
                'tweet_id' => $tweet->id
            ];

            $lists[] = $elm;
        }

       $lists = new LengthAwarePaginator(
         array_chunk($lists,5),
           count($lists),
           5,
           1
       );


        return view('tweets.index',['lists' => $lists]);


    }
}
