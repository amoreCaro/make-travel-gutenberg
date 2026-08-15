<?php

/**
 * Template Name: Contact Page Template
 *
 */

if (!defined('ABSPATH')) {
    exit;
}

$page_title   = get_the_title();
$page_excerpt = has_excerpt() ? get_the_excerpt() : '';
$content      = apply_filters('the_content', get_the_content());
$button_text  = carbon_get_the_post_meta('contact_button_text');

$bg_type      = carbon_get_the_post_meta('contact_bg_type') ?: 'none';
$bg_image_id  = (int) carbon_get_the_post_meta('contact_bg_image');
$bg_video_id  = (int) carbon_get_the_post_meta('contact_bg_video');
$bg_image_url = $bg_image_id ? wp_get_attachment_image_url($bg_image_id, 'full') : '';
$bg_video_url = $bg_video_id ? wp_get_attachment_url($bg_video_id) : '';

$has_bg_video = $bg_type === 'video' && !empty($bg_video_url);
$has_bg_image = $bg_type === 'image' && !empty($bg_image_url);
$has_bg       = $has_bg_video || $has_bg_image;

$button_class = $has_bg
    ? 'group inline-flex items-center gap-3 w-fit px-6 py-3.5 text-xs md:text-sm font-medium tracking-[0.16em] capitalize rounded-full border border-white/85 bg-transparent text-white hover:bg-white hover:border-white hover:text-black transition-colors duration-300'
    : 'group inline-flex items-center gap-3 w-fit px-6 py-3.5 text-xs md:text-sm font-medium tracking-[0.16em] capitalize rounded-full border border-black/85 bg-transparent text-black hover:bg-black hover:border-black hover:text-white transition-colors duration-300 dark:border-white/85 dark:text-white dark:hover:bg-white dark:hover:border-white dark:hover:text-black';

get_header();
?>

<main class="main">
    <div class="contact-page relative isolate overflow-hidden min-h-[40vh] transition-colors duration-200 sm:min-h-[50vh] <?php echo $has_bg ? 'bg-black text-white min-h-[70vh] sm:min-h-[85vh]' : 'bg-white text-[#1D1D1F] dark:bg-black dark:text-[#F5F5F7]'; ?>">

        <?php if ($has_bg) : ?>
            <div class="pointer-events-none absolute inset-0" aria-hidden="true">
                <?php if ($has_bg_video) : ?>
                    <video
                        class="contact-page__video absolute inset-0 h-full w-full object-cover opacity-0 transition-opacity duration-700"
                        muted
                        loop
                        playsinline
                        preload="none"
                        data-src="<?php echo esc_url($bg_video_url); ?>"
                    ></video>
                <?php endif; ?>

                <?php if ($has_bg_image) : ?>
                    <img
                        src="<?php echo esc_url($bg_image_url); ?>"
                        alt=""
                        class="absolute inset-0 h-full w-full object-cover"
                    >
                <?php endif; ?>

                <div class="absolute inset-0 bg-black/50 dark:bg-black/60"></div>
                <div class="absolute inset-x-0 bottom-0 h-[45%] bg-gradient-to-t from-black/55 to-transparent"></div>
            </div>
        <?php endif; ?>

        <div class="relative z-10 <?php echo $has_bg ? 'flex min-h-[70vh] sm:min-h-[85vh] items-center dark' : ''; ?>">
            <div class="container mx-auto w-full px-5 xl:px-10 2xl:px-0 <?php echo $has_bg ? 'pt-[80px] pb-16 sm:pt-[96px] sm:pb-20 lg:pt-[80px] lg:pb-24' : 'pt-[100px] pb-[56px] sm:pt-[120px] sm:pb-[72px] lg:pt-[150px] lg:pb-[120px]'; ?>">
                <div class="mx-auto max-w-[1120px]">

                    <div class="flex flex-col items-start">
                        <?php if (!empty($page_title)) : ?>
                            <h1 class="text-[32px] font-semibold leading-[1.15] tracking-tight sm:text-[40px] md:text-[44px] lg:text-[48px] <?php echo $has_bg ? 'text-white' : 'text-[#111827] dark:text-white'; ?>">
                                <?php echo esc_html($page_title); ?>
                            </h1>
                        <?php endif; ?>

                        <?php if (!empty($page_excerpt)) : ?>
                            <p class="mt-4 max-w-[540px] text-[15px] font-light leading-[1.65] sm:mt-5 sm:text-[17px] sm:leading-[1.7] md:text-[18px] <?php echo $has_bg ? 'text-white/75' : 'text-[#4B5563] dark:text-white/65'; ?>">
                                <?php echo esc_html($page_excerpt); ?>
                            </p>
                        <?php endif; ?>

                        <div class="mt-8 sm:mt-10">
                            <button
                                type="button"
                                id="openContactPopup"
                                class="<?php echo esc_attr($button_class); ?>"
                                aria-haspopup="dialog"
                                aria-controls="contactPopup"
                                aria-expanded="false"
                            >
                                <span><?php echo esc_html($button_text); ?></span>
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <?php if (!$has_bg && !empty($content)) : ?>
                        <div class="h-article mt-12 sm:mt-16">
                            <?php echo $content; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if ($has_bg && !empty($content)) : ?>
            <div class="relative z-10 container mx-auto px-5 pb-16 xl:px-10 2xl:px-0 sm:pb-20 lg:pb-24">
                <div class="mx-auto max-w-[1120px]">
                    <div class="h-article">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php
        require PATH . '/components/burger-menu/component.php';
        require PATH . '/components/modal/component.php';
        ?>
    </div>
</main>

<?php require PATH . '/components/contact-popup/component.php'; ?>

<?php get_footer(); ?>
