<?php

namespace PostEnricher\Adapter;

use PostEnricher\Client\HttpClient;
use PostEnricher\Service\SearchService;

/**
 * This layer has the API information hard-coded into it. His job is to
 * convert the remote API into a local API.
 */
class ApiToolsAdapter
{

    /**
     * @var string
     */
    private static $protocol = 'http';

    /**
     * @var string
     */
    private static $resourceName = 'api.bit.tools';

    /**
     * @var int
     */
    private static $port = 8080;

    /**
     * @var string
     */
    private static $path = 'search';

    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * This translates from the search types of this client
     * to the search types expected by this remote API.
     *
     * @var array
     */
    private static $searchTypesMapper = array(
        SearchService::SEARCH_TYPE_YOUTUBE => SearchService::SEARCH_TYPE_YOUTUBE,
        SearchService::SEARCH_TYPE_GOOGLE_SEARCH => 'web',
        SearchService::SEARCH_TYPE_TWITTER => SearchService::SEARCH_TYPE_TWITTER,
        SearchService::SEARCH_TYPE_WORD_METRICS => 'words'
    );

    public function __construct()
    {
        $this->endpoint = sprintf(
            '%s://%s:%d',
            self::$protocol,
            self::$resourceName,
            self::$port
        );
        $this->httpClient = new HttpClient($this->endpoint);
    }

    /**
     * Do a search by search type and terms in the remote API.
     *
     * @param string $searchType It will be used in the URL.
     * @param string $terms It will be added to the request payload.
     *
     * @return null|array
     */
    public function search($searchType, $terms)
    {
        $result = $this->httpClient->post(
            sprintf('%s/%s', self::$searchTypesMapper[$searchType], self::$path),
            array('Content-Type: application/json'),
            array('terms' => $terms)
        );
        return json_decode($result, true);
    }
}
