<?php

if (!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {

    Container::make('block', 'Bento - Block')
        ->set_category('layout')
        ->set_icon('screenoptions')
        ->add_fields([
            Field::make('text', 'crb_bento_test_text', 'Тестове поле')
        ])
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            include get_template_directory() . '/template-parts/components/bento/render.php';
        });
});