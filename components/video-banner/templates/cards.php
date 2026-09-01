<?php

if (!defined('ABSPATH')) {
    exit;
}

$show_scroll     = true;
$slide_partial   = 'slide-cards.php';
$slide_card_extra = 'video-banner__slide--card flex flex-col h-full overflow-hidden rounded-2xl transition-colors duration-300 border border-white/10 bg-[#141418] shadow-none hover:border-white/20 hover:bg-[#1a1a20]';
$slide_media_compact = false;
?>
<section class="<?php echo esc_attr(implode(' ', $section_classes)); ?>">
    <?php
    include PATH . '/components/video-banner/elements/media.php';
    include PATH . '/components/video-banner/elements/content.php';
    include PATH . '/components/video-banner/elements/scroll.php';
    include PATH . '/components/video-banner/elements/slider.php';
    ?>
</section>
