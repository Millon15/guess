<?php

namespace Guess\Infrastructure\S3;

use Aws\S3\S3Client;
use Guess\Application\Services\FileUploaderInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class FileUploader implements FileUploaderInterface
{
    private string $s3ObjectName;
    private string $bucketName;

    public function __construct(
        private string $s3RegionName,
        private S3Client $client,
    ) {
    }

    public function upload(string $bucketName, string $objectName, string $imageUrl): void
    {
        $this->s3ObjectName = strtolower((new AsciiSlugger())->slug($objectName).'.png');
        $this->bucketName = $bucketName;

        $this->client->putObject([
            'Bucket' => $this->bucketName,
            'Key' => $this->s3ObjectName,
            'Body' => file_get_contents($imageUrl),
            'ACL' => 'public-read',
        ]);
    }

    public function getImageUrl(): string
    {
        return "https://$this->bucketName.s3.$this->s3RegionName.amazonaws.com/$this->s3ObjectName";
    }
}
