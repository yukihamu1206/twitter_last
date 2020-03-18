<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TweetsController extends Controller
{
    public function create()
    {
        $token = Auth()->user()->api_token;
        return view('tweets.create',['token' => $token]);
    }

    public function index()
    {
        $tweets = Tweet::all();

        $lists = [];

        foreach($tweets as $tweet){
            $elm = [
                'text' => $tweet->text,
                'created_at' => $tweet->created_at->format('Y-m-d H:i'),
                'profile_image' => $tweet->user->profile_image ? $tweet->user->profile_image : 'noimage.jpg',
                'name' => $tweet->user->name,
                'screen_name' => $tweet->screen_name,
                'user_id' => $tweet->user->id,
                'tweet_id' => $tweet->id
            ];

            $lists[] = $elm;
        }

        return view('tweets.index',['lists' => $lists]);


    }
}
