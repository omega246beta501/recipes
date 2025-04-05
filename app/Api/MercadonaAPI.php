<?php

namespace App\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class MercadonaAPI
{
    private string $algoliaAppKey;
    private string $algoliaAppId;
    private string $defaultWarehouse;
    private string $baseUrl;
    private string $productQueryUrl;

    public function __construct()
    {
        // Retrieve API credentials from config/environment
        $this->algoliaAppKey = config('services.algolia.key', '9d8f2e39e90df472b4f2e559a116fe17');
        $this->algoliaAppId = config('services.algolia.id', '7UZJKL1DJ0');
        $this->defaultWarehouse = 'vlc1';

        // Build base URL and query URL dynamically
        $this->baseUrl = 'https://' . $this->algoliaAppId . '-dsn.algolia.net';
        $this->productQueryUrl = '/1/indexes/products_prod_' . $this->defaultWarehouse . '_es/query';
    }

    /**
     * Query products from the Mercadona API.
     *
     * @param string $query
     * @param int $limit
     * @return Collection
     */
    public function queryProducts(string $query, int $limit = 10): Collection
    {
        try {
            // Prepare body parameters including limiting results using Algolia's hitsPerPage parameter.
            $body = [
                'params' => http_build_query([
                    'query'       => $query,
                    'hitsPerPage' => $limit,
                ]),
            ];

            $response = Http::withQueryParameters([
                'x-algolia-application-id' => $this->algoliaAppId,
                'x-algolia-api-key'        => $this->algoliaAppKey,
            ])->post($this->baseUrl . $this->productQueryUrl, $body);

            if ($response->successful()) {
                $data = $response->json();
                $hits = collect($data['hits'] ?? []);

                return $hits->map(function ($hit) {
                    return [
                        'product_id'        => $hit['id'] ?? null,
                        'name'      => $hit['display_name'] ?? null,
                        'url'       => $hit['share_url'] ?? null,
                        'image_path' => $hit['thumbnail'] ?? null,
                    ];
                });
            }

            Log::error('MercadonaAPI: Query failed', [
                'query'  => $query,
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
        } catch (\Exception $e) {
            Log::error('MercadonaAPI: Exception during query', [
                'query'     => $query,
                'exception' => $e->getMessage(),
            ]);
        }

        return collect();
    }
}
