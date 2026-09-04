
<?php

if (!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Carbon_Fields;

/*
|--------------------------------------------------------------------------
| Load Carbon Fields
|--------------------------------------------------------------------------
*/

add_action('after_setup_theme', function () {

    // Composer autoload
    require_once get_template_directory() . '/vendor/autoload.php';

    // Boot Carbon Fields
    Carbon_Fields::boot();
});

/*
|--------------------------------------------------------------------------
| Register Gutenberg Blocks
|--------------------------------------------------------------------------
*/

add_action(
    'carbon_fields_register_fields',
    'theme_register_carbon_fields_blocks'
);

function theme_register_carbon_fields_blocks()
{
    require_once get_template_directory() . '/components/bento/component.php';
    require_once get_template_directory() . '/components/media-menu/component.php';
    require_once get_template_directory() . '/components/fancybox/component.php';
    require_once get_template_directory() . '/components/media/component.php';
    require_once get_template_directory() . '/components/hero/component.php';
    require_once get_template_directory() . '/components/video-banner/component.php';
    require_once get_template_directory() . '/components/grid/component.php';
    require_once get_template_directory() . '/components/hero-grid/component.php';
}
