<?php

namespace PostEnricher\Client;

/**
 * This layer is where the actual calls to the remote API take place. Here
 * is all about the protocol, and should be nothing here API specific.
 *
 * @TODO - Add support for GET, PUT, PATCH and DELETE HTTP verbs.
 */
class HttpClient
{

    const HTTP_VERB_POST = 'post';

    const HTTP_VERB_GET = 'get';

    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var string
     */
    private $lastError = null;

    /**
     * @var array
     */
    private $lastResponse = array();

    /**
     * @var array
     */
    private $lastRequest = array();

    /**
     * @param $endpoint
     */
    public function __construct($endpoint)
    {
        $this->endpoint = $endpoint;
        $this->lastResponse = $this->getDefaultResponse();
    }

    /**
     * @return string
     */
    public function getLastError()
    {
        return $this->lastError;
    }

    /**
     * @return array
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * @return array
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * Makes an HTTP POST request. Only the path is mandatory.
     *
     * @param string $path
     * @param array $headers
     * @param array $args
     * @param int $timeout
     *
     * @return null|array
     */
    public function post($path, $headers = array(), $args = array(), $timeout = 10)
    {
        return $this->makeRequest(self::HTTP_VERB_POST, $path, $headers, $args, $timeout);
    }

    /**
     * @param $httpVerb
     * @param $path
     * @param $headers
     * @param array $args
     * @param int $timeout
     *
     * @return null|array
     *
     * @TODO Support for PUT, PATCH and DELETE HTTP verbs.
     */
    private function makeRequest($httpVerb, $path, $headers, $args = array(), $timeout = 10)
    {

        $url = sprintf(
            '%s/%s',
            $this->endpoint,
            $path
        );

        $this->lastError = null;
        $this->lastResponse = $this->getDefaultResponse();
        $this->lastRequest = array(
            'url' => $url,
            'http_verb' => $httpVerb,
            'path' => $path,
            'body' => json_encode($args),
            'timeout' => $timeout
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($ch, CURLOPT_USERAGENT, 'WPPostEnricherPlugin');
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        switch ($httpVerb) {
            case self::HTTP_VERB_POST:
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
                break;
            case self::HTTP_VERB_GET:
                $queryParams = http_build_query($args);
                curl_setopt($ch, CURLOPT_URL, sprintf('%s?%s', $url, $queryParams));
                break;
        }

        $responseBody = curl_exec($ch);
        $responseHeaders = curl_getinfo($ch);

        if (isset($responseHeaders['headers']['request_header'])) {
            $this->lastRequest['headers'] = $responseHeaders['headers']['request_header'];
        }

        if ($responseBody === false) {
            $this->lastError = curl_error($ch);
        }

        curl_close($ch);
        $this->lastResponse = $responseBody;

        return !empty($responseBody) ? $responseBody : false;
    }

    /**
     * @return array
     */
    private function getDefaultResponse()
    {
        return array(
            'headers' => null,
            'body' => null
        );
    }
}
