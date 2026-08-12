<?php

if (!defined('ABSPATH')) {
    exit;
}

$video_classes = [
    'video-banner__video',
    'absolute',
    'inset-0',
    'h-full',
    'w-full',
    'object-cover',
    'opacity-0',
    'transition-opacity',
    'duration-700',
];

if (!empty($enable_blur)) {
    $video_classes[] = 'blur-[14px]';
    $video_classes[] = 'scale-[1.08]';
}

$overlays = [
    'classic' => [
        'main' => 'bg-[linear-gradient(to_right,rgba(0,0,0,0.85)_0%,rgba(0,0,0,0.58)_45%,rgba(0,0,0,0.38)_100%)] dark:bg-[linear-gradient(to_right,rgba(0,0,0,0.9)_0%,rgba(0,0,0,0.65)_45%,rgba(0,0,0,0.45)_100%)]',
        'bottom' => 'bg-[linear-gradient(to_top,rgba(0,0,0,0.75)_0%,rgba(0,0,0,0.4)_45%,transparent_100%)] dark:bg-[linear-gradient(to_top,#0c0c0f_0%,rgba(12,12,15,0.92)_35%,rgba(0,0,0,0.5)_70%,transparent_100%)]',
    ],
    'mosaic' => [
        'main' => 'bg-[linear-gradient(to_right,rgba(0,0,0,0.78)_0%,rgba(0,0,0,0.4)_50%,rgba(0,0,0,0.25)_100%)]',
        'bottom' => 'bg-[linear-gradient(to_top,rgba(0,0,0,0.7)_0%,rgba(0,0,0,0.25)_50%,transparent_100%)]',
    ],
    'cards' => [
        'main' => 'bg-[linear-gradient(to_right,rgba(0,0,0,0.85)_0%,rgba(0,0,0,0.58)_45%,rgba(0,0,0,0.38)_100%)] dark:bg-[linear-gradient(to_right,rgba(0,0,0,0.9)_0%,rgba(0,0,0,0.65)_45%,rgba(0,0,0,0.45)_100%)]',
        'bottom' => 'bg-[linear-gradient(to_top,rgba(0,0,0,0.82)_0%,rgba(0,0,0,0.4)_50%,transparent_100%)]',
    ],
];

$overlay = $overlays[$design] ?? $overlays['classic'];
?>
<div class="video-banner__media absolute inset-0" aria-hidden="true">
    <?php if ($video_url) : ?>
        <video
            class="<?php echo esc_attr(implode(' ', $video_classes)); ?>"
            muted
            loop
            playsinline
            preload="none"
            data-src="<?php echo esc_url($video_url); ?>"
        ></video>
    <?php endif; ?>

    <div class="video-banner__overlay absolute inset-0 <?php echo esc_attr($overlay['main']); ?>"></div>
    <div class="video-banner__overlay-bottom absolute inset-x-0 bottom-0 h-[55%] <?php echo esc_attr($overlay['bottom']); ?>"></div>
    <div class="video-banner__grain absolute inset-0 mix-blend-overlay pointer-events-none opacity-[0.04] dark:opacity-[0.05] bg-video-grain bg-grain"></div>
</div>
