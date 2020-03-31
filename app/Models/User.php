<?php

namespace App\Models;

use App\Services\SdkService;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','screen_name','profile_image','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }

    /**
     * user情報update
     *
     * @param $data
     */
    public function updateProfile($data)
    {
        if(isset($data['profile_image'])){

            $file = $data['profile_image'];

            $s3 = SdkService::sdkFunc();

            $profile_image = $s3->putObject([
                'Bucket' => config('app.aws')['bucket'],
                'SourceFile' => $file,
                'Key' =>  $data['profile_image']->getClientOriginalName(),
        ]);

        $this->where('id',$this->id)->update([
            'screen_name' => $data['screen_name'],
            'name' => $data['name'],
            'profile_image' => $data['profile_image']->getClientOriginalName(),
            'email' => $data['email']
        ]);

        }else{

            $this->where('id',$this->id)->update([
                'name' => $data['name'],
                'screen_name' => $data['screen_name'],
                'email' => $data['email']
            ]);
        }

        return;



    }
}
