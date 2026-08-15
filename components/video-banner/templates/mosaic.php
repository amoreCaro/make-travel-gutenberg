<?php

if (!defined('ABSPATH')) {
    exit;
}

$show_scroll     = false;
$slide_partial   = 'slide-mosaic.php';
$slide_card_extra = 'video-banner__slide--tile relative block overflow-hidden rounded-2xl aspect-square border border-white/12 bg-[#141418] shadow-[0_10px_30px_rgba(0,0,0,0.25)] hover:border-white/28 transition-colors duration-300';
$slide_media_compact = false;
?>
<section class="<?php echo esc_attr(implode(' ', $section_classes)); ?>">
    <?php
    include PATH . '/components/video-banner/elements/media.php';
    include PATH . '/components/video-banner/elements/content.php';
    include PATH . '/components/video-banner/elements/slider.php';
    ?>
</section>
