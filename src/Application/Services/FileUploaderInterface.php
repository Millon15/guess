<?php

namespace Guess\Application\Services;

interface FileUploaderInterface
{
    public function upload(
        string $bucketName,
        string $s3RegionName,
        string $objectName,
        string $imageUrl
    ): void;

    public function getImageUrl(): string;
}
