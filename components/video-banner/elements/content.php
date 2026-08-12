<?php

if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="video-banner__main relative z-10 w-full container mx-auto px-5 xl:px-10 pt-28 <?php echo esc_attr($main_pad); ?> flex-1 flex items-center">
    <div class="video-banner__content flex flex-col gap-5 md:gap-6 <?php echo esc_attr($content_width . ' ' . $align_class); ?>">
        <?php if ($label !== '') : ?>
            <span class="video-banner__label text-[11px] md:text-xs font-medium tracking-[0.28em] uppercase text-white <?php echo esc_attr($text_glow . ' ' . $reveal); ?> [animation-delay:100ms]">
                <?php echo esc_html($label); ?>
            </span>
        <?php endif; ?>

        <?php if ($title !== '') : ?>
            <h2 class="video-banner__title text-white <?php echo esc_attr($title_class . ' ' . $text_glow . ' ' . $reveal); ?> [animation-delay:220ms]">
                <?php echo esc_html($title); ?>
            </h2>
        <?php endif; ?>

        <?php if ($text !== '') : ?>
            <p class="video-banner__text text-base md:text-lg leading-relaxed max-w-2xl font-light text-white <?php echo esc_attr($text_glow . ' ' . $reveal); ?> [animation-delay:340ms] <?php echo $align === 'center' ? 'mx-auto' : ''; ?>">
                <?php echo esc_html($text); ?>
            </p>
        <?php endif; ?>

        <?php if ($has_cta) : ?>
            <a
                href="<?php echo esc_url($btn_url); ?>"
                class="video-banner__cta group inline-flex items-center gap-3 mt-2 w-fit px-6 py-3.5 text-xs md:text-sm font-medium tracking-[0.16em] uppercase rounded-full border border-white/85 bg-transparent text-white hover:bg-white hover:border-white hover:text-black transition-colors duration-300 <?php echo esc_attr($reveal); ?> [animation-delay:460ms]"
            >
                <span><?php echo esc_html($btn_text); ?></span>
                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        <?php endif; ?>
    </div>
</div>
