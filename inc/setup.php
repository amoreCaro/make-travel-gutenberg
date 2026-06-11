<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------
 * ACF Options Page
 * ------------------------------------------------- */
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {

    Container::make('theme_options', 'Global Settings')
        ->set_page_menu_title('Global Settings')
        ->set_page_file('global-settings')

        // HEADER TAB
        ->add_tab('Header', [

            Field::make('radio', 'header_logo_type', 'Logo Type')
                ->set_options([
                    'image' => 'Image Logo',
                    'text'  => 'Text Logo',
                ])
                ->set_default_value('image'),

            Field::make('image', 'header_logo_image', 'Logo Image')
                ->set_conditional_logic([
                    [
                        'field' => 'header_logo_type',
                        'value' => 'image',
                        'compare' => '=',
                    ]
                ]),

            Field::make('text', 'header_logo_text', 'Logo Text')
                ->set_conditional_logic([
                    [
                        'field' => 'header_logo_type',
                        'value' => 'text',
                        'compare' => '=',
                    ]
                ]),

            Field::make('complex', 'header_pages', 'Pages')
                ->add_fields([

                    Field::make('text', 'label', 'Pages Text')
                        ->set_required(true),

                    Field::make('text', 'url', 'Pages URL')
                        ->set_required(true),
                ])
                ->set_min(1),

            Field::make('text', 'header_login_text', 'Login Button Text')
                ->set_default_value('Login'),

            Field::make('text', 'header_logout_text', 'Logout Button Text')
                ->set_default_value('Logout'),
        ])

        // FOOTER TAB (now includes socials)
        ->add_tab('Footer', [

            Field::make('textarea', 'footer_text', 'Disclaimer'),

            Field::make('complex', 'footer_social_icons', 'Social Icons')
                ->add_fields([

                    Field::make('text', 'social_url', 'Social URL'),

                    Field::make('image', 'social_icon', 'SVG Icon'),

                    Field::make('color', 'social_color', 'Dark Color'),

                    Field::make(
                        'color',
                        'social_color_light_mode',
                        'Light Color'
                    ),

                    Field::make(
                        'color',
                        'social_hover_color',
                        'Hover Color'
                    ),

                ])
                ->set_layout('tabbed'),
        ]);
});

add_action('after_setup_theme', function() {
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'textdomain' ),
    ) );
});

add_action('carbon_fields_register_fields', function () {

    Container::make('nav_menu_item', 'Menu Settings')
        ->add_fields([

            Field::make('color', 'menu_bg_color', 'Light theme background')
                ->set_default_value('#ffffff'),

            Field::make('color', 'menu_bg_hover_color', 'Light theme background hover')
                ->set_default_value('#f3f3f3'),

            Field::make('image', 'menu_item_image', 'Menu Image')
                ->set_value_type('url'),

        ]);
});

function theme_setup()
{
    // Увімкнення підтримки thumbnail (featured image)
    add_theme_support('post-thumbnails');

    // (опціонально) розміри зображень
    add_image_size('post-thumb', 800, 450, true);
}

add_action('after_setup_theme', 'theme_setup');


register_nav_menus([
    'header_menu' => __('Header Menu', 'your-theme'),
]);

add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';

    return $mimes;
});

add_action('carbon_fields_register_fields', 'theme_register_category_fields');

function theme_register_category_fields() {
    Container::make('term_meta', 'Category Settings')
        ->where('term_taxonomy', '=', 'category')
        ->add_fields([
            
            Field::make('file', 'category_svg', 'Category icon')
                ->set_value_type('url')
                ->set_type(['image/svg+xml']),

            Field::make('color', 'category_bg', 'Background color'),

            Field::make('color', 'category_text_color', 'Text color'),

            Field::make('select', 'category_decor_type', 'Decor type')
                ->add_options([
                    'default' => 'Default',
                    'h-rounded' => 'Rounded',
                ]),
        ]);
}

add_action('pre_get_posts', function($query) {
    if (!is_admin() && $query->is_main_query() && is_archive()) {
        $query->set('posts_per_page', 12);
    }
});
