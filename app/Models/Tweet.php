<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


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
        $tweets = self::orderBy('created_at', 'DESC')->paginate(5);
        $s3 = App::make('aws')->createClient('s3');

        $timeline = [];
        foreach ($tweets as $tweet) {
            $elm = [
                'text' => $tweet->text,
                'created_at' => $tweet->created_at->format('Y/m/d H:i'),
                'profile_image' => $s3->getObjectUrl(config('app.bucket'),$tweet->user->profile_image ? $tweet->user->profile_image : 'noimage.jpg'),
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
     * 編集するツイートを取得
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
    public function updateTweet($user_id, $tweet_id)
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


    /**
     * user.showのツイート取得
     *
     * @param $user_id
     * @return mixed
     */
    public function getUserTweet($user_id){
        $tweets = $this->where('user_id',$user_id)->orderBy('created_at', 'DESC')->paginate(5);
        $s3 = App::make('aws')->createClient('s3');

        $timelines = [];
        foreach($tweets as $tweet){
            $elm = [
                'id' => $tweet->id,
                'text' => $tweet->text,
                'profile_image' => $s3->getObjectUrl(config('app.bucket'),$tweet->user->profile_image ? $tweet->user->profile_image : 'noimage.jpg'),
                'name' => $tweet->user->name,
                'screen_name' => $tweet->user->screen_name,
                'user_id' => $tweet->user->id,
                'tweet_id' => $tweet->id,
                'user_favorite' => $tweet->favorites->where('user_id', Auth()->user()->id)->first(),
                'favorite_count' => $tweet->favorites->count(),
                'created_at' => $tweet->created_at->format('Y/m/d H:i')
            ];

            $timelines[] = $elm;
        }

        return $timelines;
    }

    /**
     * ツイート数取得
     *
     * @param $user_id
     * @return mixed
     */
    public function getTweetCount($user_id){
        return $this->where('user_id',$user_id)->count();
    }
}
