<?php

if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="video-banner__main relative z-10 w-full container mx-auto px-5 xl:px-0 pt-28 <?php echo esc_attr($main_pad); ?> flex-1 flex items-center">
    <div class="video-banner__content flex flex-col gap-5 md:gap-6 <?php echo esc_attr($content_width . ' ' . $align_class); ?>">
        <?php if (!empty ( $label ) ) : ?>
            <span
                class="video-banner__label inline-flex items-center gap-2.5 text-[16px] font-semibold tracking-[0.02em] text-white <?php echo esc_attr($reveal); ?> [animation-delay:100ms]"
            >
                <span style="display:block; width:26px; height:1px; flex-shrink:0; background-color:#ffffff;" aria-hidden="true"></span>
                <?php echo esc_html($label); ?>
                <span style="display:block; width:26px; height:1px; flex-shrink:0; background-color:#ffffff;" aria-hidden="true"></span>
            </span>
        <?php endif; ?>
        <?php if ($title !== '') : ?>
            <h2 class="video-banner__title text-white font-['Fraunces',serif] font-medium leading-[1.04] tracking-[-0.01em] text-[clamp(36px,5vw,72px)] <?php echo esc_attr( $reveal ); ?> [animation-delay:220ms]">
                <?php echo esc_html($title); ?>
            </h2>
        <?php endif; ?>

        <?php if ($text !== '') : ?>
            <p class="video-banner__text text-base md:text-lg leading-relaxed max-w-2xl font-light text-[#c9c4b6] <?php echo esc_attr( $reveal ); ?> [animation-delay:340ms] <?php echo $align === 'center' ? 'mx-auto' : ''; ?>">
                <?php echo esc_html($text); ?>
            </p>
        <?php endif; ?>

        <?php if ($has_cta || $has_cta_2) : ?>
            <div class="video-banner__buttons flex flex-wrap items-center gap-4 mt-2 <?php echo esc_attr($reveal); ?> [animation-delay:460ms]">

                <?php if (!empty($btn_text) && !empty($btn_url)) : ?>
                    <a
                        href="<?php echo esc_url($btn_url); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="video-banner__cta group inline-flex items-center gap-2.5 w-fit px-6 py-4 text-[15px] font-semibold rounded-full bg-white text-[#1b1305] hover:bg-white/85 hover:-translate-y-px transition-all duration-200"
                    >
                        <span><?php echo esc_html($btn_text); ?></span>

                        <svg
                            class="w-3.5 h-3.5 transition-transform duration-300 group-hover:translate-x-1"
                            viewBox="0 0 24 24"
                            fill="none"
                            aria-hidden="true"
                        >
                            <path
                                d="M5 12h14M13 6l6 6-6 6"
                                stroke="currentColor"
                                stroke-width="2.4"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if (!empty($button_2_text) && !empty($button_2_url)) : ?>
                    <a
                        href="<?php echo esc_url($button_2_url); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="video-banner__cta group inline-flex items-center gap-2.5 w-fit px-6 py-4 text-[15px] font-semibold rounded-full border border-white/30 bg-transparent text-white hover:border-white/65 hover:-translate-y-px transition-all duration-200"
                    >
                        <span><?php echo esc_html($button_2_text); ?></span>

                        <svg
                            class="w-3.5 h-3.5 transition-transform duration-300 group-hover:translate-x-1"
                            viewBox="0 0 24 24"
                            fill="none"
                            aria-hidden="true"
                        >
                            <path
                                d="M5 12h14M13 6l6 6-6 6"
                                stroke="currentColor"
                                stroke-width="2.4"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </a>
                <?php endif; ?>

            </div>
        <?php endif; ?>
    </div>
</div>