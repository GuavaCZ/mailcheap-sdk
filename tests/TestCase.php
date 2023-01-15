<?php

namespace Guava\Mailcheap\Tests;

use Guava\Mailcheap\MailcheapServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @param $app
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            MailcheapServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
    }
}
