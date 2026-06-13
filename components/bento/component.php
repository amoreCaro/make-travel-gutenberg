<?php

if (!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Block;
use Carbon_Fields\Field\Field;

Block::make(__('Bento'))
    ->set_category('media')
    ->set_icon('grid-view')

    ->add_fields([

        Field::make('complex', 'bento_categories', __('Bento Sections'))
            ->set_layout('tabbed-horizontal')
            ->add_fields([

                Field::make('separator', 'content_separator', __('Content')),

                Field::make('select', 'bento_category', __('Category'))
                    ->set_required(true)
                    ->set_options(function () {

                        $terms = get_terms([
                            'taxonomy'   => 'category',
                            'hide_empty' => false,
                            'orderby'    => 'name',
                            'order'      => 'ASC',
                        ]);

                        $options = [
                            '' => '— Select Category —',
                        ];

                        if (!is_wp_error($terms) && !empty($terms)) {
                            foreach ($terms as $term) {
                                $options[$term->term_id] = "{$term->name} ({$term->count})";
                            }
                        }

                        return $options;
                    }),

                Field::make('text', 'bento_button', __('Button Text')),
                Field::make('separator', 'layout_separator', __('Layout')),
                Field::make('select', 'bento_template', __('Template'))
                    ->set_default_value('default')
                    ->set_options([
                        'default' => 'Default',
                        'reverse' => 'Reverse',
                    ]),
            ]),
    ])

    ->set_render_callback(function ($fields) {

        $items = $fields['bento_categories'] ?? [];

        if (empty($items)) {
            return;
        }

        foreach ($items as $item) {

            $category_id = !empty($item['bento_category'])
                ? (int) $item['bento_category']
                : 0;

            if (!$category_id) {
                continue;
            }

            $category_obj = get_term($category_id, 'category');
            if (!$category_obj) continue;

            $icon_url = carbon_get_term_meta($category_id, 'category_svg');
            $category_svg = cf_get_inline_svg($icon_url);

            $category_bg_color   = carbon_get_term_meta($category_id, 'category_bg');
            $category_text_color = carbon_get_term_meta($category_id, 'category_text_color');
            $category_decor_type = carbon_get_term_meta($category_id, 'category_decor_type');

            $template_type = $item['bento_template'] ?? 'default';

            /**
             * Posts
             */
            $query = new WP_Query([
                'post_type'      => 'post',
                'posts_per_page' => 6,
                'cat'            => $category_id,
            ]);

            $posts_in_cat = $query->posts;

            if (!empty($posts_in_cat)) {

                $category_name  = $category_obj->name;
                $category_link  = get_category_link($category_id);
                $bento_button   = $item['bento_button'] ?? '';

                $base_path = get_template_directory() . '/components/bento/templates/';

                switch ($template_type) {
                    case 'reverse':
                        include $base_path . 'reverse.php';
                        break;

                    default:
                        include $base_path . 'default.php';
                        break;
                }

                wp_reset_postdata();
            }
        }
    });