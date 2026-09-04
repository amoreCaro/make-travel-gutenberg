<?php

if (!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Block;
use Carbon_Fields\Field\Field;

Block::make(__('Bento'))
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

                        $options = ['' => '— Select Category —'];

                        if (!is_wp_error($terms) && !empty($terms)) {
                            foreach ($terms as $term) {
                                $options[(string) $term->term_id] = $term->name . ' (' . $term->count . ')';
                            }
                        }

                        return $options;
                    })
                    ->set_default_value(''),

                Field::make('text', 'bento_button', __('Button Text'))
                    ->set_help_text('Example: View all posts'),

                Field::make('separator', 'layout_separator', __('Layout')),

                Field::make('select', 'bento_template', __('Block Layout'))
                    ->set_default_value('default')
                    ->set_options([
                        'default' => 'Default',
                        'reverse' => 'Reverse',
                    ]),

                Field::make('select', 'card_template', __('Card Style'))
                    ->set_default_value('default')
                    ->set_options([
                        'default' => 'Default',
                        'slider'  => 'Slider',
                        'video'   => 'Video',
                    ]),
            ]),
    ])

    ->set_render_callback(function ($fields) {

        $items = $fields['bento_categories'] ?? [];

        if (empty($items)) {
            return;
        }

        foreach ($items as $item) {

            $category_id = isset($item['bento_category'])
                ? (int) $item['bento_category']
                : 0;

            if (!$category_id) {
                continue;
            }

            $category = get_term($category_id, 'category');

            if (!$category || is_wp_error($category)) {
                continue;
            }

            $template_type = $item['bento_template'] ?? 'default';
            $bento_button  = $item['bento_button'] ?? '';
            $posts_count   = 6;

            $query = new WP_Query([
                'post_type'      => 'post',
                'posts_per_page' => $posts_count,
                'cat'            => $category_id,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'no_found_rows'  => true,
            ]);

            if ($query->have_posts()) {

                $posts_in_cat        = $query->posts;

                $category_name       = $category->name;
                $category_link       = get_term_link($category);
                $category_svg        = function_exists('get_inline_svg_category_from_acf')
                    ? get_inline_svg_category_from_acf($category_id)
                    : '';
                $category_bg_color   = carbon_get_term_meta($category_id, 'category_bg') ?: '';
                $category_text_color = carbon_get_term_meta($category_id, 'category_text_color') ?: '';
                $category_decor_type = carbon_get_term_meta($category_id, 'category_decor_type') ?: '';

                switch ($template_type) {
                    case 'reverse':
                        include PATH . '/components/bento/templates/reverse.php';
                        break;
                    default:
                        include PATH . '/components/bento/templates/default.php';
                        break;
                }

                wp_reset_postdata();
            }
        }
    });