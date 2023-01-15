<?php

namespace Guava\Mailcheap\Endpoints;

use Illuminate\Support\Facades\Http;

class Accounts extends Endpoint
{
    protected string $endpoint = 'accounts';

    public function all(): array
    {
        return $this->request()
            ->get($this->api->url($this->endpoint))
            ->json();
    }

}
