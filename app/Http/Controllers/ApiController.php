<?php

namespace App\Http\Controllers;

use App\Http\Requests\TweetRequest;
use App\Models\Tweet;



class ApiController extends Controller
{

    /**
     *TweetRequestでvalidationチェックして、jsonを返す
     *
     * @param  TweetRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
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
}
