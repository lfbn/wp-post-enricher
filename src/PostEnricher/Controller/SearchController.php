<?php

namespace PostEnricher\Controller;

use PostEnricher\Service\SearchService;
use PostEnricher\Service\TemplatingService;

class SearchController extends BaseController
{

    public function indexAction()
    {

        $searchtype = $_POST['search_type'];
        $terms = $_POST['terms'];

        $postEnricherService = new SearchService($searchtype);
        $result = $postEnricherService->byTerms($terms);

        $template = 'response-table-'.$searchtype;

        return TemplatingService::render(
            $template,
            array('data' => $result)
        );
    }
}
