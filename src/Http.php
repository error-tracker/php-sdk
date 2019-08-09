<?php

declare(strict_types = 1);

namespace ErrorTracker;

class Http
{

    /**
     * The main url to error tracker
     *
     * @var string
     */
    public static $trackerUrl = 'https://app.error-tracker.com';

    /**
     * Sends a post request to the error tracker api
     *
     * @param string $url
     * @param array $data
     *
     * @return void
     */
    public static function post(string $url, array $data): void
    {
        $_url = str_replace('//', '/', self::$trackerUrl . "/$url");
        $ch = curl_init($_url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($data)
        ]);

        curl_exec($ch);
        curl_close($ch);
    }
}
