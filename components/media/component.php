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

    $type           = $media['type'] ?? 'none';
    $media_url      = $media['media'] ?? '';
    $gallery        = $media['gallery'] ?? [];
    $video_url      = $media['video'] ?? '';
    $thumbnail      = $media['thumbnail'] ?? '';
    $thumbnail_full = $media['thumbnail_full'] ?? $thumbnail;

    if ($type === 'none' || (empty($media_url) && empty($gallery) && empty($video_url) && empty($thumbnail))) {
        return;
    }

    $hero_url  = !empty($video_url) ? $video_url : $thumbnail;
    $hero_kind = !empty($video_url) ? 'video' : (!empty($thumbnail) ? 'thumbnail' : '');
    $has_gallery = !empty($gallery);
    $has_hero_gallery = $hero_kind !== '' && $has_gallery;
    $fancy_group = 'post-gallery-' . (int) $post_id;

    $container_class =
        'container mx-auto flex flex-col px-[20px] xl:px-[40px] 2xl:px-0 pb-[50px] lg:pb-[100px]';

    $main_class =
        'object-cover overflow-hidden h-[250px] md:h-[400px] lg:h-[642px] w-full rounded-3xl';

    // Gallery-only layout (no hero video / thumbnail)
    $gallery_count = 0;
    $grid_template = '';
    $gallery_items = [];

    if (!$has_hero_gallery && $type === 'slider') {
        $gallery_count = count($gallery);

        $grid_template = match (true) {
            $gallery_count <= 1 => 'md:grid-cols-1 md:grid-rows-1',
            $gallery_count === 2 => 'md:grid-cols-2 md:grid-rows-1',
            $gallery_count === 3 => 'md:grid-cols-[2fr_1fr] md:grid-rows-2',
            default              => 'md:grid-cols-2 md:grid-rows-2',
        };

        foreach ($gallery as $index => $img) {
            $position_class = match (true) {
                $gallery_count <= 2 => '',
                $gallery_count === 3 && $index === 0 => 'md:col-start-1 md:row-start-1 md:row-span-2',
                $gallery_count === 3 && $index === 1 => 'md:col-start-2 md:row-start-1',
                $gallery_count === 3 && $index === 2 => 'md:col-start-2 md:row-start-2',
                default => '',
            };

            $gallery_items[] = [
                'url'            => $img['url'],
                'full'           => $img['full'] ?? $img['url'],
                'alt'            => $img['alt'],
                'position_class' => $position_class,
            ];
        }
    }

    $title = get_the_title($post_id);

    ?>

    <div class="<?php echo esc_attr($container_class); ?>">

        <?php if ($has_hero_gallery) : ?>

            <?php
            $hero_gallery_count = count($gallery);
            $is_pair_layout     = $hero_gallery_count === 1;
            ?>

            <div class="post-media-mosaic w-full">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-5 h-auto lg:h-[642px]">

                    <!-- Hero: video or thumbnail -->
                    <div class="<?php echo $hero_kind === 'video' ? 'post-main-video relative' : 'post__main-image'; ?> overflow-hidden h-[250px] md:h-[400px] lg:h-full rounded-2xl md:rounded-3xl">
                        <?php if ($hero_kind === 'video') : ?>
                            <video class="w-full h-full object-cover" loop muted playsinline preload="metadata">
                                <source src="<?php echo esc_url($hero_url); ?>" type="video/mp4">
                            </video>
                            <button
                                type="button"
                                class="post__video-play-button absolute inset-1/2 -translate-x-1/2 -translate-y-1/2 w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform"
                                aria-label="<?php esc_attr_e('Play video', THEME); ?>"
                            >
                                <svg class="w-8 h-8 text-black ml-1" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.333-5.89a1.5 1.5 0 000-2.538L6.3 2.841z"></path>
                                </svg>
                            </button>
                        <?php else : ?>
                            <?php
                            render_fancybox_image([
                                'src'       => $hero_url,
                                'full'      => $thumbnail_full ?: $hero_url,
                                'alt'       => $title,
                                'group'     => $fancy_group,
                                'img_class' => 'w-full h-full object-cover transition-transform duration-500 hover:scale-[1.02]',
                            ]);
                            ?>
                        <?php endif; ?>
                    </div>

                    <?php if ($is_pair_layout) : ?>
                        <!-- 1 thumbnail + 1 gallery: equal 50/50 -->
                        <?php $item = $gallery[0]; ?>
                        <div class="post__gallery overflow-hidden h-[250px] md:h-[400px] lg:h-full rounded-2xl md:rounded-3xl">
                            <?php
                            render_fancybox_image([
                                'src'       => $item['url'],
                                'full'      => $item['full'] ?? $item['url'],
                                'alt'       => $item['alt'],
                                'group'     => $fancy_group,
                                'img_class' => 'w-full h-full object-cover transition-transform duration-500 hover:scale-[1.02]',
                            ]);
                            ?>
                        </div>
                    <?php else : ?>
                        <!-- Gallery 2x2 -->
                        <div class="post__gallery grid grid-cols-2 gap-4 md:gap-5 h-auto lg:h-full">
                            <?php foreach ($gallery as $item) : ?>
                                <div class="relative overflow-hidden min-h-[160px] lg:h-full rounded-2xl md:rounded-3xl">
                                    <?php
                                    render_fancybox_image([
                                        'src'       => $item['url'],
                                        'full'      => $item['full'] ?? $item['url'],
                                        'alt'       => $item['alt'],
                                        'group'     => $fancy_group,
                                        'img_class' => 'w-full h-full object-cover transition-transform duration-500 hover:scale-[1.02]',
                                    ]);
                                    ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        <?php elseif (!empty($video_url)) : ?>

            <div class="<?php echo esc_attr($main_class . ' relative'); ?> post-main-video">
                <video class="w-full h-full object-cover" loop muted playsinline>
                    <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                </video>
                <button class="post__video-play-button absolute inset-1/2 -translate-x-1/2 -translate-y-1/2 w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-black ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.333-5.89a1.5 1.5 0 000-2.538L6.3 2.841z"></path>
                    </svg>
                </button>
            </div>

        <?php elseif ($type === 'slider') : ?>

            <?php if ($gallery_count === 4) : ?>

                <div class="post-gallery post-gallery--quad">
                    <?php foreach ($gallery_items as $item) : ?>
                        <div class="post-gallery__tile">
                            <?php
                            render_fancybox_image([
                                'src'        => $item['url'],
                                'full'       => $item['full'] ?? $item['url'],
                                'alt'        => $item['alt'],
                                'group'      => $fancy_group,
                                'img_class'  => 'w-full h-full object-cover',
                                'link_class' => 'absolute inset-0 block cursor-pointer',
                            ]);
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else : ?>

                <div class="post-gallery grid grid-cols-1 <?php echo esc_attr($grid_template); ?> gap-2 md:gap-3 h-auto md:h-[400px] lg:h-[520px] w-full">
                    <?php foreach ($gallery_items as $item) : ?>
                        <div class="relative overflow-hidden rounded-2xl md:rounded-3xl h-[220px] md:h-full <?php echo esc_attr($item['position_class']); ?>">
                            <?php
                            render_fancybox_image([
                                'src'       => $item['url'],
                                'full'      => $item['full'] ?? $item['url'],
                                'alt'       => $item['alt'],
                                'group'     => $fancy_group,
                                'img_class' => 'w-full h-full object-cover transition-transform duration-500 hover:scale-[1.02]',
                            ]);
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>

        <?php elseif (!empty($thumbnail)) : ?>

            <?php
            render_fancybox_image([
                'src'        => $thumbnail,
                'full'       => $thumbnail_full ?: $thumbnail,
                'alt'        => $title,
                'group'      => $fancy_group,
                'img_class'  => $main_class,
                'link_class' => 'block w-full cursor-pointer',
            ]);
            ?>

        <?php endif; ?>

    </div>

    <?php
}
