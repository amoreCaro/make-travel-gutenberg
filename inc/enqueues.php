<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue theme styles and scripts for the front-end
 */
function theme_register_styles()
{
    // CSS
    wp_enqueue_style( 'theme-style', PATH_URL . '/assets/dist/css/main.css', [], null );
    // перенести шривти в файл 
    wp_enqueue_style( 'google-roboto', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap', [],  null );
    // Swiper CSS
    wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], null );
    // Swiper JS
    wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], null, true );
    // JS
    wp_enqueue_script( 'theme-script', PATH_URL . '/assets/dist/js/main.js', [], null, true );

    // Nonce for  sign in / sign up modal
    wp_localize_script('theme-script', 'theme', [
        'ajax_url'        => admin_url('admin-ajax.php'),
        'nonce_register'  => wp_create_nonce('register_user_nonce'),
        'nonce_login'     => wp_create_nonce('login_user_nonce'),
        'post_like_nonce' => wp_create_nonce('post_like_nonce'),
        'post_save_nonce' => wp_create_nonce('post_save_nonce'),
        'create_post_nonce' => wp_create_nonce('theme_create_post'),
        'load_more_posts_nonce' => wp_create_nonce('load_more_posts_nonce'),
        'submit_comment_nonce' => wp_create_nonce('submit_comment_nonce'),
        'delete_comment_nonce' => wp_create_nonce('delete_comment_nonce'),
        'submit_contact_nonce' => wp_create_nonce('submit_contact_nonce'),
        'contact_page_id' => is_page_template('templates/page-contact.php') ? get_queried_object_id() : 0,
    ]);
}

add_action('wp_enqueue_scripts', 'theme_register_styles');

function theme_register_admin_styles()
{
    // Do not load frontend Tailwind globally in wp-admin.
    // Preflight (img { height: auto }, button resets, .hidden, .close)
    // breaks the media library so images cannot be selected.
    wp_enqueue_style( 'google-roboto', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap', [],  null );
}

add_action('admin_enqueue_scripts', 'theme_register_admin_styles');

function theme_admin_scripts() {
    wp_enqueue_style( 'admin_helper', PATH_URL . '/inc/admin/admin.css', array(), '1.1' );

    wp_enqueue_script(
        'theme-media-gallery-multiselect',
        PATH_URL . '/inc/admin/media-gallery-multiselect.js',
        array('media-models', 'media-views'),
        '1.0.0',
        false
    );
}

add_action('admin_enqueue_scripts', 'theme_admin_scripts');