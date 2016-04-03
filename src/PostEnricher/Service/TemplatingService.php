<?php

namespace PostEnricher\Service;

use PostEnricher\Helper\PluginPathsHelper;

class TemplatingService
{

    /**
     * Renders a template.
     *
     * @param string $name The template name
     * @param array $context An array of parameters to pass to the template
     *
     * @return string The rendered template
     */
    public static function render($name, array $context = array())
    {

        $templateContent = '';
        $templatePath = sprintf(
            '%s/%s.php',
            PluginPathsHelper::getPluginViewsDirectory(),
            $name
        );

        if (!is_file($templatePath)) {
            return $templateContent;
        }

        extract($context);
        ob_start();
        require_once($templatePath);
        $templateContent = ob_get_contents();
        ob_end_clean();

        return $templateContent;
    }
}
