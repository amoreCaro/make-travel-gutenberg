<?php

/**
 * Template Name: Contact Page Template
 */

if (!defined('ABSPATH')) {
    exit;
}

$page_title   = get_the_title();
$page_excerpt = has_excerpt() ? get_the_excerpt() : '';
$content      = apply_filters('the_content', get_the_content());

get_header();
?>

<main class="main">
    <div class="contact-page bg-white text-[#1D1D1F] dark:bg-black dark:text-[#F5F5F7]">
        <div class="container mx-auto px-5 pt-[100px] pb-[56px] sm:pt-[120px] sm:pb-[72px] lg:px-10 lg:pt-[150px] lg:pb-[120px] 2xl:px-0">
            <div class="mx-auto max-w-[1120px]">

                <?php if (!empty($page_title)) : ?>
                    <h1 class="text-[32px] font-semibold leading-[1.15] tracking-tight sm:text-[40px] md:text-[44px] lg:text-[48px]">
                        <?php echo esc_html($page_title); ?>
                    </h1>
                <?php endif; ?>

                <?php if (!empty($page_excerpt)) : ?>
                    <p class="mt-4 max-w-[540px] text-[15px] font-light leading-[1.65] text-[#4B5563] dark:text-white/65 sm:mt-5 sm:text-[17px] sm:leading-[1.7] md:text-[18px]">
                        <?php echo esc_html($page_excerpt); ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($content)) : ?>
                    <div class="h-article mt-12 sm:mt-16">
                        <?php echo $content; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <?php
        require PATH . '/components/burger-menu/component.php';
        ?>
    </div>
</main>

<?php get_footer(); ?>