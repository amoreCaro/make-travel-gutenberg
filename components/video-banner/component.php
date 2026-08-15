<?php

if (!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Video Banner', THEME))
    ->set_category('common')
    ->set_icon('format-video')
    ->set_description(__('Full-bleed video background with overlay text, CTA and optional bottom slider.', THEME))

    ->add_tab(__('Layout', THEME), [

        Field::make('select', 'content_align', __('Content alignment'))
            ->set_options([
                'left'   => __('Left', THEME),
                'center' => __('Center', THEME),
            ])
            ->set_default_value('left'),

        Field::make('select', 'enable_blur', __('Background blur'))
            ->set_options([
                'no'  => __('Off', THEME),
                'yes' => __('On', THEME),
            ])
            ->set_default_value('no'),
    ])

    ->add_tab(__('Media', THEME), [
        Field::make('file', 'video', __('Background video'))
            ->set_type(['video'])
            ->set_required(true)
            ->set_help_text(__('Use a short muted MP4 (10–20s, under ~8MB) for best performance.', THEME)),
    ])

    ->add_tab(__('Content', THEME), [
        Field::make('text', 'label', __('Label'))
            ->set_default_value('Discover'),

        Field::make('text', 'title', __('Title'))
            ->set_required(true)
            ->set_default_value('New Places. Real Adventures.'),

        Field::make('textarea', 'text', __('Text'))
            ->set_rows(3)
            ->set_default_value('Explore new places and find adventures around you.'),

        Field::make('text', 'button_text', __('Button text'))
            ->set_default_value('Explore destinations'),

        Field::make('text', 'button_url', __('Button URL'))
            ->set_attribute('type', 'url')
            ->set_help_text(__('Paste the full URL where the button should send the user.', THEME)),
    ])

    ->add_tab(__('Slider', THEME), [
        Field::make('select', 'design', __('Design'))
            ->set_options([
                'classic' => __('Classic — text left + story cards', THEME),
                'mosaic'  => __('Mosaic — photo tiles (Where Next style)', THEME),
                'cards'   => __('Cards — vertical destination cards', THEME),
            ])
            ->set_default_value('classic')
        ->set_help_text(__('Pick a layout that matches the rest of the homepage.', THEME)),

        Field::make('text', 'slides_per_view', __('Posts visible at once'))
            ->set_attribute('type', 'number')
            ->set_attribute('min', '1')
            ->set_attribute('max', '8')
            ->set_attribute('step', '1')
            ->set_default_value('5')
            ->set_help_text(__('Number of posts visible in the slider at the same time (desktop).', THEME)),

        Field::make('association', 'slider_posts', __('Posts'))
            ->set_help_text(__('Select posts to show in the bottom slider. Leave empty to hide the slider. Order is preserved.', THEME))
            ->set_types([
                [
                    'type'      => 'post',
                    'post_type' => 'post',
                ],
            ])
            ->set_max(12),
    ])

    ->set_render_callback(function ($fields) {

        $legacy_map = [
            'cinematic' => 'mosaic',
            'glass'     => 'classic',
            'split'     => 'classic',
            'editorial' => 'cards',
        ];

        $allowed_designs = ['classic', 'mosaic', 'cards'];
        $design = $fields['design'] ?? 'classic';
        $design = $legacy_map[$design] ?? $design;
        if (!in_array($design, $allowed_designs, true)) {
            $design = 'classic';
        }

        $video_id    = $fields['video'] ?? 0;
        $label       = trim((string) ($fields['label'] ?? ''));
        $title       = trim((string) ($fields['title'] ?? ''));
        $text        = trim((string) ($fields['text'] ?? ''));
        $btn_text    = trim((string) ($fields['button_text'] ?? ''));
        $btn_url     = trim((string) ($fields['button_url'] ?? ''));
        $align       = ($fields['content_align'] ?? 'left') === 'center' ? 'center' : 'left';
        $blur_value  = $fields['enable_blur'] ?? 'no';
        $enable_blur = $blur_value === 'yes' || $blur_value === true || $blur_value === 1 || $blur_value === '1';

        $video_url = $video_id ? wp_get_attachment_url($video_id) : '';
        if (!$video_url) {
            return;
        }

        $has_cta = $btn_text !== '' && $btn_url !== '';

        $align_class = $align === 'center'
            ? 'video-banner__content--center items-center text-center mx-auto'
            : 'items-start text-left';

        /**
         * Slides from manually selected posts (association order preserved).
         */
        $slides = [];
        $slider_posts = is_array($fields['slider_posts'] ?? null) ? $fields['slider_posts'] : [];
        $slider_post_ids = [];

        foreach ($slider_posts as $item) {
            $id = absint($item['id'] ?? 0);
            if ($id && ($item['type'] ?? '') === 'post') {
                $slider_post_ids[] = $id;
            }
        }

        if ($slider_post_ids) {
            $query = new WP_Query([
                'post_type'           => 'post',
                'post__in'            => $slider_post_ids,
                'orderby'             => 'post__in',
                'posts_per_page'      => count($slider_post_ids),
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true,
                'no_found_rows'       => true,
            ]);

            foreach ($query->posts as $post) {
                $post_id    = (int) $post->ID;
                $post_title = get_the_title($post);
                $media_info = function_exists('get_post_media_type')
                    ? get_post_media_type($post_id)
                    : ['type' => 'thumbnail', 'media' => '', 'gallery' => []];

                $media_type = $media_info['type'] ?? 'thumbnail';
                $media_url  = (string) ($media_info['media'] ?? '');
                $gallery    = is_array($media_info['gallery'] ?? null) ? $media_info['gallery'] : [];

                $thumb = '';
                if ($media_type === 'slider' && !empty($gallery[0]['url'])) {
                    $thumb = (string) $gallery[0]['url'];
                } elseif ($media_type === 'thumbnail' && $media_url !== '') {
                    $thumb = $media_url;
                } else {
                    $thumb = get_the_post_thumbnail_url($post, 'medium_large') ?: '';
                }

                $slides[] = [
                    'image'   => $thumb,
                    'title'   => $post_title,
                    'text'    => wp_trim_words(get_the_excerpt($post), 12, '…'),
                    'url'     => get_permalink($post),
                    'alt'     => $post_title,
                    'type'    => $media_type,
                    'media'   => $media_url,
                    'gallery' => $gallery,
                ];
            }

            wp_reset_postdata();
        }

        $has_slider = count($slides) > 0;
        $show_scroll = false;

        $slides_per_view = absint($fields['slides_per_view'] ?? 0);
        if ($slides_per_view < 1) {
            $slides_per_view = 3;
        }
        $slides_per_view = min(8, $slides_per_view);

        $content_width = 'max-w-3xl';
        $title_class = 'text-[36px] leading-[1.1] sm:text-[48px] md:text-[56px] lg:text-[64px] font-medium tracking-tight';

        $section_classes = [
            'video-banner',
            'video-banner--' . $design,
            'relative',
            'isolate',
            'min-h-[70vh]',
            'md:min-h-[85vh]',
            'flex',
            'flex-col',
            'justify-end',
            'overflow-hidden',
            'bg-[#0c1218]',
        ];

        if ($enable_blur) {
            $section_classes[] = 'video-banner--blur';
        }
        if ($has_slider) {
            $section_classes[] = 'video-banner--has-slider';
        }

        $reveal =
            'opacity-0 translate-y-[18px] animate-video-banner-reveal motion-reduce:animate-none motion-reduce:opacity-100 motion-reduce:translate-y-0';
        $fade_in =
            'opacity-0 animate-video-banner-fade-in motion-reduce:animate-none motion-reduce:opacity-100';
        $text_glow = '[text-shadow:0_2px_24px_rgba(0,0,0,0.45)]';

        $main_pad = $has_slider ? 'pb-8 md:pb-10 md:pt-32' : 'pb-24 md:pb-32 md:py-32';

        $base_path = PATH . '/components/video-banner/templates/';

        switch ($design) {
            case 'mosaic':
                include $base_path . 'mosaic.php';
                break;
            case 'cards':
                include $base_path . 'cards.php';
                break;
            default:
                include $base_path . 'classic.php';
                break;
        }
    });
