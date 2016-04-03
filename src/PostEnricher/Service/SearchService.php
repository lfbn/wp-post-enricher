<?php

namespace PostEnricher\Service;

use PostEnricher\Adapter\ApiToolsAdapter;
use PostEnricher\Helpers\Arr;

class SearchService
{

    const SEARCH_TYPE_GOOGLE_SEARCH = 'google-search';

    const SEARCH_TYPE_YOUTUBE = 'youtube';

    const SEARCH_TYPE_TWITTER = 'twitter';

    const SEARCH_TYPE_WORD_METRICS = 'word-metrics';

    /**
     * @var string
     */
    private $searchType;

    /**
     * @var ApiToolsAdapter
     */
    private $apiToolsAdapter;

    /**
     * See PostEnricherService::getValidSearchTypes to see which are
     * the valid search types allowed.
     *
     * @param $searchType
     */
    public function __construct($searchType)
    {
        $this->searchType = $searchType;
        $this->apiToolsAdapter = new ApiToolsAdapter();
    }

    /**
     * @param string $terms The terms to search
     *
     * @return array|null
     *
     * @throws \Exception If the search type is invalid than throws an exception.
     *
     * @TODO - Can have in the future a black list of words, and also symbols, to remove.
     */
    public function byTerms($terms)
    {

        if (!in_array($this->searchType, self::getValidSearchTypes())) {
            throw new \Exception('Invalid search type!');
        }

        $result = filter_var($terms, FILTER_SANITIZE_STRING);
        $result = strtolower(trim($result));
        $result = str_replace(self::getPunctuation(), '', $result);

        return $this->apiToolsAdapter->search(
            $this->searchType,
            $result
        );
    }

    /**
     * @return array
     */
    public static function getValidSearchTypes()
    {
        return array(
            self::SEARCH_TYPE_GOOGLE_SEARCH,
            self::SEARCH_TYPE_YOUTUBE,
            self::SEARCH_TYPE_TWITTER,
            self::SEARCH_TYPE_WORD_METRICS
        );
    }

    /**
     * @return array
     */
    private function getPunctuation()
    {
        return array(
            '(',
            ')',
            ':',
            ',',
            '!',
            '.',
            '?',
            ';',
            '"',
            '-',
            "'"
        );
    }
}
