<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define('_S_VERSION', '1.0.0');
define('PATH', get_template_directory());
define('PATH_URL', get_template_directory_uri());
define('THEME', 'blog-theme');
define('VENDOR_PATH', PATH . '/vendor/'); 


require_once VENDOR_PATH . 'autoload.php';

/*
|--------------------------------------------------------------------------
| Carbon Fields
|--------------------------------------------------------------------------
*/

add_action('after_setup_theme', function () {
    \Carbon_Fields\Carbon_Fields::boot();
});

require PATH . '/inc/enqueues.php';
require PATH . '/inc/setup.php';
require PATH . '/inc/carbon-fields.php';
require PATH . '/inc/helpers.php';
require PATH . '/components/fancybox/component.php';
require PATH . '/inc/ajax/auth.php';
require PATH . '/inc/ajax/reactions.php';
require PATH . '/inc/ajax/posts.php';
require PATH . '/inc/ajax/contact.php';
