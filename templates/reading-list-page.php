<?php
/**
 * Template Name: Reading list Page Template
 */

if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;

$user_id      = get_current_user_id();
$page_title   = get_the_title();
$current_user = wp_get_current_user();

$username   = $current_user->display_name ?? '';
$user_email = $current_user->user_email ?? '';
$author_id  = $current_user->ID ?? 0;

$table = $wpdb->prefix . 'post_reactions';

$bookmarked_posts = $user_id
    ? $wpdb->get_col(
        $wpdb->prepare(
            "
            SELECT post_id
            FROM {$table}
            WHERE user_id = %d
            AND type = %s
            ORDER BY id DESC
        ",
            $user_id,
            'save'
        )
    )
    : [];

$paged    = max(1, get_query_var('paged'));
$per_page = 4;

$reading_list_query = new WP_Query([
    'post_type'      => 'post',
    'post__in'       => !empty($bookmarked_posts) ? $bookmarked_posts : [0],
    'orderby'        => 'post__in',
    'posts_per_page' => $per_page,
    'paged'          => $paged,
]);

get_header();
?>

<main class="main">

    <div class="author py-[100px] bg-[#F6F5F8] dark:bg-[#0E0E10]">

        <div class="max-w-[800px] w-full mx-auto px-5 xl:px-10 2xl:px-0">

            <?php require PATH . '/components/breadcrumbs/component.php'; ?>

            <h1 class="mt-6 mb-8 text-4xl font-bold tracking-tight text-neutral-900 dark:text-white">
                <?php echo esc_html($page_title); ?>
            </h1>

            <?php
            $args = [
                'username'   => $username,
                'user_email' => $user_email,
                'author_id'  => $author_id,
            ];

            require PATH . '/components/profile/component.php';
            ?>

        </div>

        <?php
        $args = [
            'current_slug' => 'reading-list',
        ];

        require PATH . '/components/profileSubnav/component.php';
        ?>

        <div class="mt-12 container mx-auto px-5 xl:px-10 2xl:px-0 py-5">

            <?php if (!$user_id) : ?>

                <p class="text-center text-lg text-neutral-600 dark:text-neutral-400">
                    <?php _e('You must be logged in.', THEME); ?>
                </p>

            <?php elseif ($reading_list_query->have_posts()) : ?>

                <div class="space-y-8">

                    <?php
                    while ($reading_list_query->have_posts()) :
                        $reading_list_query->the_post();

                        $categories  = get_the_category(get_the_ID());
                        $category_id = !empty($categories) ? $categories[0]->term_id : null;

                        $category_data = [];

                        if ($category_id) {
                            $icon_id  = carbon_get_term_meta($category_id, 'category_svg');
                            $icon_url = $icon_id ? wp_get_attachment_url($icon_id) : '';

                            $category_data = [
                                'id'         => $category_id,
                                'name'       => $categories[0]->name,
                                'link'       => get_category_link($category_id),
                                'svg'        => cf_get_inline_svg($icon_url),
                                'bg_color'   => carbon_get_term_meta($category_id, 'category_bg'),
                                'text_color' => carbon_get_term_meta($category_id, 'category_text_color'),
                                'decor_type' => carbon_get_term_meta($category_id, 'category_decor_type'),
                            ];
                        }

                        include PATH . '/components/bento/elements/horizontal-item.php';

                    endwhile;

                    wp_reset_postdata();
                    ?>

                </div>

            <?php else : ?>

                <div class="py-20 text-center">

                    <h2 class="text-2xl font-semibold text-neutral-900 dark:text-white">
                        <?php _e('Your reading list is empty 📚', THEME); ?>
                    </h2>

                    <p class="mt-3 text-neutral-500 dark:text-neutral-400">
                        <?php _e('Save articles to read them later.', THEME); ?>
                    </p>

                </div>

            <?php endif; ?>

        </div>

        <?php
        // require PATH . '/components/pagination/component.php';
        require PATH . '/components/burger-menu/component.php';
        require PATH . '/components/modal/component.php';
        ?>

    </div>

</main>

<?php get_footer(); ?>