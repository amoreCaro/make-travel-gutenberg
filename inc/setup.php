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
            Field::make('radio', 'footer_logo_type', 'Logo Type')
                ->set_options([
                    'image' => 'Image Logo',
                    'text'  => 'Text Logo',
                ])
                ->set_default_value('text'),

            Field::make('image', 'footer_logo_image', 'Logo Image')
                ->set_conditional_logic([
                    [
                        'field' => 'footer_logo_type',
                        'value' => 'image',
                        'compare' => '=',
                    ]
                ]),

            Field::make('text', 'logo_text', 'Logo Text')
            ->set_default_value('Make Travel')
                ->set_conditional_logic([
                    [
                        'field' => 'footer_logo_type',
                        'value' => 'text',
                        'compare' => '=',
                    ]
                ]),

            Field::make('textarea', 'footer_disclaimer', 'Disclaimer')
                ->set_default_value('A premium tech publication dedicated to delivering fresh tech perspectives, startup ecosystem deep-dives, and honest gadget reviews to a global audience of forward-thinkers.'),

            Field::make('text', 'footer_categories_title', __('Categories title'))
                ->set_default_value('Categories'),
            Field::make('association', 'footer_categories', __('Categories'))
                ->set_types([
                    [
                        'type'     => 'term',
                        'taxonomy' => 'category',
                    ],
                ]),

            Field::make('text', 'footer_contact_title', __('Contact title'))
                ->set_default_value('Contact'),
            Field::make('complex', 'footer_contacts', __('Contact Items'))
                ->setup_labels([
                    'plural_name'   => __('Items'),
                    'singular_name' => __('Item'),
                ])
                ->add_fields([
                    Field::make('text', 'label', __('Label (e.g., Call)'))
                        ->set_width(33),

                    Field::make('text', 'contact_value', __('Value (e.g., +489756412322)'))
                        ->set_width(33),

                    Field::make('text', 'url', __('URL'))
                        ->set_default_value('#')
                        ->set_width(34),
                ])
                ->set_layout('grid'),


Field::make('separator', 'footer_copyright_separator', __('Copyright')),

Field::make('text', 'footer_company_name', __('Company Name'))
    ->set_default_value('Make Travel')
    ->set_help_text(__('Displayed after the © symbol.')),

Field::make('text', 'footer_rights_text', __('Rights Text'))
    ->set_default_value('All rights reserved')
    ->set_help_text(__('Displayed after the company name and year.')),

Field::make('text', 'footer_powered_by_text', __('Powered By Text'))
    ->set_default_value('Powered by WordPress')
    ->set_help_text(__('Displayed after the "|" separator.')),
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
                            ->set_default_value('#3277DF'),
                    ]),
            ]); 
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
                // ->set_value_type('url'),

        ]);
});

add_filter('upload_mimes', function ($mimes) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
});

add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
    if (!$data['type']) {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if ($ext === 'svg' || $ext === 'svgz') {
            $data['type'] = 'image/svg+xml';
            $data['ext']  = $ext;
        }
    }
    return $data;
}, 10, 4);

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

add_action('init', function () {
    add_post_type_support('page', 'excerpt');
});