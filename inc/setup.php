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

    Container::make('theme_options', __('Global Settings'))
        ->set_page_menu_title(__('Global Settings'))
        ->set_page_file('global-settings')

        ->add_tab(__('Header'), [

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

                    Field::make('text', 'label', 'Page Text')
                        ->set_required(true),

                    Field::make('text', 'url', 'Page URL')
                        ->set_required(true),
                ])
                ->set_min(1),

            Field::make('text', 'header_login_text', 'Login Button Text')
                ->set_default_value('Login'),

            Field::make('text', 'header_logout_text', 'Logout Button Text')
                ->set_default_value('Logout'),

        ])

    ->add_tab(__('Footer'), [

        Field::make('textarea', 'footer_text', 'Disclaimer'),

        Field::make('text', 'footer_before_year', 'Text Before Year')
            ->set_default_value('Copyright ©'),

        Field::make('text', 'footer_pre_text', 'Text Before Link')
            ->set_default_value('by'),

        Field::make('text', 'footer_link_text', 'Link Text'),

        Field::make('text', 'footer_link_url', 'Link URL'),

        Field::make('text', 'footer_post_text', 'Text After Link'),

    ])
    ->add_tab(__('Social icons'), [
        Field::make('complex', 'social_icons', __('Social Icons'))
            ->set_layout('tabbed-horizontal')
            ->add_fields([
                Field::make('image', 'icon')
                    ->set_required(true),

                    Field::make('text', 'link', __('Link')),

                    Field::make('color', 'color_dark', __('Color for dark theme'))
                        ->set_default_value('#FFFFFF'),

                    Field::make('color', 'color_light', __('Color for light theme'))
                        ->set_default_value('#000000'),

                    Field::make('color', 'hover_color', __('Hover color'))
                        ->set_default_value('#7D0AF2'),
                ]),
        ]);
});

add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});

add_filter(
    'carbon_fields_should_save_field_value',
    function ($should_save, $value, $field) {

        // тільки поле icon
        if ($field->get_base_name() !== 'icon') {
            return $should_save;
        }

        if (empty($value)) {
            return $should_save;
        }

        $mime = get_post_mime_type((int) $value);

        // забороняємо збереження якщо не svg
        if ($mime !== 'image/svg+xml') {
            return false;
        }

        return $should_save;

    },
    10,
    3
);

add_action('after_setup_theme', function() {
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'textdomain' ),
        'footer_menu' => __( 'Footer Menu', 'textdomain' ),
        'pages_menu' => __( 'Pages Menu', 'textdomain' ),
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
                ->set_value_type('id')
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


/* -------------------------------------------------
 * Locations taxonomy
 * ------------------------------------------------- */
if ( ! function_exists('theme_register_locations_taxonomy') ) {
    function theme_register_locations_taxonomy() {
        $labels = [
            'name'              => 'Locations',
            'singular_name'     => 'Location',
            'search_items'      => 'Search Locations',
            'all_items'         => 'All Locations',
            'parent_item'       => 'Parent Location',
            'parent_item_colon' => 'Parent Location:',
            'edit_item'         => 'Edit Location',
            'update_item'       => 'Update Location',
            'add_new_item'      => 'Add New Location',
            'new_item_name'     => 'New Location Name',
            'menu_name'         => 'Locations',
        ];

        $args = [
            'labels'            => $labels,
            'public'            => true,
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_in_rest'      => true, 
            'rewrite'           => ['slug' => 'location'    
],
        ];

        register_taxonomy('locations', ['post'], $args);
    }
}
add_action('init', 'theme_register_locations_taxonomy');

/**
 * Extend WordPress search (pre_get_posts)
 * - limit to posts
 * - keep default search (title, content, excerpt)
 * - add taxonomy search (category, tag, locations)
 */
add_action('pre_get_posts', function ($query) {

    if (is_admin() || !$query->is_main_query() || !$query->is_search()) {
        return;
    }

    $search = trim($query->get('s'));
    if (!$search) return;

    set_query_var('original_search', $search);

    $slug = sanitize_title($search);

    $tax_query = ['relation' => 'OR'];
    $has_tax = false;

    // category
    if ($cat = get_term_by('slug', $slug, 'category')) {
        $tax_query[] = [
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => $cat->term_id,
        ];
        $has_tax = true;
    }

    // tag
    if ($tag = get_term_by('slug', $slug, 'post_tag')) {
        $tax_query[] = [
            'taxonomy' => 'post_tag',
            'field'    => 'term_id',
            'terms'    => $tag->term_id,
        ];
        $has_tax = true;
    }

    // locations
    if ($location = get_term_by('slug', $slug, 'locations')) {
        $tax_query[] = [
            'taxonomy' => 'locations',
            'field'    => 'term_id',
            'terms'    => $location->term_id,
        ];
        $has_tax = true;
    }

    if ($has_tax) {
        $query->set('tax_query', $tax_query);
        $query->set('s', '');
    }

    $query->set('posts_per_page', 12);
    $query->set('post_type', 'post');
});