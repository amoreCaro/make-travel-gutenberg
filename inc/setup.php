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
                ->set_default_value('text'),

            Field::make('image', 'header_logo_image', 'Logo Image')
                ->set_conditional_logic([
                    [
                        'field' => 'header_logo_type',
                        'value' => 'image',
                        'compare' => '=',
                    ]
                ])
                ->set_required(true),

            Field::make('text', 'header_logo_text', 'Logo Text')
                ->set_conditional_logic([
                    [
                        'field' => 'header_logo_type',
                        'value' => 'text',
                        'compare' => '=',
                    ]
                ])
                ->set_required(true),


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
                ])
                ->set_required(true),

            Field::make('text', 'logo_text', 'Logo Text')
            ->set_default_value('Make Travel')
                ->set_conditional_logic([
                    [
                        'field' => 'footer_logo_type',
                        'value' => 'text',
                        'compare' => '=',
                    ]
                ])
                ->set_required(true),

            Field::make('textarea', 'footer_disclaimer', 'Disclaimer')
                ->set_default_value('A premium tech publication dedicated to delivering fresh tech perspectives, startup ecosystem deep-dives, and honest gadget reviews to a global audience of forward-thinkers.'),

            Field::make('text', 'categories_title', __('Categories title'))
                ->set_default_value('Categories'),
            Field::make('association', 'footer_categories', __('Categories'))
                ->set_types([
                    [
                        'type'     => 'term',
                        'taxonomy' => 'category',
                    ],
                ])->set_required(true),

            Field::make('text', 'locations_title', __('Locations title'))
                ->set_default_value('Locations'),
            Field::make('association', 'footer_locations', __('Locations'))
                ->set_types([
                    [
                        'type'     => 'term',
                        'taxonomy' => 'locations',
                    ],
                ]),


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

add_action('carbon_fields_register_fields', function () {
    Container::make('post_meta', __('Contact Page', THEME))
        ->where('post_type', '=', 'page')
        ->where('post_template', '=', 'templates/page-contact.php')

        ->add_tab(__('Contact', THEME), [
            Field::make('text', 'contact_button_text', __('Open form button', THEME))
                ->set_default_value(__('Message Us', THEME)),
        ])

        ->add_tab(__('Modal', THEME), [
            Field::make('separator', 'contact_modal_sep_header', __('Header', THEME)),

            Field::make('text', 'contact_modal_title', __('Title', THEME))
                ->set_default_value(__('Mail to Us', THEME)),

            Field::make('textarea', 'contact_modal_subtitle', __('Subtitle', THEME))
                ->set_rows(2)
                ->set_default_value(__('Tell us what you’re planning, pitching, or wondering.', THEME)),

            Field::make('separator', 'contact_modal_sep_name', __('Name field', THEME)),

            Field::make('text', 'contact_modal_name_label', __('Label', THEME))
                ->set_width(33)
                ->set_default_value(__('Full Name', THEME)),

            Field::make('text', 'contact_modal_name_placeholder', __('Placeholder', THEME))
                ->set_width(33)
                ->set_default_value(__('Your Full Name', THEME)),

            Field::make('text', 'contact_modal_name_error', __('Error message', THEME))
                ->set_width(33)
                ->set_default_value(__('Please enter your name.', THEME)),

            Field::make('separator', 'contact_modal_sep_email', __('Email field', THEME)),

            Field::make('text', 'contact_modal_email_label', __('Label', THEME))
                ->set_width(33)
                ->set_default_value(__('Email Address', THEME)),

            Field::make('text', 'contact_modal_email_placeholder', __('Placeholder', THEME))
                ->set_width(33)
                ->set_default_value(__('you@example.com', THEME)),

            Field::make('text', 'contact_modal_email_error', __('Error message', THEME))
                ->set_width(33)
                ->set_default_value(__('Please enter a valid email address.', THEME)),

            Field::make('separator', 'contact_modal_sep_message', __('Message field', THEME)),

            Field::make('text', 'contact_modal_message_label', __('Label', THEME))
                ->set_width(33)
                ->set_default_value(__('Message', THEME)),

            Field::make('text', 'contact_modal_message_placeholder', __('Placeholder', THEME))
                ->set_width(33)
                ->set_default_value(__('Write Your Message...', THEME)),

            Field::make('text', 'contact_modal_message_error', __('Error message', THEME))
                ->set_width(33)
                ->set_default_value(__('Please enter a message.', THEME)),

            Field::make('separator', 'contact_modal_sep_actions', __('Actions & status', THEME)),

            Field::make('text', 'contact_modal_submit', __('Submit button', THEME))
                ->set_width(50)
                ->set_default_value(__('Send Message', THEME)),

            Field::make('text', 'contact_modal_sending', __('Sending label', THEME))
                ->set_width(50)
                ->set_default_value(__('Sending…', THEME)),

            Field::make('text', 'contact_modal_success', __('Success message', THEME))
                ->set_default_value(__('Thanks! Your message has been sent.', THEME)),

            Field::make('text', 'contact_modal_close', __('Close button label', THEME))
                ->set_help_text(__('Used as the accessible name of the close icon.', THEME))
                ->set_default_value(__('Close contact form', THEME)),

            Field::make('text', 'contact_modal_error_generic', __('Generic error', THEME))
                ->set_width(50)
                ->set_default_value(__('Something went wrong. Please try again.', THEME)),

            Field::make('text', 'contact_modal_error_network', __('Network error', THEME))
                ->set_width(50)
                ->set_default_value(__('Network error. Please try again.', THEME)),
        ])

        ->add_tab(__('Background', THEME), [
            Field::make('radio', 'contact_bg_type', __('Background media', THEME))
                ->set_options([
                    'none'  => __('None', THEME),
                    'image' => __('Image', THEME),
                    'video' => __('Video', THEME),
                ])
                ->set_default_value('none'),

            Field::make('image', 'contact_bg_image', __('Background image', THEME))
                ->set_help_text(__('Used as the page background when Image is selected.', THEME))
                ->set_conditional_logic([
                    [
                        'field'   => 'contact_bg_type',
                        'value'   => 'image',
                        'compare' => '=',
                    ],
                ]),

            Field::make('file', 'contact_bg_video', __('Background video', THEME))
                ->set_type(['video'])
                ->set_help_text(__('Use a short muted MP4 (10–20s, under ~8MB) for best performance.', THEME))
                ->set_conditional_logic([
                    [
                        'field'   => 'contact_bg_type',
                        'value'   => 'video',
                        'compare' => '=',
                    ],
                ]),
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

    // Tailwind only inside the editor canvas, not on wp-admin chrome / media modal.
    add_theme_support('editor-styles');
    add_editor_style('assets/dist/css/main.css');
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