<?php

namespace App\Utils;

use Aws\Result;
use Aws\S3\S3Client as AWSClient;

class S3Client extends AWSClient
{
    public function __construct()
    {
        parent::__construct([
          'version' => 'latest',
          'region' => 'us-east-1',
          'endpoint' => getenv('S3_ENDPOINT'),
          'use_path_style_endpoint' => true,
          'credentials' => [
            'key' => getenv('S3_ACCESS_KEY'),
            'secret' => getenv('S3_SECRET_KEY'),
          ],
        ]);
    }

    public function saveImage($image, $image_id, $id): Result
    {
        $parts = explode(',', $image);
        $dataPart = $parts[1];
        $result = $this->putObject([
          'Bucket' => getenv('S3_BUCKET'),
          'Key' => $id.'/'.$image_id,
          'Body' => base64_decode($dataPart),
          'ContentEncoding' => 'base64',
        ]);

        return $result;
    }

    public function deleteImage($image_id, $property_id): Result
    {
        $result = $this->deleteObject([
          'Bucket' => getenv('S3_BUCKET'),
          'Key' => $property_id.'/'.$image_id,
        ]);

        return $result;
    }

    public function getImages($property_id): array
    {
        $result = $this->listObjectsV2([
          'Bucket' => getenv('S3_BUCKET'),
          'Prefix' => strval($property_id)."/",
        ]);
        if ($result['KeyCount'] === 0) {
            return [];
        }
        $result = array_map(fn ($item) => ["link" => (getenv('S3_PUBLIC_ENDPOINT') ? getenv('S3_PUBLIC_ENDPOINT') : getenv('S3_ENDPOINT'))."/".getenv('S3_BUCKET')."/".$item['Key'], "id" => substr($item['Key'], strrpos($item['Key'], '/') + 1)], $result['Contents']);

        return $result;
    }
}
