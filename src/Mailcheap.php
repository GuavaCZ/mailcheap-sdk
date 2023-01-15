<?php

namespace Guava\Mailcheap;

use Guava\Mailcheap\Endpoints\Accounts;
use Guava\Mailcheap\Endpoints\Domains;
use Guava\Mailcheap\Exceptions\AuthenticationException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Stringable;

class Mailcheap
{
    public string $token;
    public string $username;
    public string $password;

    protected string $baseUrl;

    /**
     * @throws AuthenticationException
     */
    public function __construct(string $baseUrl = null, string $username = null, string $password = null)
    {
        $this->baseUrl = $baseUrl ?? config('mailcheap.api.base_url');
        $this->username = $username ?? config('mailcheap.api.username');
        $this->password = $password ?? config('mailcheap.api.password');

        if (!$this->username) {
            throw new AuthenticationException('Mailcheap API username is required');
        }

        if (!$this->password) {
            throw new AuthenticationException('Mailcheap API password is required');
        }

        $this->token = $this->authenticate(
            username: $this->username,
            password: $this->password,
        );
    }

    public function accounts(): Accounts
    {
        return new Accounts($this);
    }

    public function domains(): Domains
    {
        return new Domains($this);
    }

    /**
     * @param string $endpoint
     * @return string
     */
    public function url(string $endpoint, array $queryParameters = []): string
    {
        return str($this->baseUrl)
            ->trim('/')
            ->append('/', str($endpoint)->trim('/'), '/')
            ->when(!empty($queryParameters), function (Stringable $string) use ($queryParameters) {
                return $string->append('?', http_build_query($queryParameters));
            })
            ->toString();
    }

    /**
     * @param string $username
     * @param string $password
     * @return string
     * @throws AuthenticationException
     */
    protected function authenticate(string $username, string $password): string
    {
        $response = Http::post($this->url('auth'), [
            'username' => $username,
            'password' => $password,
        ]);

        if ($response->failed()) {
            throw new AuthenticationException('Mailcheap API authentication failed');
        }

        $token = $response->json('auth.auth_token');

        if (!$token) {
            throw new AuthenticationException('Auth token not found');
        }

        return $token;
    }

}
