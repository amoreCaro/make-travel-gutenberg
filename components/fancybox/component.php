<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('render_fancybox_image')) {
    function render_fancybox_image(array $args = []): void
    {
        $src        = (string) ($args['src'] ?? '');
        $full       = (string) ($args['full'] ?? $src);
        $alt        = (string) ($args['alt'] ?? '');
        $caption    = (string) ($args['caption'] ?? $alt);
        $group      = (string) ($args['group'] ?? 'gallery');
        $img_class  = (string) ($args['img_class'] ?? 'w-full h-full object-cover');
        $link_class = (string) ($args['link_class'] ?? 'block w-full h-full cursor-pointer');

        if ($src === '' || $full === '') {
            return;
        }
        ?>
        <a
            href="<?php echo esc_url($full); ?>"
            data-fancybox="<?php echo esc_attr($group); ?>"
            data-caption="<?php echo esc_attr($caption); ?>"
            class="<?php echo esc_attr($link_class); ?>"
        >
            <img
                data-src="<?php echo esc_url($src); ?>"
                src="<?php echo esc_url($placeholder); ?>"
                alt="<?php echo esc_attr($alt); ?>"
                class="<?php echo esc_attr($img_class); ?> lazy-img"
                loading="lazy"
                decoding="async"
            >
        </a>
        <?php
    }
}

if (!function_exists('render_fancybox')) {
    /**
     * Lightbox shell: back, counter, prev, next, image stage.
     */
    function render_fancybox(): void
    {
        ?>
        <div
            id="fancybox"
            class="fancybox group fixed inset-0 z-[1200] flex flex-col bg-[#0a0b14] text-white opacity-0 pointer-events-none transition-opacity duration-300 [&.is-open]:opacity-100 [&.is-open]:pointer-events-auto"
            role="dialog"
            aria-modal="true"
            aria-label="<?php esc_attr_e('Image gallery', THEME); ?>"
            hidden
        >
            <!-- Top bar: back | counter -->
            <div class="fancybox__toolbar relative z-20 flex items-center px-4 py-3 sm:px-5 sm:py-4 shrink-0">
                <button
                    type="button"
                    id="fancyboxBack"
                    class="fancybox__back inline-flex items-center justify-center w-11 h-11 rounded-full text-white/95 hover:bg-white/10 transition-colors"
                    aria-label="<?php esc_attr_e('Back', THEME); ?>"
                >
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M15 6L9 12l6 6"/>
                    </svg>
                </button>

                <div
                    id="fancyboxCounter"
                    class="fancybox__counter absolute left-1/2 -translate-x-1/2 text-[15px] font-normal tracking-wide tabular-nums text-white/95 pointer-events-none"
                    aria-live="polite"
                >
                    <span data-fancybox-current>1</span>
                    <span class="mx-[0.3em] opacity-70">/</span>
                    <span data-fancybox-total>1</span>
                </div>
            </div>

            <!-- Stage -->
            <div class="fancybox__stage relative z-10 flex-1 flex items-center justify-center min-h-0 px-14 sm:px-20 md:px-28 py-4">
                <button
                    type="button"
                    id="fancyboxPrev"
                    class="fancybox__prev absolute left-3 sm:left-5 top-1/2 -translate-y-1/2 z-20 inline-flex items-center justify-center w-11 h-11 sm:w-12 sm:h-12 rounded-full text-white/95 shadow-[inset_0_0_0_1px_rgba(255,255,255,0.28)] hover:bg-white/10 transition-colors disabled:opacity-25 disabled:pointer-events-none"
                    aria-label="<?php esc_attr_e('Previous', THEME); ?>"
                >
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M15 5L9 12l6 7"/>
                    </svg>
                </button>

                <figure class="fancybox__figure m-0 max-w-full max-h-full flex items-center justify-center">
                    <img
                        id="fancyboxImage"
                        src=""
                        alt=""
                        class="fancybox__image max-w-full max-h-[calc(100vh-8rem)] w-auto h-auto object-contain select-none"
                        draggable="false"
                    >
                    <figcaption
                        id="fancyboxCaption"
                        class="fancybox__caption sr-only"
                    ></figcaption>
                </figure>

                <button
                    type="button"
                    id="fancyboxNext"
                    class="fancybox__next absolute right-3 sm:right-5 top-1/2 -translate-y-1/2 z-20 inline-flex items-center justify-center w-11 h-11 sm:w-12 sm:h-12 rounded-full text-white/95 shadow-[inset_0_0_0_1px_rgba(255,255,255,0.28)] hover:bg-white/10 transition-colors disabled:opacity-25 disabled:pointer-events-none"
                    aria-label="<?php esc_attr_e('Next', THEME); ?>"
                >
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 5l6 7-6 7"/>
                    </svg>
                </button>
            </div>
        </div>
        <?php
    }
}
