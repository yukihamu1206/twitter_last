<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Tweet extends Model
{
    protected $fillable = [
        'text'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * タイムラインに表示するツイートデータを取得
     *
     * @return array
     */
    public function getTimeline()
    {
        $tweets = self::paginate(5);

        $timeline = [];
        foreach ($tweets as $tweet) {
            $elm = [
                'text' => $tweet->text,
                'created_at' => $tweet->created_at->format('Y/m/d H:i'),
                'profile_image' => Storage::disk('s3')->url($tweet->user->profile_image ? $tweet->user->profile_image : 'noimage.jpg'),
                'name' => $tweet->user->name,
                'screen_name' => $tweet->user->screen_name,
                'user_id' => $tweet->user->id,
                'tweet_id' => $tweet->id,
                'user_favorite' => $tweet->favorites->where('user_id', Auth()->user()->id)->first(),
                'favorite_count' => $tweet->favorites->count()
            ];

            $timeline[] = $elm;
        }

        return $timeline;
    }

    /**
     * タイムラインに表示するツイートデータを取得
     *
     * @param $user_id
     * @param $tweet_id
     * @return bool
     */
    public function getEditTweet($user_id, $tweet_id)
    {
        return $this->where('user_id', $user_id)->where('id', $tweet_id)->first();
    }

    /**
     * ツイートを更新
     *
     * @param $user_id
     * @param $tweet_id
     */
    public function updatetweet($user_id, $tweet_id)
    {
        $this->user_id = $user_id;
        $this->id = $tweet_id;

        $this->update();

        return;

    }


    /**
     * ツイートを削除
     *
     * @param $user_id
     * @param $tweet_id
     * @return mixed
     */
    public function deleteTweet($user_id, $tweet_id)
    {
        return $this->where('user_id', $user_id)->where('id', $tweet_id)->first()->delete();
    }
}
