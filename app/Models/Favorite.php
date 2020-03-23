<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    /**
     * いいねしているかどうか判定
     *
     * @param  Int  $user_id
     *
     * @param  Int  $tweet_id
     *
     * @return bool
     */
    public function isFavorite(Int $user_id, Int $tweet_id)
    {

        return (boolean) $this->where('tweet_id', $tweet_id)->where('user_id', $user_id)->first();

    }

    /**
     * いいねする
     *
     * @param  Int  $user_id
     *
     * @param  Int  $tweet_id
     */
    public function storeFavorite(Int $user_id, Int $tweet_id)
    {
        $this->user_id = $user_id;
        $this->tweet_id = $tweet_id;
        $this->save();

        return;
    }

    public function delete_favorite(Int $favorite_id)
    {
        return $this->where('id', $favorite_id)->delete();

    }
}
