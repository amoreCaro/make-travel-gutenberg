<?php

if (!defined('ABSPATH')) {
    exit;
}

$show_scroll     = true;
$slide_partial   = 'slide-classic.php';
$slide_card_extra = 'flex gap-4 h-full min-h-[120px] rounded-2xl p-3.5 md:p-4 transition-colors duration-300 border border-black/[0.06] bg-white shadow-[0_8px_30px_rgba(0,0,0,0.08)] hover:border-black/10 hover:shadow-[0_12px_36px_rgba(0,0,0,0.12)] dark:border-white/12 dark:bg-[#141418] dark:shadow-none dark:hover:border-white/22 dark:hover:bg-[#1a1a20]';
$slide_media_compact = true;
?>
<section class="<?php echo esc_attr(implode(' ', $section_classes)); ?>">
    <?php
    include PATH . '/components/video-banner/elements/media.php';
    include PATH . '/components/video-banner/elements/content.php';
    include PATH . '/components/video-banner/elements/scroll.php';
    include PATH . '/components/video-banner/elements/slider.php';
    ?>
</section>
