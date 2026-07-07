<?php
if (!defined('ABSPATH')) {
    exit;
}

$current_user = get_queried_object();

$author_id  = $current_user->ID;
$page_title = get_the_author_meta('display_name', $author_id);

$paged = max(
    1,
    get_query_var('paged'),
    get_query_var('page')
);

get_header();
?>

<main class="main">
    <div class="author py-[100px] dark:bg-[#0E0E10] text-[#1D1D1F] dark:text-[#F5F5F7] min-h-screen transition-colors duration-200 mx-auto px-5 xl:px-10 2xl:px-0">

        <div class="container mb-12">
            <?php require PATH . '/components/breadcrumbs/component.php'; ?>
            <?php require PATH . '/components/profile/component.php'; ?>

            <?php
            $args = [
                'current_slug' => 'reading-list',
            ];

            require PATH . '/components/profileSubnav/component.php';
            ?>
        </div>

        <div class="container grid md:grid-cols-1 lg:grid-cols-[280px_2fr] gap-6 items-start">

            <?php include PATH . '/components/account-sidebar/component.php'; ?>

            <div class="space-y-6">

                <?php
                $author_posts = new WP_Query([
                    'post_type'      => 'post',
                    'author'         => $author_id,
                    'post_status'    => 'publish',
                    'posts_per_page' => 6,
                    'paged'          => $paged,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ]);
                ?>

                <div class="bg-white dark:bg-[#18181F] rounded-3xl p-6 border border-[#E5E5E7] dark:border-[#2D2D3A]">

                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold tracking-wide text-[#1D1D1F] dark:text-white">
                            <?php esc_html_e('Author Posts', THEME); ?>
                        </h2>

                        <span class="text-sm text-[#86868B]">
                            <?php echo esc_html($author_posts->found_posts); ?>
                        </span>
                    </div>

                    <div class="grid grid-cols-1 gap-4">

                        <?php if ($author_posts->have_posts()) : ?>

                            <?php
                            while ($author_posts->have_posts()) :
                                $author_posts->the_post();

                                $categories  = get_the_category(get_the_ID());
                                $category_id = !empty($categories) ? $categories[0]->term_id : null;

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

                                    include PATH . '/components/bento/elements/horizontal-item.php';
                                }

                            endwhile;

                            wp_reset_postdata();
                            ?>

                        <?php else : ?>

                            <p class="text-[#86868B] text-sm text-center py-4">
                                <?php esc_html_e('This author has no posts yet.', THEME); ?>
                            </p>

                        <?php endif; ?>

                    </div>

                    <?php
                    $pagination = [
                        'current' => $paged,
                        'total'   => $author_posts->max_num_pages,
                    ];

                    require PATH . '/components/pagination/component.php';
                    ?>

                </div>

            </div>

        </div>

    </div>
</main>

<?php get_footer(); ?>