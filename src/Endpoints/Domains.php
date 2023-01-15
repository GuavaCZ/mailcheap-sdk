<?php

namespace Guava\Mailcheap\Endpoints;

use Guava\Mailcheap\Accounts\PermissionLevel;
use Illuminate\Support\Facades\Http;

class Domains extends Endpoint
{
    protected string $endpoint = 'domains';

    public function permissionLevel(PermissionLevel $permissionLevel): static
    {
        return $this->query([
            'perm_level' => $permissionLevel->value,
        ]);
    }

    public function all(array $queryParameters = []): array
    {
        return $this->request()
            ->get($this->api->url($this->endpoint, [...$this->queryParameters, ...$queryParameters]))
            ->json();
    }

}
