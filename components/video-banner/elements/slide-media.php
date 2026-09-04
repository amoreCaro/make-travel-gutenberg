<?php

if (!defined('ABSPATH')) {
    exit;
}

$type        = $slide['type'] ?? 'thumbnail';
$gallery     = is_array($slide['gallery'] ?? null) ? $slide['gallery'] : [];
$media_url   = (string) ($slide['media'] ?? '');
$image       = (string) ($slide['image'] ?? '');
$alt         = (string) ($slide['alt'] ?? '');
$has_gallery = $type === 'slider' && !empty($gallery);
$has_video   = $type === 'video' && $media_url !== '';
$icon_size   = $compact ? 'w-8 h-8' : 'w-11 h-11';
$svg_size    = $compact ? 'w-4 h-4' : 'w-6 h-6';

if ($has_gallery) :
    $nav_btn_size = $compact ? 'w-6 h-6 left-1 right-auto' : 'w-8 h-8 left-2 md:left-3';
    $nav_btn_next = $compact ? 'w-6 h-6 right-1 left-auto' : 'w-8 h-8 right-2 md:right-3';
    $nav_icon     = $compact ? 'h-3 w-3' : 'h-4 w-4';
    ?>
    <div class="swiper slider video-banner__slide-gallery w-full h-full overflow-hidden relative">
        <div class="swiper-wrapper">
            <?php foreach ($gallery as $item) :
                $img_url = (string) ($item['url'] ?? '');
                $img_alt = (string) ($item['alt'] ?? $alt);
                if ($img_url === '') {
                    continue;
                }
                ?>
                <div class="swiper-slide !h-full">
                    <img
                        data-src="<?php echo esc_url($img_url); ?>"
                        src="<?php echo esc_url($img_url); ?>"
                        alt="<?php echo esc_attr($img_alt); ?>"
                        class="<?php echo esc_attr($img_class); ?>"
                        loading="lazy"
                        decoding="async"
                    >
                </div>
            <?php endforeach; ?>
        </div>
        <button
            type="button"
            class="slider__prev absolute top-1/2 -translate-y-1/2 z-20 rounded-full bg-white/90 text-gray-600 flex items-center justify-center shadow-md transition hover:scale-110 hover:bg-white hover:text-gray-900 active:scale-95 <?php echo esc_attr($nav_btn_size); ?>"
            aria-label="<?php esc_attr_e('Previous image', THEME); ?>"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="<?php echo esc_attr($nav_icon); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5 8.25 12l7.5-7.5"/>
            </svg>
        </button>
        <button
            type="button"
            class="slider__next absolute top-1/2 -translate-y-1/2 z-20 rounded-full bg-white/90 text-gray-600 flex items-center justify-center shadow-md transition hover:scale-110 hover:bg-white hover:text-gray-900 active:scale-95 <?php echo esc_attr($nav_btn_next); ?>"
            aria-label="<?php esc_attr_e('Next image', THEME); ?>"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="<?php echo esc_attr($nav_icon); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
            </svg>
        </button>
        <div class="slider__pagination swiper-pagination hidden"></div>
    </div>
    <?php
elseif ($has_video) :
    ?>
    <video class="post-card__video w-full h-full object-cover" loop muted playsinline preload="metadata">
        <source src="<?php echo esc_url($media_url); ?>" type="video/mp4">
    </video>
    <div class="absolute inset-0 pointer-events-none">
        <div class="post-card__loading hidden absolute inset-0 z-20 flex items-center justify-center">
            <span class="dot"></span><span class="dot"></span><span class="dot"></span>
        </div>
        <div class="post-card__video-icon absolute inset-0 z-10 flex items-center justify-center">
            <span class="bg-black/60 flex items-center justify-center rounded-full border border-white text-white <?php echo esc_attr($icon_size); ?>">
                <svg class="<?php echo esc_attr($svg_size); ?>" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M17.13 7.9799C20.96 10.1899 20.96 13.8099 17.13 16.0199L14.04 17.7999L10.95 19.5799C7.13 21.7899 4 19.9799 4 15.5599V11.9999V8.43989C4 4.01989 7.13 2.2099 10.96 4.4199L13.21 5.7199"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
        </div>
    </div>
    <?php
elseif ($image !== '') :
    ?>
    <img
        data-src="<?php echo esc_url($image); ?>"
        src="<?php echo esc_url($image); ?>"
        alt="<?php echo esc_attr($alt); ?>"
        class="<?php echo esc_attr($img_class); ?> transition-transform duration-500 group-hover:scale-105"
        loading="lazy"
        decoding="async"
    >
    <?php
endif;
