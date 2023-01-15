<?php

namespace Guava\Mailcheap\Endpoints;

use Guava\Mailcheap\Mailcheap;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class Endpoint
{

    protected string $endpoint;

    protected Mailcheap $api;

    protected array $queryParameters = [];

    public function __construct(Mailcheap $api)
    {
        $this->api = $api;
    }

    public function query(array $queryParameters): static
    {
        $this->queryParameters = [
            ...$this->queryParameters,
            ...$queryParameters,
        ];

        return $this;
    }

    protected function request(): PendingRequest
    {
        return Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($this->api->username . ':' . $this->api->token),
        ]);
    }


}
