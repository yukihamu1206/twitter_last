<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $fillable = [
        'text'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTimeline()
    {
        $tweets = self::paginate(5);

        $timeline = [];
        foreach ($tweets as $tweet) {
            $elm = [
                'text'          => $tweet->text,
                'created_at'    => $tweet->created_at->format('Y/m/d H:i'),
                'profile_image' => $tweet->user->profile_image ? $tweet->user->profile_image : 'noimage.jpg',
                'name'          => $tweet->user->name,
                'screen_name'   => $tweet->user->screen_name,
                'user_id'       => $tweet->user->id,
                'tweet_id'      => $tweet->id,
            ];

            $timeline[] = $elm;
        }

        return $timeline;
    }

}
