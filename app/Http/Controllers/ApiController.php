<?php

namespace App\Http\Controllers;

use App\Http\Requests\TweetRequest;
use App\Models\Favorite;
use App\Models\Tweet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ApiController extends Controller
{

    /**
     *TweetRequestでvalidationチェックして、jsonを返す
     *
     * @param  TweetRequest  $request
     *
     * @return JsonResponse
     */
    public function post_tweet(TweetRequest $request)
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

        $user_id = Auth()->id();
        $tweet_id = $request->tweet_id;

        $is_favorite = $favorite->isFavorite($user_id, $tweet_id);

        if (!$is_favorite) {
            $favorite->storeFavorite($user_id, $tweet_id);
            $favorite_count = $favorite->where('tweet_id', $tweet_id)->count();
            $user_favorite = $favorite->where('user_id', $user_id)->where('user_id', $user_id)->first()->id;

            return response()->json([
                'result' => true,
                'favorite_count' => $favorite_count,
                'user_favorite' => $user_favorite
            ]);

        }
    }

    /**
     * いいね削除
     * @param  Request  $request
     * @param  Favorite  $favorite
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete_favorite(Request $request, Favorite $favorite)
    {
        $user_id = Auth()->id();
        $tweet_id = $request->tweet_id;
        $favorite_id = $request->favorite_id;


        $is_favorite = $favorite->isFavorite($user_id, $tweet_id);

        if ($is_favorite) {
            $favorite->delete_favorite($favorite_id);
            $favorite_count = $favorite->where('tweet_id', $tweet_id)->count();

            return response()->json([
                'result' => true,
                'favorite_count' => $favorite_count
            ]);
        }


    }
}
