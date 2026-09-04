<?php

if (!defined('ABSPATH')) {
    exit;
}

$img_class = 'h-full w-full object-cover';
$compact   = $slide_media_compact ?? false;
$content_tag = $content_tag ?? 'div';
$content_href = $content_href ?? '';
$content_pointer = $content_tag === 'a' ? 'pointer-events-auto' : 'pointer-events-none';
?>
<?php if ($has_media) : ?>
    <div class="video-banner__slide-media absolute inset-0 overflow-hidden bg-zinc-100 dark:bg-white/5 [&_.slider]:h-full [&_.slider]:w-full [&_.post-card__video]:h-full [&_.post-card__video]:w-full [&_.slider_.swiper-slide]:h-full">
        <?php include PATH . '/components/video-banner/elements/slide-media.php'; ?>
    </div>
<?php endif; ?>
<div class="video-banner__slide-tile-shade absolute inset-0 pointer-events-none bg-[linear-gradient(to_top,rgba(0,0,0,0.78)_0%,rgba(0,0,0,0.2)_55%,transparent_100%)]"></div>
<<?php echo $content_tag; ?><?php echo $content_href; ?> class="absolute inset-x-0 bottom-0 p-3.5 md:p-4 z-10 <?php echo esc_attr($content_pointer); ?>">
    <h3 class="video-banner__slide-title text-sm md:text-base font-medium tracking-tight line-clamp-2 text-white [text-shadow:0_2px_12px_rgba(0,0,0,0.45)]">
        <?php echo esc_html($slide['title']); ?>
    </h3>
</<?php echo $content_tag; ?>>
