<?php declare(strict_types=1);

namespace App\Packagist;

use Packagist\Api\Client as BaseClient;
use Packagist\Api\Result\Package;

final class ApiClient implements Client
{
    private BaseClient $client;

    public function __construct(BaseClient $client)
    {
        $this->client = $client;
    }

    public function getPackage(string $packageName): Package
    {
        return $this->client->get($packageName);
    }
}
