<?php
require_once dirname(__FILE__) . '/../../vendor/autoload.php';
require_once dirname(__FILE__) . '/../config.php';

use Aws\S3\S3Client;

class DOSpacesCLient
{
    protected $client;

    public function __construct()
    {
        $client = new Aws\S3\S3Client([
            'version' => 'latest',
            'region'  => 'us-east-1',
            'endpoint' => 'https://nyc3.digitaloceanspaces.com',
            'credentials' => [
                'key'    => 'key',
                'secret' => getenv('SPACES_SECRET'),
            ],
        ]);
    }

    public function uploadImage($imagePath)
    {
        // $client->putObject([
        //     'Bucket' => 'example-space-name',
        //     'Key'    => 'file.ext',
        //     'Body'   => 'The contents of the file.',
        //     'ACL'    => 'private',
        //     'Metadata'   => array(
        //         'x-amz-meta-my-key' => 'your-value'
        //     )
        // ]);
    }
}
