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

        Field::make('tab', 'cf_tab_video', __('Video')),

        Field::make('file', 'cf_video', __('Video'))
            ->set_type(['video']),

        Field::make('tab', 'cf_tab_gallery', __('Gallery')),

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

if (!function_exists('render_media_block')) {

function render_media_block($post_id = null)
{
    $post_id = $post_id ?: get_the_ID();

    $media = get_post_media_type($post_id);

    $type    = $media['type'];
    $video   = $media['media'];
    $gallery = $media['gallery'] ?? [];

    $container_class =
        'container mx-auto flex flex-col px-[20px] xl:px-[40px] 2xl:px-0 pb-[50px] lg:pb-[100px]';

    $main_class =
        'overflow-hidden h-[250px] md:h-[400px] lg:h-[642px] w-full';

    ?>

    <div class="<?php echo esc_attr($container_class); ?>">

        <?php if ($type === 'video'): ?>

            <div class="<?php echo esc_attr($main_class . ' post-main-video relative'); ?>">

                <video
                    class="w-full h-full object-cover"
                    loop
                    muted
                    playsinline
                    preload="metadata">

                    <source src="<?php echo esc_url($video); ?>" type="video/mp4">

                </video>

                <!-- overlay -->
                <div class="absolute inset-0 bg-black/20"></div>

                <!-- play button -->
                <button class="post__video-play-button absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform z-10">

                    <svg class="w-8 h-8 text-black ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.333-5.89a1.5 1.5 0 000-2.538L6.3 2.841z"></path>
                    </svg>

                </button>

            </div>

        <?php elseif ($type === 'slider'): ?>

            <div class="post-gallery w-full">

                <?php
                $count = count($gallery);

                $grid_class = match ($count) {
                    1 => '',
                    2 => 'grid grid-cols-1 lg:grid-cols-2',
                    3 => 'grid grid-cols-1 lg:grid-cols-2',
                    default => 'grid grid-cols-2',
                };
                ?>

                <div class="<?php echo esc_attr($grid_class); ?>">

                    <?php foreach ($gallery as $index => $img):

                        $wrapper = match ($count) {
                            1 => 'h-[642px]',
                            2 => 'h-[642px]',
                            3 => $index < 2 ? 'h-[321px]' : 'lg:col-span-2 h-[321px]',
                            default => 'h-[321px]',
                        };

                        render_gallery_image(
                            $img['url'],
                            $img['alt'],
                            $wrapper
                        );

                    endforeach; ?>

                </div>

            </div>

        <?php else: ?>

            <img
                class="<?php echo esc_attr($main_class); ?>"
                src="<?php echo esc_url($video); ?>"
                alt="<?php echo esc_attr(get_the_title($post_id)); ?>"
                loading="lazy">

        <?php endif; ?>

    </div>

    <?php
}
}