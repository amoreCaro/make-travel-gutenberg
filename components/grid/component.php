<?php

if (!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Grid / Post Gallery', THEME))
    ->set_category('common')
    ->set_icon('screenoptions')
    ->set_description(__('Photo grid block that can also be found as Post Gallery.', THEME))
    ->set_keywords([
        __('grid', THEME),
        __('post-gallery', THEME),
        __('post gallery', THEME),
        __('photos', THEME),
        __('gallery', THEME),
    ])

    ->add_tab(__('Photos', THEME), [

        Field::make('media_gallery', 'photos', __('Photos', THEME))
            ->set_type(['image'])
            ->set_duplicates_allowed(false)
            ->set_help_text(__('Click “Select Attachments” to add photos from the media library. You can pick several at once.', THEME)),

    ])

    ->add_tab(__('Settings', THEME), [

        Field::make('text', 'columns', __('Columns', THEME))
            ->set_attribute('type', 'number')
            ->set_attribute('min', '1')
            ->set_attribute('max', '4')
            ->set_attribute('step', '1')
            ->set_default_value('2')
            ->set_help_text(__('Number of columns on desktop (1–4). On smaller screens the grid collapses so photos stay readable.', THEME)),

    ])

    ->set_render_callback(function ($fields) {

        $max_columns = 4;

        $columns = absint($fields['columns'] ?? 2);
        $columns = min($max_columns, max(1, $columns));

        $items  = is_array($fields['photos'] ?? null) ? $fields['photos'] : [];
        $photos = [];

        foreach ($items as $index => $item) {
            $image_id = is_array($item)
                ? absint($item['image'] ?? 0)
                : absint($item);

            if (!$image_id) {
                continue;
            }

            $src         = wp_get_attachment_image_url($image_id, 'large');
            $full        = wp_get_attachment_image_url($image_id, 'full') ?: $src;
            $placeholder = wp_get_attachment_image_url($image_id, 'thumbnail') ?: $src;

            if (!$src) {
                continue;
            }

            $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
            if ($alt === '') {
                $alt = get_the_title($image_id) ?: sprintf(__('Grid photo %d', THEME), $index + 1);
            }

            $photos[] = [
                'id'          => $image_id,
                'src'         => $src,
                'full'        => $full,
                'placeholder' => $placeholder,
                'alt'         => $alt,
            ];
        }

        if (empty($photos)) {
            return;
        }

        $columns = min($columns, count($photos));

        $mobile_cols = $columns === 1 ? 1 : min(2, $columns);
        $tablet_cols = $columns <= 2 ? $columns : min(3, $columns);

        $layout = 'multi';
        if ($columns === 1) {
            $layout = 'single';
        } elseif ($columns === 2) {
            $layout = 'pair';
        }

        $block_classes = [
            'photo-grid',
            'photo-grid--' . $layout,
        ];

        $fancy_group = 'photo-grid-' . wp_unique_id();
        $base_path   = PATH . '/components/grid/';

        include $base_path . 'templates/default.php';
    });
