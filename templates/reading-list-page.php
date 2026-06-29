<?php
/**
 * Template Name: Reading list Page Template
 */

if (!defined('ABSPATH')) exit;

global $wpdb;

$user_id = get_current_user_id();

if (!$user_id) {
    get_header();
    echo '<p class="text-center py-10">You must be logged in.</p>';
    get_footer();
    exit;
}

get_header();

$table = $wpdb->prefix . 'post_reactions';

/**
 * GET BOOKMARKED POSTS (reading list)
 */
$bookmarked_posts = $wpdb->get_col(
    $wpdb->prepare("
        SELECT post_id
        FROM {$table}
        WHERE user_id = %d
        AND type = %s
        ORDER BY id DESC
    ", $user_id, 'save')
);

/**
 * Pagination
 */
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$per_page = 10;

$args = [
    'post_type'      => 'post',
    'post__in'       => !empty($bookmarked_posts) ? $bookmarked_posts : [0],
    'orderby'        => 'post__in',
    'posts_per_page' => $per_page,
    'paged'          => $paged,
];

$reading_list_query = new WP_Query($args);
?>

<main class="min-h-screen pt-[128px] bg-white dark:bg-[#0F0F11] px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
    <div class="max-w-4xl mx-auto">

        <!-- Header -->
        <div class="mb-12 border-b border-gray-200 dark:border-neutral-800 pb-8">
            <h1 class="text-[30px] leading-[36px] font-semibold text-[#111827]">
                <?php _e("Reading list", THEME); ?>
            </h1>
            <p class="mt-3 text-[18px] leading-[28px] text-[#6b7280] font-normal">
                <?php _e("Let's read and save your favorite articles here ! 📚", THEME); ?>
            </p>
        </div>

        <!-- Posts -->
        <div class="space-y-10">

            <?php if ($reading_list_query->have_posts()) : ?>

                <?php while ($reading_list_query->have_posts()) : $reading_list_query->the_post();

                    include get_template_directory() . '/components/bento/elements/horizontal-item.php';

                endwhile; ?>

                <?php wp_reset_postdata(); ?>

            <?php else : ?>

                <p class="text-center text-gray-500 dark:text-neutral-400 py-12">
                    <?php _e("No saved posts yet.", THEME); ?>
                </p>

            <?php endif; ?>

        </div>

    </div>
</main>

<?php get_footer(); ?>