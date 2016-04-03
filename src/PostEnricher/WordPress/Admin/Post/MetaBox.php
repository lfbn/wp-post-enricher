<?php

namespace PostEnricher\WordPress\Admin\Post;

use PostEnricher\Helper\PluginPathsHelper;
use PostEnricher\Service\TemplatingService;

class MetaBox
{

    public static function init()
    {
        add_meta_box(
            'post-enricher-box',
            'WP Post Enricher',
            array(
                __CLASS__,
                'addPostMetabox'
            ),
            'post'
        );
    }

    public static function addPostMetabox()
    {
        echo TemplatingService::render(
            'post-edit-meta-box',
            array(
                'loadingImgUrl' => plugins_url('static/image/loading.gif', PluginPathsHelper::getPluginMainFile())
            )
        );
    }
}
