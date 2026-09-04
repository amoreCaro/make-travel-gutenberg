<?php

if (!defined('ABSPATH')) {
    exit;
}

$img_class = 'h-full w-full object-cover';
$compact   = $slide_media_compact ?? false;
$content_tag = $content_tag ?? 'div';
$content_href = $content_href ?? '';
?>
<?php if ($has_media) : ?>
    <div class="video-banner__slide-media relative aspect-[4/3] overflow-hidden bg-white/5 [&_.slider]:h-full [&_.slider]:w-full [&_.post-card__video]:h-full [&_.post-card__video]:w-full [&_.slider_.swiper-slide]:h-full">
        <?php include PATH . '/components/video-banner/elements/slide-media.php'; ?>
    </div>
<?php endif; ?>
<<?php echo $content_tag; ?><?php echo $content_href; ?> class="flex flex-col gap-1.5 p-4 md:p-5">
    <h3 class="video-banner__slide-title text-sm md:text-base font-medium tracking-tight line-clamp-2 text-white">
        <?php echo esc_html($slide['title']); ?>
    </h3>
    <?php if ($slide['text'] !== '') : ?>
        <p class="video-banner__slide-text text-xs md:text-sm leading-relaxed line-clamp-2 text-white/55">
            <?php echo esc_html($slide['text']); ?>
        </p>
    <?php endif; ?>
</<?php echo $content_tag; ?>>
