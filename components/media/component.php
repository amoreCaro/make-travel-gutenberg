<?php

if (!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Media'))
    ->set_category('media')
    ->set_icon('grid-view')
    ->add_fields([
        Field::make('file', 'cf_video', __('Video'))
            ->set_type(['video']),

        Field::make('complex', 'cf_gallery', __('Gallery'))
            ->set_max(4)
            ->add_fields([
                Field::make('image', 'cf_image', __('Image')),
            ]),
    ])
    ->set_render_callback(function ($fields) {

        // --------------------
        // Data
        // --------------------
        $main_video     = !empty($fields['cf_video'])
            ? wp_get_attachment_url($fields['cf_video'])
            : '';

        $gallery_raw_items = $fields['cf_gallery'] ?? [];

        // Limit to 4 items (Carbon Fields respects set_max, but just in case)
        $gallery_raw_items = array_slice($gallery_raw_items, 0, 4);

        $main_image_url = has_post_thumbnail()
            ? get_the_post_thumbnail_url(get_the_ID(), 'full')
            : '';

        // --------------------
        // Prepare gallery items
        // --------------------
        $gallery_items = [];

        foreach ($gallery_raw_items as $item) {
            $img_id = $item['cf_image'] ?? 0;
            if (!empty($img_id)) {
                $gallery_items[] = [
                    'url' => wp_get_attachment_image_url($img_id, 'large'),
                    'alt' => get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: get_the_title(),
                ];
            }
        }

        $has_main_media = (bool) ($main_video || $main_image_url);
        $has_gallery    = !empty($gallery_items);
        $gallery_count  = count($gallery_items);

        if (!$has_main_media && !$has_gallery) return;

        // --------------------
        // Layout logic
        // --------------------
        $show_split_layout = $has_main_media && $has_gallery;

        // --------------------
        // Classes
        // --------------------
        $gallery_container_class = "post-gallery w-full" . ($show_split_layout ? " lg:basis-1/2" : "");
        $main_media_wrapper_class = $main_video
            ? 'post-main-video video--stopped group relative'
            : 'post-main-image';

        $container_class = "container mx-auto flex flex-col px-[20px] xl:px-[40px] 2xl:px-0 pb-[50px] lg:pb-[100px]"
            . ($show_split_layout ? " lg:flex-row" : "");

        $main_media_class = "overflow-hidden h-[250px] md:h-[400px] lg:h-[642px]"
            . ($show_split_layout ? " lg:basis-1/2" : " w-full");

        ?>

        <div class="<?php echo esc_attr($container_class) ?>">

            <!-- MAIN MEDIA (video or image) -->
            <?php if ($has_main_media) : ?>
                <div class="<?php echo esc_attr("$main_media_class $main_media_wrapper_class") ?>">
                    <?php if ($main_video) : ?>
                        <video class="w-full h-full object-cover" loop muted playsinline preload="metadata">
                            <source src="<?php echo esc_url($main_video) ?>" type="video/mp4">
                        </video>
                        <button class="post__video-play-button absolute inset-1/2 -translate-x-1/2 -translate-y-1/2
                            w-20 h-20 bg-white rounded-full flex items-center justify-center
                            shadow-lg hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-black ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.333-5.89a1.5 1.5 0 000-2.538L6.3 2.841z"/>
                            </svg>
                        </button>
                    <?php elseif ($main_image_url) : ?>
                        <img
                            src="<?php echo esc_url($main_image_url); ?>"
                            alt="<?php echo esc_attr(get_the_title()); ?>"
                            class="w-full h-full object-cover"
                            loading="lazy"
                        >
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- GALLERY -->
            <?php if ($has_gallery) : ?>
                <div class="<?php echo esc_attr($gallery_container_class) ?>">
                    <?php
                    $gallery_grid_class = match($gallery_count) {
                        1 => '',
                        2 => 'grid grid-cols-1 lg:grid-cols-2',
                        3 => 'grid grid-cols-1 lg:grid-cols-2',
                        default => 'grid grid-cols-2',
                    };

                    echo '<div class="' . esc_attr($gallery_grid_class) . '">';

                    foreach ($gallery_items as $index => $img) {
                        $wrapper_class = match($gallery_count) {
                            1 => 'h-[642px]',
                            2 => 'h-[642px]',
                            3 => ($index < 2 ? 'h-[321px]' : 'lg:col-span-2 h-[321px]'),
                            default => 'h-[321px]',
                        };
                        render_gallery_image($img['url'], $img['alt'], $wrapper_class);
                    }

                    echo '</div>';
                    ?>
                </div>
            <?php endif; ?>

        </div>

        <?php
    });