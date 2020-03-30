<?php

namespace App\Services;

use Aws\S3\S3Client;

class SdkService
{
public static function sdkFunc()
{
    $s3 = new S3Client([
        'credentials' => [
            'key'       => config('app.access_key'),
            'secret'    => config('app.secret'),
        ],
        'version' => 'latest',
        'region' => config('app.region'),

    ]);

    return $s3;
}
}
