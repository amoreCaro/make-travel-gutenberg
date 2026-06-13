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
]);
}

add_action('wp_enqueue_scripts', 'theme_register_styles');

function theme_register_admin_styles()
{
    wp_enqueue_style( 'theme-admin-style',  PATH_URL . '/assets/dist/css/main.css',[], null );
    wp_enqueue_style( 'google-roboto', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap', [],  null );

}

add_action('admin_enqueue_scripts', 'theme_register_admin_styles');

function theme_admin_scripts() {
    wp_enqueue_style( 'admin_helper', PATH_URL . '/inc/admin/admin.css', array(), '1.0' );
}

add_action('admin_enqueue_scripts', 'theme_admin_scripts');