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

$page_title = get_the_title(); 
$table = $wpdb->prefix . 'post_reactions';

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
get_header();
?>

<main class="min-h-screen pt-[128px] bg-white dark:bg-[#0F0F11] px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
    <div class="max-w-4xl mx-auto">

        <?php require PATH . "/components/breadcrumbs/component.php"; ?>
        <h1 class="text-[30px] leading-[36px] font-semibold text-[#111827]"><?php echo esc_html($page_title); ?></h1>

        <div class="mb-12 border-b border-gray-200 dark:border-neutral-800 pb-8">

            <h2 class="text-[30px] leading-[36px] font-semibold text-[#111827]">
                <?php _e("", THEME); ?>
            </h2>

            <p class="mt-3 text-[18px] leading-[28px] text-[#6b7280] font-normal">
                <?php _e("Let's read and save your favorite articles here ! 📚", THEME); ?>
            </p>
        </div>

        <!-- Posts -->
        <div class="space-y-10">

            <?php while ($reading_list_query->have_posts()) : $reading_list_query->the_post();

                $category = get_the_category();

                $category_data = [];

                if (!empty($category)) {

                    $category_id = $category[0]->term_id;

                    $icon_id  = carbon_get_term_meta($category_id, 'category_svg');
                    $icon_url = $icon_id ? wp_get_attachment_url($icon_id) : '';

                    $category_data = [
                        'id'         => $category_id,
                        'name'       => $category[0]->name,
                        'link'       => get_category_link($category_id),
                        'svg'        => cf_get_inline_svg($icon_url),
                        'bg_color'   => carbon_get_term_meta($category_id, 'category_bg'),
                        'text_color' => carbon_get_term_meta($category_id, 'category_text_color'),
                        'decor_type' => carbon_get_term_meta($category_id, 'category_decor_type'),
                    ];
                }

                include get_template_directory() . '/components/bento/elements/horizontal-item.php';

            endwhile;?>
        </div>

    </div>
</main>

<?php get_footer(); ?>