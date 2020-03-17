<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps =true;

    public function storefavorite(Int $tweet_id, Int $user_id)
    {
        $this->user_id = $user_id;
        $this->tweet_id = $tweet_id;
        $this->save();
    }

    public function destroyFavorite(Int $favorite_id)
    {
        return $this->where('id',$favorite_id)->delete();
    }
}
