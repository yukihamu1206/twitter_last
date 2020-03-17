<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Tweet;
use Illuminate\Support\Facades\Auth;
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

    public function post_tweet(Request $request)
    {

        $tweet = new Tweet;
        $tweet->text = $request->text;
        $tweet->user_id = Auth()->id();

        $request->validate([
        'text' => ['required','max:140']
        ]);

        $tweet->save();

        return response()->json(
            ['tweet' => $tweet],
            200, [],
            JSON_UNESCAPED_UNICODE);
        }

    public function get_timeline()
    {
        $tweets = Tweet::all();

        $lists = [];

            foreach($tweets as $tweet){
                $elm = [
                    'text' => $tweet->text,
                    'name' => $tweet->user->name,
                    'screen_name' => $tweet->user->screen_name,
                    'profile_image' => $tweet->user->profile_image ? $tweet->user->profile_image : 'noimage.jpg',
                    'created_at' => $tweet->created_at->format('Y-m-d H:i'),
                    'user_id' => $tweet->user->id,
                    'tweet_id' => $tweet->id,
                    'favorite_id' => $tweet->favorites->where('tweet_id',$tweet->id)->where('user_id',Auth()->id())->first(),
                    'favorite_icon' => $tweet->favorites->where('tweet_id',$tweet->id)->where('user_id',Auth()->id())->first() ? 'fas' : 'far'
                ];

                $lists[] = $elm;
            }

            return response()->json(
                ['lists' => $lists],
                200, [],
                JSON_UNESCAPED_UNICODE);

        }

    public function favorite(Request $request, Favorite $favorite)
    {
        $user = Auth()->user();

        $tweet_id = $request->tweet_id;
        $favorite->storeFavorite($user->id,$tweet_id);

        $favorites_count  = $favorite->where('tweet_id', $tweet_id)
            ->count();
        $user_favorite_id = $favorite->where('user_id', $user->id)
            ->where('tweet_id', $tweet_id)
            ->first()->id;

        return responce()->json([
            'favorites_count' => $favorites_count,
            'user_favorite_id' => $user_favorite_id,
            ]);

        }

    public function delete_favorite(Favorite $favorite){
        $user_id     = $favorite->user_id;
        $tweet_id    = $favorite->tweet_id;
        $favorite_id = $favorite->id;

        $favorite->destroyFavorite($favorite_id);

        $favorites_count = $favorite->where('tweet_id', $tweet_id)->count();

        return response()->json([
            'result'          => true,
            'favorites_count' => $favorites_count,
        ]);
    }
}
