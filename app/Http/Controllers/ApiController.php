<?php

namespace App\Http\Controllers;

use App\Http\Requests\TweetRequest;
use App\Models\Favorite;
use App\Models\Tweet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ApiController extends Controller
{

    /**
     *TweetRequestでvalidationチェックして、jsonを返す
     *
     * @param  TweetRequest  $request
     *
     * @return JsonResponse
     */
    public function store(TweetRequest $request)
    {


        $tweet = new Tweet;
        $tweet->text = $request->text;
        $tweet->user_id = Auth()->id();

        #validatorを取得する
        $validator = $request->getValidator();

        if ($validator->fails()) {
            return response()->json(
                [
                    'result' => false,
                    'errors' => $validator->errors()
                ],
                200,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }

        $tweet->save();

        return response()->json(
            [
                'result' => true,
                'tweet' => $tweet
            ],
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * ツイートを編集
     *
     * @param  TweetRequest  $request
     * @param  Tweet  $tweet
     * @return JsonResponse
     */
    public function update(TweetRequest $request, Tweet $tweet)
    {

        $tweet->text = $request->text;
        $tweet->user_id = Auth()->id();

        $validator = $request->getValidator();

        if ($validator->fails()) {
            return response()->json(
                [
                    'result' => false,
                    'errors' => $validator->errors()
                ],
                200,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }

        $tweet->updateTweet($tweet->user_id, $tweet->id);

        return response()->json(
            [
                'result' => true
            ],
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );

    }

    /**
     * ツイートを削除
     *
     * @param  Tweet  $tweet
     *
     * @return JsonResponse
     */
    public function destroy(Tweet $tweet)
    {
        $user = Auth()->user();
        $tweet->deleteTweet($user->id, $tweet->id);

        return response()->json([
            'result' => true
        ]);


    }

    /**
     *いいねをする
     *
     * @param  Request  $request
     *
     * @param  Favorite  $favorite
     *
     * @return JsonResponse
     */
    public function favorite(Request $request, Favorite $favorite)
    {

        $user_id = Auth::id();
        $tweet_id = $request->tweet_id;
        $is_Favorite = $favorite->isFavorite($user_id, $tweet_id);


        if (!$is_Favorite) {
            $favorite->storeFavorite($user_id, $tweet_id);
            $favorite_count = $favorite->where('tweet_id', $tweet_id)->count();
            $user_favorite_id = $favorite->where('user_id', $user_id)->where('tweet_id', $tweet_id)->first()->id;


            return response()->json([
                'result' => true,
                'favorite_count' => $favorite_count,
                'user_favorite_id' => $user_favorite_id
            ]);
        }
    }


    /**
     * いいね削除
     *
     * @param  Favorite  $favorite
     *
     * @return JsonResponse
     */
    public function deleteFavorite(Favorite $favorite)
    {
        $user_id = Auth()->id();
        $tweet_id = $favorite->tweet_id;
        $favorite_id = $favorite->id;
        $is_Favorite = $favorite->isFavorite($user_id, $tweet_id);


        if ($is_Favorite) {
            $favorite->deleteFavorite($favorite_id);
            $favorite_count = $favorite->where('tweet_id', $tweet_id)->count();

            return response()->json([
                'result' => true,
                'favorite_count' => $favorite_count
            ]);
        }
    }

}
