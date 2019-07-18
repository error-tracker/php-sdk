<?php

declare(strict_types = 1);

namespace ErrorTracker\Tests;

use ErrorTracker\Handler;
use Exception;

/**
 * @package   error-traker/php-sdk
 * @author    Ade Attwood <ade@practically.io>
 * @copyright 2019 Practically.io
 */
class HandlerTest extends BaseTestCase
{

    public function testInitalizing(): void
    {
        $handler = new Handler('TEST_APP_KEY');
        $this->assertTrue($handler->enabled);
    }

    public function testReportingException(): void
    {
        $client = $this->getMockBuilder('Client')
           ->setMethods(['report'])
           ->getMock();


        $client->expects($this->once())
           ->method('report')
           ->willReturn(null);
        
        $handler = new Handler('TEST_APP_KEY', $client);
        $exception = new Exception('Test exception');
        $handler->handleException($exception);
    }

    public function testReportingError(): void
    {
        $client = $this->getMockBuilder('Client')
           ->setMethods(['report'])
           ->getMock();


        $client->expects($this->once())
           ->method('report')
           ->willReturn(null);
        
        new Handler('TEST_APP_KEY', $client);
        trigger_error('Test Error', E_USER_ERROR);
    }

    public function testDisabled(): void
    {
        $client = $this->getMockBuilder('Client')
           ->setMethods(['report'])
           ->getMock();


        $client->expects($this->never())
           ->method('report');
    
        $handler = new Handler('TEST_APP_KEY', $client);
        $handler->enabled = false;

        trigger_error('Test Error', E_USER_ERROR);
    }

    public function testUnregister(): void
    {
        $client = $this->getMockBuilder('Client')
           ->setMethods(['report'])
           ->getMock();


        $client->expects($this->never())
           ->method('report');
    
        $handler = new Handler('TEST_APP_KEY', $client);
        $handler->unregister();

        trigger_error('Test Error', E_USER_ERROR);
    }
}
