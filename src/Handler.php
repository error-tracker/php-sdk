<?php

declare(strict_types = 1);

namespace ErrorTracker;

use ErrorTracker\Client;

/**
 * The main handler for vanilla php apps
 *
 * @package   error-traker/php-sdk
 * @author    Ade Attwood <ade@practically.io>
 * @copyright 2019 Practically.io
 */
class Handler
{
    /**
     * The errors type contents
     */
    const TYPE_ERROR = 1;
    const TYPE_WARNING = 2;

    /**
     * States if errors will be reported
     *
     * @var boolean
     */
    public $enabled = true;

    /**
     * The internal error tracker api client
     *
     * @var Client
     */
    private $client;

    /**
     * Set up the error handler
     *
     * @return void
     */
    public function __construct(string $app_key, $client = null)
    {
        $this->client = ($client === null) ? new Client($app_key) : $client;
        $this->register();
    }

    /**
     * Registers the error handlers
     *
     * @return void
     */
    public function register(): void
    {
        set_exception_handler([$this, 'handleException']);
        set_error_handler([$this, 'handleError']);
    }

    /**
     * Unregister the error handlers
     *
     * @return void
     */
    public function unregister(): void
    {
        restore_error_handler();
        restore_exception_handler();
    }

    /**
     * Handles logging a php exception
     *
     * @param Exception $exception
     *
     * @return void
     */
    public function handleException($exception): void
    {
        try {
            $this->logError(
                self::TYPE_ERROR,
                $exception->getCode(),
                get_class($exception),
                $exception->getMessage(),
                $exception->getTraceAsString(),
                $exception->getFile(),
                $exception->getLine()
            );
        } catch (\Exception $e) {
        }
    }

    /**
     * Handles a general php error
     *
     * @param integer $error_number
     * @param string $error_string
     * @param string $error_file
     * @param integer $error_line
     *
     * @return void
     */
    public function handleError($error_number, $error_string, $error_file, $error_line): void
    {
        try {
            $this->logError(
                self::TYPE_WARNING,
                $error_number,
                null,
                $error_string,
                '',
                $error_file,
                $error_line
            );
        } catch (\Exception $e) {
        }
    }

    /**
     * The main function that logs the error
     *
     * @param integer $error_type        The type of error in error tracker
     * @param integer $error_number      The php error number
     * @param string  $error_name        The name of the error
     * @param string  $error_string      The short text about the error
     * @param string  $error_description The main description
     * @param string  $error_file        The file the error was in
     * @param integer $error_line        The line in the file of the error
     *
     * @return void
     */
    protected function logError($error_type, $error_number, $error_name, $error_string, $error_description, $error_file, $error_line): void
    {
        if (!$this->enabled) {
            return;
        }

        if (!$error_name) {
            switch ($error_number) {
                case E_ERROR:
                    $error_name = 'PHP: ERROR';
                    break;
                case E_WARNING:
                    $error_name = 'PHP: WARNING';
                    break;
                case E_PARSE:
                    $error_name = 'PHP: PARSE';
                    break;
                case E_NOTICE:
                    $error_name = 'PHP: NOTICE';
                    break;
                case E_CORE_ERROR:
                    $error_name = 'PHP: CORE ERROR';
                    break;
                case E_CORE_WARNING:
                    $error_name = 'PHP: CORE WARNING';
                    break;
                case E_COMPILE_ERROR:
                    $error_name = 'PHP: COMPILE ERROR';
                    break;
                case E_COMPILE_WARNING:
                    $error_name = 'PHP: COMPILE WARNING';
                    break;
                case E_USER_ERROR:
                    $error_name = 'PHP: USER ERROR';
                    break;
                case E_USER_WARNING:
                    $error_name = 'PHP: USER WARNING';
                    break;
                case E_USER_NOTICE:
                    $error_name = 'PHP: USER NOTICE';
                    break;
                case E_STRICT:
                    $error_name = 'PHP: STRICT';
                    break;
                case E_RECOVERABLE_ERROR:
                    $error_name = 'PHP: RECOVERABLE ERROR';
                    break;
                case E_DEPRECATED:
                    $error_name = 'PHP: DEPRECATED';
                    break;
                case E_USER_DEPRECATED:
                    $error_name = 'PHP: USER DEPRECATED';
                    break;
                default:
                    $error_name = 'PHP: UNKNOWN ERROR';
                    break;
            }
        }

        $data = [
            'type' => $error_type,
            'name' => $error_name,
            'text' => $error_string,
            'description' => $error_description,
            'file' => $error_file,
            'line_number' => $error_line,
            'url' => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '',
            'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
            'ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
        ];

        $this->client->report($data);
    }
}
