<?php

if (!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/*
|--------------------------------------------------------------------------
| POST META
|--------------------------------------------------------------------------
*/

Container::make('post_meta', __('Media'))
    ->where('post_type', '=', 'post')
    ->add_fields([
        Field::make('file', 'cf_video', __('Video'))
            ->set_type(['video']),

        Field::make('complex', 'cf_gallery', __('Gallery'))
            ->set_max(4)
            ->add_fields([
                Field::make('image', 'cf_image', __('Image')),
            ]),
    ]);


/*
|--------------------------------------------------------------------------
| Render
|--------------------------------------------------------------------------
*/

function render_media_block($post_id = null)
{
    $post_id = $post_id ?: get_the_ID();

    $media = get_post_media_type($post_id);

    $type    = $media['type'] ?? 'none';
    $media_url = $media['media'] ?? '';
    $gallery = $media['gallery'] ?? [];

    if ($type === 'none' || empty($media_url) && empty($gallery)) {
        return;
    }

    $container_class =
        'container mx-auto flex flex-col px-[20px] xl:px-[40px] 2xl:px-0 pb-[50px] lg:pb-[100px]';

    $main_class =
        'overflow-hidden h-[250px] md:h-[400px] lg:h-[642px] w-full';

    ?>

    <div class="<?php echo esc_attr($container_class); ?>">

        <?php if ($type === 'video'): ?>

            <div class="<?php echo esc_attr($main_class . ' relative'); ?> post-main-video">
                <video class="w-full h-full object-cover" loop muted playsinline>
                    <source src="<?php echo esc_url($media_url); ?>" type="video/mp4">
                </video>
                <button class="post__video-play-button absolute inset-1/2 -translate-x-1/2 -translate-y-1/2 w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform" >
                    <svg class="w-8 h-8 text-black ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.333-5.89a1.5 1.5 0 000-2.538L6.3 2.841z"></path>
                    </svg>
                </button>
            </div>

        <?php elseif ($type === 'slider'): ?>

            <div class="post-gallery w-full">

                <?php foreach ($gallery as $img): ?>
                    <img
                        src="<?php echo esc_url($img['url']); ?>"
                        alt="<?php echo esc_attr($img['alt']); ?>"
                        class="<?php echo esc_attr($main_class); ?>">
                <?php endforeach; ?>

            </div>

        <?php elseif ($type === 'thumbnail'): ?>

            <img
                src="<?php echo esc_url($media_url); ?>"
                alt="<?php echo esc_attr(get_the_title($post_id)); ?>"
                class="<?php echo esc_attr($main_class); ?>"
                loading="lazy">

        <?php endif; ?>

    </div>

    <?php
}