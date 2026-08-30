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

        Field::make('media_gallery', 'cf_gallery', __('Gallery'))
            ->set_type(['image'])
            ->set_duplicates_allowed(false)
            ->set_help_text(__('Click “Select Attachments” to add photos from the media library. You can pick several at once.', THEME)),
    ]);


/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

function render_post_media_show_all(string $group, array $photos = []): void
{
    $items = [];

    foreach ($photos as $photo) {
        $src = (string) ($photo['full'] ?? $photo['url'] ?? '');
        if ($src === '') {
            continue;
        }

        $alt = (string) ($photo['alt'] ?? '');
        $items[] = [
            'src'     => $src,
            'alt'     => $alt,
            'caption' => $alt,
        ];
    }
    ?>
    <button
        type="button"
        class="post-media__show-all"
        data-fancybox-trigger="<?php echo esc_attr($group); ?>"
        data-fancybox-items="<?php echo esc_attr(wp_json_encode($items)); ?>"
    >
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" aria-hidden="true">
            <rect x="3" y="5" width="12" height="12" rx="2"/>
            <path d="M9 19h9a2 2 0 0 0 2-2V8"/>
        </svg>
        <span><?php esc_html_e('Show all photos', THEME); ?></span>
    </button>
    <?php
}

function render_post_media_hidden_photos(string $group, array $photos): void
{
    if (empty($photos) || !function_exists('render_fancybox_image')) {
        return;
    }

    echo '<div class="post-media__rest" aria-hidden="true">';
    foreach ($photos as $item) {
        render_fancybox_image([
            'src'   => $item['url'] ?? '',
            'full'  => $item['full'] ?? ($item['url'] ?? ''),
            'alt'   => $item['alt'] ?? '',
            'group' => $group,
        ]);
    }
    echo '</div>';
}

function render_post_media_tile(array $item, string $group, bool $show_all = false, string $extra_class = '', array $all_photos = []): void
{
    $tile_class = trim('post-media__tile ' . $extra_class);
    ?>
    <div class="<?php echo esc_attr($tile_class); ?>">
        <?php
        render_fancybox_image([
            'src'        => $item['url'] ?? '',
            'full'       => $item['full'] ?? ($item['url'] ?? ''),
            'alt'        => $item['alt'] ?? '',
            'group'      => $group,
            'img_class'  => 'post-media__image',
            'link_class' => 'post-media__link',
        ]);

        if ($show_all) {
            render_post_media_show_all($group, $all_photos);
        }
        ?>
    </div>
    <?php
}


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

    $visible_limit   = 4;
    $visible_gallery = array_slice($gallery, 0, $visible_limit);
    $hidden_gallery  = array_slice($gallery, $visible_limit);
    $has_more_photos = !empty($hidden_gallery);
    $visible_count   = count($visible_gallery);

    $container_class =
        'container mx-auto flex flex-col px-[20px] xl:px-[40px] 2xl:px-0 pb-[50px] lg:pb-[100px]';

    $main_class =
        'object-cover overflow-hidden h-[250px] md:h-[400px] lg:h-[642px] w-full rounded-3xl';

    // Gallery-only layout (no hero video / thumbnail)
    $gallery_count = 0;
    $grid_template = '';
    $gallery_items = [];

    if (!$has_hero_gallery && $type === 'slider') {
        $gallery_count = $visible_count;

        $grid_template = match (true) {
            $gallery_count <= 1 => 'md:grid-cols-1 md:grid-rows-1',
            $gallery_count === 2 => 'md:grid-cols-2 md:grid-rows-1',
            $gallery_count === 3 => 'md:grid-cols-[2fr_1fr] md:grid-rows-2',
            default              => 'md:grid-cols-2 md:grid-rows-2',
        };

        foreach ($visible_gallery as $index => $img) {
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

    $lightbox_photos = [];
    if ($hero_kind === 'thumbnail' && $thumbnail) {
        $lightbox_photos[] = [
            'url'  => $thumbnail,
            'full' => $thumbnail_full ?: $thumbnail,
            'alt'  => $title,
        ];
    }
    $lightbox_photos = array_merge($lightbox_photos, $gallery);


    ?>

    <div class="<?php echo esc_attr($container_class); ?>">

        <?php if ($has_hero_gallery) : ?>

            <div class="post-media">
                <div class="post-media__mosaic">
                    <div class="post-media__hero <?php echo $hero_kind === 'video' ? 'post-main-video' : 'post-media__hero--image'; ?>">
                        <?php if ($hero_kind === 'video') : ?>
                            <video class="post-media__video" loop muted playsinline preload="metadata">
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
                                'src'        => $hero_url,
                                'full'       => $thumbnail_full ?: $hero_url,
                                'alt'        => $title,
                                'group'      => $fancy_group,
                                'img_class'  => 'post-media__image post-media__image--hero',
                                'link_class' => 'post-media__link',
                            ]);
                            ?>
                        <?php endif; ?>
                    </div>

                    <div class="post-media__grid">
                        <?php foreach ($visible_gallery as $index => $item) : ?>
                            <?php
                            render_post_media_tile(
                                $item,
                                $fancy_group,
                                $has_more_photos && $index === $visible_count - 1,
                                $visible_count === 1 ? 'post-media__tile--full' : '',
                                $lightbox_photos
                            );
                            ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php render_post_media_hidden_photos($fancy_group, $hidden_gallery); ?>
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
                    <?php foreach ($gallery_items as $index => $item) : ?>
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

                            if ($has_more_photos && $index === $gallery_count - 1) {
                                render_post_media_show_all($fancy_group, $gallery);
                            }
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php render_post_media_hidden_photos($fancy_group, $hidden_gallery); ?>

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
                                'img_class' => 'w-full h-full object-cover',
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
