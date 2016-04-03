<?php

namespace PostEnricher\Controller;

use PostEnricher\Service\TemplatingService;

class BaseController
{

    /**
     * Returns a rendered view.
     *
     * @param string $view The view name
     * @param array $parameters An array of parameters to pass to the view
     *
     * @return string The rendered view
     */
    public function renderView($view, array $parameters = array())
    {
        return TemplatingService::render($view, $parameters);
    }
}
