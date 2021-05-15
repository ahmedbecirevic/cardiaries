<?php
require_once dirname(__FILE__) . '/../../vendor/autoload.php';
require_once dirname(__FILE__) . '/../config.php';

use Aws\S3\S3Client;

class DOSpacesClient
{
    protected $client;

    public function __construct()
    {
        $this->client = new Aws\S3\S3Client([
            'version' => 'latest',
            'region'  => 'eu-central-1',
            'endpoint' => 'fra1.digitaloceanspaces.com',
            'credentials' => [
                'key'    => Config::SPACES_KEY(),
                'secret' => Config::SPACES_SECRET(),
            ],
        ]);
    }

    public function uploadImage($imagePath)
    {
        $this->client->putObject([
            'Bucket' => 'cardiaries-space',
            'Key'    => $imagePath
            // 'Body'   => 'The contents of the file.',
            // 'ACL'    => 'private',
            // 'Metadata'   => array(
            //     'x-amz-meta-my-key' => 'your-value'
            // )
        ]);
    }
}