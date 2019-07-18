<?php

declare(strict_types = 1);

namespace ErrorTracker\Tests;

use ErrorTracker\Client;

/**
 * @package   error-traker/php-sdk
 * @author    Ade Attwood <ade@practically.io>
 * @copyright 2019 Practically.io
 */
class ClientTest extends BaseTestCase
{

    public function testReporting(): void
    {
        $http = $this->mockHttp()->getMock();
        $http->expects($this->once())
             ->method('post')
             ->willReturn(null)
             ->with(
                 $this->equalTo('/report'),
                 ['name' => 'The error name', 'app_key' => 'TEST_APP_KEY']
             );

        $client = new Client('TEST_APP_KEY', $http);
        $client->report(['name' => 'The error name']);
    }
}
