<?php

if (!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Video Banner', THEME))
    ->set_category('common')
    ->set_icon('format-video')
    ->set_description(__('Full-bleed banner with video, image, gradient or solid color background, overlay text, CTA and optional bottom slider.', THEME))

    ->add_tab(__('Layout', THEME), [

        Field::make('select', 'content_align', __('Content alignment'))
            ->set_options([
                'left'   => __('Left', THEME),
                'center' => __('Center', THEME),
            ])
            ->set_default_value('center'),
    ])

    ->add_tab(__('Media', THEME), [

        Field::make('radio', 'show_media', __('Background type'))
            ->set_options([
                'video'    => __('Video', THEME),
                'image'    => __('Image', THEME),
                'gradient' => __('Gradient', THEME),
                'color'    => __('Solid color', THEME),
            ])
            ->set_default_value('gradient')
            ->set_required(true),

        // ---- Video: required only when show_media = video ----
        Field::make('file', 'video', __('Background video'))
            ->set_type(['video'])
            ->set_required(true)
            ->set_help_text(
                __('Use a short muted MP4 (10–20s, under ~8MB) for best performance.', THEME)
            )
            ->set_conditional_logic([
                [
                    'field' => 'show_media',
                    'value' => 'video',
                ]
            ]),

        // ---- Image: required only when show_media = image ----
        Field::make('image', 'image', __('Background image'))
            ->set_required(true)
            ->set_conditional_logic([
                [
                    'field' => 'show_media',
                    'value' => 'image',
                ]
            ]),

        // ---- Gradient: 2 colors per theme ----
        Field::make('color', 'gradient_from_light', __('Gradient — start color (light theme)'))
            ->set_default_value('#0a0b08')
            ->set_required(true)
            ->set_conditional_logic([
                [
                    'field' => 'show_media',
                    'value' => 'gradient',
                ]
            ]),

        Field::make('color', 'gradient_to_light', __('Gradient — end color (light theme)'))
            ->set_default_value('#c98a3e')
            ->set_required(true)
            ->set_conditional_logic([
                [
                    'field' => 'show_media',
                    'value' => 'gradient',
                ]
            ]),

        Field::make('color', 'gradient_from_dark', __('Gradient — start color (dark theme)'))
            ->set_default_value('#0a0b08')
            ->set_required(true)
            ->set_conditional_logic([
                [
                    'field' => 'show_media',
                    'value' => 'gradient',
                ]
            ]),

        Field::make('color', 'gradient_to_dark', __('Gradient — end color (dark theme)'))
            ->set_default_value('#c98a3e')
            ->set_required(true)
            ->set_conditional_logic([
                [
                    'field' => 'show_media',
                    'value' => 'gradient',
                ]
            ]),

        // ---- Solid color: 1 color per theme ----
        Field::make('color', 'bg_color_light', __('Background color (light theme)'))
            ->set_default_value('#0a0b08')
            ->set_required(true)
            ->set_conditional_logic([
                [
                    'field' => 'show_media',
                    'value' => 'color',
                ]
            ]),

        Field::make('color', 'bg_color_dark', __('Background color (dark theme)'))
            ->set_default_value('#0d0f0b')
            ->set_required(true)
            ->set_conditional_logic([
                [
                    'field' => 'show_media',
                    'value' => 'color',
                ]
            ]),
    ])

    ->add_tab(__('Content', THEME), [
        Field::make('text', 'label', __('Label'))
            ->set_default_value('Discover'),

        Field::make('text', 'title', __('Title'))
            ->set_required(true)
            ->set_default_value('New Places. Real Adventures.'),

        Field::make('text', 'button_text', __('Button text'))
            ->set_default_value('Explore destinations'),

        Field::make('text', 'button_url', __('Button URL'))
            ->set_attribute('type', 'url')
            ->set_help_text(__('Paste the full URL where the button should send the user.', THEME)),
        //  Second Button
        Field::make('text', 'button_2_text', __('Second button text'))
            ->set_default_value('Learn more'),

        Field::make('text', 'button_2_url', __('Second button URL'))
            ->set_attribute('type', 'url')
            ->set_help_text(__('Paste the full URL where the second button should send the user.', THEME)),
    ])

    ->add_tab(__('Slider', THEME), [

        Field::make('checkbox', 'show_slider', __('Show slider'))
            ->set_option_value('yes')
            ->set_default_value(true),
        Field::make('checkbox', 'show_slider_navigation', __('Show slider navigation'))
            ->set_option_value('yes')
            ->set_default_value(true)
            ->set_help_text(__('Show previous and next buttons below the slider.', THEME)),

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
            ->set_help_text(__('Select posts to show in the bottom slider.', THEME))
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

        $allowed_media = ['video', 'image', 'gradient', 'color'];
        $show_media = $fields['show_media'] ?? 'video';
        if (!in_array($show_media, $allowed_media, true)) {
            $show_media = 'video';
        }

        $video_id = absint($fields['video'] ?? 0);
        $image_id = absint($fields['image'] ?? 0);

        $video_url = $video_id ? wp_get_attachment_url($video_id) : '';
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'full') : '';

        $gradient_from_light = trim((string) ($fields['gradient_from_light'] ?? '')) ?: '#f4f1ea';
        $gradient_to_light   = trim((string) ($fields['gradient_to_light'] ?? '')) ?: '#d9d2bd';
        $gradient_from_dark  = trim((string) ($fields['gradient_from_dark'] ?? '')) ?: '#0a0b08';
        $gradient_to_dark    = trim((string) ($fields['gradient_to_dark'] ?? '')) ?: '#6f6d43';
        $gradient_angle      = absint($fields['gradient_angle'] ?? 100);

        $bg_color_light = trim((string) ($fields['bg_color_light'] ?? '')) ?: '#f4f1ea';
        $bg_color_dark  = trim((string) ($fields['bg_color_dark'] ?? '')) ?: '#0d0f0b';

        // Bail only when the chosen media type has no usable asset.
        if ($show_media === 'video' && !$video_url) {
            return;
        }
        if ($show_media === 'image' && !$image_url) {
            return;
        }

        $label       = trim((string) ($fields['label'] ?? ''));
        $title       = trim((string) ($fields['title'] ?? ''));
        $btn_text    = trim((string) ($fields['button_text'] ?? ''));
        $btn_url     = trim((string) ($fields['button_url'] ?? ''));
        $button_2_text = trim((string) ($fields['button_2_text'] ?? ''));
        $button_2_url  = trim((string) ($fields['button_2_url'] ?? ''));
        $has_cta_2 = $button_2_text !== '' && $button_2_url !== '';
        $align       = ($fields['content_align'] ?? 'left') === 'center' ? 'center' : 'left';

        $has_cta = $btn_text !== '' && $btn_url !== '';

        $align_class = $align === 'center'
            ? 'video-banner__content--center items-center text-center mx-auto'
            : 'items-start text-left';

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

        $show_slider = !empty($fields['show_slider']);
        $has_slider = $show_slider && count($slides) > 0;

$show_slider_navigation = $has_slider && !empty($fields['show_slider_navigation']);

        $show_scroll = true;

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
            'video-banner--media-' . $show_media,
            'relative',
            'isolate',
            'min-h-screen',
            'flex',
            'flex-col',
            'justify-end',
            'overflow-hidden',
            'bg-[#0c1218]',
        ];

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