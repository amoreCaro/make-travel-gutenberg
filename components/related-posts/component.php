<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Current post categories
 */
$categories = wp_get_post_categories(get_the_ID());

if (empty($categories)) {
    return;
}

$category_id = (int) $categories[0];

/**
 * Related posts
 */
$related_posts = get_posts([
    'category__in' => [$category_id],
    'numberposts'  => 12,
    'post__not_in' => [get_the_ID()],
]);

if (empty($related_posts)) {
    return;
}

$nav_btn =
    'related-posts__nav-btn inline-flex items-center justify-center w-9 h-9 rounded-full border border-black/10 bg-white text-black shadow-sm transition-all duration-300 hover:border-black/20 hover:shadow-md dark:border-white/15 dark:bg-[#18181f] dark:text-white dark:hover:border-white/30 [&.is-disabled]:opacity-35 [&.is-disabled]:pointer-events-none';
?>

<section class="related-posts py-12 lg:py-[100px]">

    <div class="container mx-auto">

        <div class="flex items-end justify-between gap-4 mb-12">
            <h2 class="text-black dark:text-white text-3xl md:text-5xl font-medium">
                <?php _e('Related Posts', THEME); ?>
            </h2>

            <div class="related-posts__nav hidden sm:flex items-center gap-2 shrink-0">
                <button
                    type="button"
                    class="related-posts__prev <?php echo esc_attr($nav_btn); ?>"
                    aria-label="<?php esc_attr_e('Previous posts', THEME); ?>"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button
                    type="button"
                    class="related-posts__next <?php echo esc_attr($nav_btn); ?>"
                    aria-label="<?php esc_attr_e('Next posts', THEME); ?>"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="related-posts__slider swiper overflow-hidden [&_.swiper-wrapper]:flex [&_.swiper-wrapper]:items-stretch [&_.swiper-slide]:!h-auto [&_.swiper-slide]:shrink-0">
            <div class="swiper-wrapper">

                <?php
                global $post;
                foreach ($related_posts as $post) :
                    setup_postdata($post);
                    ?>
                    <div class="swiper-slide !h-auto">
                        <?php require PATH . '/components/bento/elements/default-item.php'; ?>
                    </div>
                <?php endforeach; ?>

                <?php wp_reset_postdata(); ?>

            </div>
        </div>

    </div>

</section>
