<?php

namespace App\Services;

use Aws\S3\S3Client;

class SdkService
{
public static function sdkFunc()
{
    $s3 = new S3Client([
        'credentials' => [
            'key'       => config('app.aws.access_key'),
            'secret'    => config('app.aws.secret'),
        ],
        'version' => 'latest',
        'region' => config('app.aws.region'),

    ]);

    return $s3;
}
}
