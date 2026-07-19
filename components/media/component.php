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
               Field::make('image', 'cf_image', __('Image'))
                            ->set_required(true),
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

    $type      = $media['type'] ?? 'none';
    $media_url = $media['media'] ?? '';
    $gallery   = $media['gallery'] ?? [];

    if ($type === 'none' || empty($media_url) && empty($gallery)) {
        return;
    }

    $container_class =
        'container mx-auto flex flex-col px-[20px] xl:px-[40px] 2xl:px-0 pb-[50px] lg:pb-[100px]';

    $main_class =
        'object-cover overflow-hidden h-[250px] md:h-[400px] lg:h-[642px] w-full rounded-3xl';

    // Підготовка галереї: рахуємо кількість фото, обираємо grid-шаблон
    // та заздалегідь визначаємо позицію кожного фото в сітці
    $gallery_count = 0;
    $grid_template = '';
    $gallery_items = [];

    if ($type === 'slider') {
        $gallery_count = count($gallery);

        $grid_template = match (true) {
            $gallery_count <= 1 => 'md:grid-cols-1 md:grid-rows-1',
            $gallery_count === 2 => 'md:grid-cols-2 md:grid-rows-1',
            $gallery_count === 3 => 'md:grid-cols-[2fr_1fr] md:grid-rows-2',
            default              => 'md:grid-cols-2 md:grid-rows-2', // 4 фото — рівномірна сітка 2x2
        };

        foreach ($gallery as $index => $img) {
            $position_class = match (true) {
                $gallery_count <= 2 => '',
                $gallery_count === 3 && $index === 0 => 'md:col-start-1 md:row-start-1 md:row-span-2',
                $gallery_count === 3 && $index === 1 => 'md:col-start-2 md:row-start-1',
                $gallery_count === 3 && $index === 2 => 'md:col-start-2 md:row-start-2',
                default => '', // 4 фото — однакові клітинки 2x2, позиція визначається grid-flow автоматично
            };

            $gallery_items[] = [
                'url'            => $img['url'],
                'alt'            => $img['alt'],
                'position_class' => $position_class,
            ];
        }
    }

    ?>

    <div class="<?php echo esc_attr($container_class); ?>">

        <?php if ($type === 'video'): ?>

            <div class="<?php echo esc_attr($main_class . ' relative'); ?> post-main-video">
                <video class="w-full h-full object-cover" loop muted playsinline>
                    <source src="<?php echo esc_url($media_url); ?>" type="video/mp4">
                </video>
                <button class="post__video-play-button absolute inset-1/2 -translate-x-1/2 -translate-y-1/2 w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-black ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.333-5.89a1.5 1.5 0 000-2.538L6.3 2.841z"></path>
                    </svg>
                </button>
            </div>

        <?php elseif ($type === 'slider'): ?>

            <div class="post-gallery grid grid-cols-1 <?php echo esc_attr($grid_template); ?> gap-2 md:gap-3 h-auto md:h-[400px] lg:h-[642px] w-full">

                <?php foreach ($gallery_items as $item): ?>
                    <div class="group relative overflow-hidden rounded-3xl md:h-full <?php echo esc_attr($item['position_class']); ?>">
                        <img
                            src="<?php echo esc_url($item['url']); ?>"
                            alt="<?php echo esc_attr($item['alt']); ?>"
                            class="w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-105"
                            loading="lazy">
                    </div>
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