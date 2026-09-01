<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!$show_scroll) {
    return;
}
?>
<button
    type="button"
    class="video-banner__scroll group absolute z-[999] flex items-center gap-2 text-sm font-medium tracking-wide text-white/90 hover:text-white transition-colors duration-300 opacity-100
    <?php echo $align === 'center'
        ? 'left-1/2 -translate-x-1/2 bottom-8 md:bottom-[250px] flex'
        : 'right-5 xl:right-10 ' . ($has_slider ? 'top-[38%]' : 'top-1/2 -translate-y-1/2');
    ?>"
    aria-label="<?php esc_attr_e('Scroll to next section', THEME); ?>"
>
    <span><?php esc_html_e('Scroll', THEME); ?></span>

    <svg
        class="video-banner__scroll-icon w-4 h-4 animate-bounce"
        viewBox="0 0 24 24"
        fill="none"
        aria-hidden="true"
    >
        <path
            d="M12 5v14M6 13l6 6 6-6"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
        />
    </svg>
</button>