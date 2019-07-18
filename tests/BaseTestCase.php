<?php

declare(strict_types = 1);

namespace ErrorTracker\Tests;

use ErrorTracker\Http;
use PHPUnit\Framework\MockObject\MockBuilder;

/**
 * @package   error-traker/php-sdk
 * @author    Ade Attwood <ade@practically.io>
 * @copyright 2019 Practically.io
 */
class BaseTestCase extends \PHPUnit\Framework\TestCase
{

    /**
     * Creates a mock of the http class
     *
     */
    public function mockHttp(): MockBuilder
    {
        Http::$trackerUrl = 'http:localhost';
        return $this->getMockBuilder('Http')->setMethods(['post']);
    }
}
