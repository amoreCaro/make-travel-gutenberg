<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!$has_slider) {
    return;
}

$elements_path = PATH . '/components/video-banner/elements/';
$slide_partial = $slide_partial ?? 'slide-classic.php';
$slide_card_extra = $slide_card_extra ?? 'flex gap-4 h-full min-h-[120px] rounded-2xl p-3.5 md:p-4 transition-colors duration-300 border border-black/[0.06] bg-white shadow-[0_8px_30px_rgba(0,0,0,0.08)] hover:border-black/10 hover:shadow-[0_12px_36px_rgba(0,0,0,0.12)] dark:border-white/12 dark:bg-[#141418] dark:shadow-none dark:hover:border-white/22 dark:hover:bg-[#1a1a20]';
$slide_media_compact = $slide_media_compact ?? false;

$nav_btn =
    'inline-flex items-center justify-center w-9 h-9 rounded-full border border-white/85 bg-transparent text-white shadow-none transition-colors duration-300 hover:bg-white hover:border-white hover:text-black [&.is-disabled]:opacity-35 [&.is-disabled]:pointer-events-none';
?>
<div class="video-banner__slider-wrap relative z-10 w-full pb-6 md:pb-8 <?php echo esc_attr($fade_in); ?> [animation-delay:650ms]">
    <div
        class="video-banner__slider swiper w-full overflow-hidden pl-5 xl:pl-10 [&_.swiper-wrapper]:flex [&_.swiper-wrapper]:items-stretch [&_.swiper-slide]:!h-auto [&_.swiper-slide]:shrink-0"
        data-slides-per-view="<?php echo esc_attr((string) (int) $slides_per_view); ?>"
    >
        <div class="swiper-wrapper">
            <?php foreach ($slides as $slide) :
                $has_link    = $slide['url'] !== '';
                $slide_type  = $slide['type'] ?? 'thumbnail';
                $has_gallery = $slide_type === 'slider' && !empty($slide['gallery']);
                $has_video   = $slide_type === 'video' && !empty($slide['media']);
                $has_media   = $has_gallery || $has_video || $slide['image'] !== '';
                $slide_url   = $has_link ? (string) $slide['url'] : '';

                // Same as bento: gallery keeps media outside the link; content carries the permalink.
                $card_tag     = ($has_gallery && $has_link) ? 'div' : ($has_link ? 'a' : 'div');
                $content_tag  = ($has_gallery && $has_link) ? 'a' : 'div';
                $card_href    = ($card_tag === 'a') ? ' href="' . esc_url($slide_url) . '"' : '';
                $content_href = ($content_tag === 'a') ? ' href="' . esc_url($slide_url) . '"' : '';

                $card_class = 'video-banner__slide group';
                if ($has_gallery) {
                    $card_class .= ' post-card post-card--slider preview-buttons-hover';
                } elseif ($has_video) {
                    $card_class .= ' post-card post-card--video';
                }
                $card_class .= ' ' . $slide_card_extra;
                ?>
                <div class="swiper-slide !h-auto">
                    <<?php echo $card_tag; ?><?php echo $card_href; ?> class="<?php echo esc_attr($card_class); ?>">
                        <?php include $elements_path . $slide_partial; ?>
                    </<?php echo $card_tag; ?>>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="video-banner__slider-nav mt-4 flex items-center justify-end gap-2 px-5 xl:px-10">
        <button
            type="button"
            class="video-banner__slider-prev <?php echo esc_attr($nav_btn); ?>"
            aria-label="<?php esc_attr_e('Previous slide', THEME); ?>"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <button
            type="button"
            class="video-banner__slider-next <?php echo esc_attr($nav_btn); ?>"
            aria-label="<?php esc_attr_e('Next slide', THEME); ?>"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>
</div>
