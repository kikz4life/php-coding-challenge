<?php

namespace App\Services;

use App\Exceptions\CustomerImportException;
use GuzzleHttp\Exception\ClientException;
use App\Contracts\CustomerDataProviderInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RandomUserApiService implements CustomerDataProviderInterface
{
    protected string $apiUrl;
    protected string $nationality;
    public function __construct()
    {
        $this->apiUrl = config('customers.data_provider_url');
        $this->nationality = config('customers.nationality');
    }

    /**
     * @throws CustomerImportException
     */
    public function fetchCustomers(int $count): array
    {
        try {
            $response = Http::get($this->apiUrl, [
                'results' => $count,
                'nat' => $this->nationality,
            ]);

            if ($response->failed()) {
                throw new CustomerImportException(
                    "Failed to fetch customers from API",
                    0,
                    null,
                    [
                        'body' => $response->body()
                    ]
                );
            }

            $results = $response->json('results');

            if (!is_array($results)) {
                throw new CustomerImportException(
                    'Invalid response structure: `results` not found or malformed.',
                    0,
                    null,
                    ['response' => $response->json()]
                );
            }

            return $results;
        } catch (\Exception $e) {
            throw new CustomerImportException(
                'API request failed.',
                0,
                $e,
                ['url' => $this->apiUrl, 'count' => $count]
            );
        }

    }
}
