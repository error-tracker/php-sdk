<?php

declare(strict_types = 1);

namespace ErrorTracker;

use ErrorTracker\Http;

/**
 * Error Tracker api client all the methods you need to interface with the api
 *
 * @package   error-traker/php-sdk
 * @author    Ade Attwood <ade@practically.io>
 * @copyright 2019 Practically.io
 */
class Client
{

    /**
     * The application key for your error tracker app
     *
     * @var string
     */
    private $appKey;

    /**
     * The internal http instance
     *
     * @var Http
     */
    private $http;

    /**
     * Set up the client
     *
     * @param string $app_key Your app key from error tracker
     * @param Http   $http    Over ride the clients http instance
     */
    public function __construct(string $app_key, $http = null)
    {
        $this->appKey = $app_key;
        $this->http = ($http === null) ? new Http : $http;
    }

    /**
     * Reports an error to error tracker
     *
     * @param $data The data of your error that you want to report
     */
    public function report(array $data): void
    {
        $this->http->post('/report', array_merge($data, ['app_key' => $this->appKey]));
    }
}
