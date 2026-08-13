<?php
if (!defined('ABSPATH')) {
    exit;
}

global $wp_query;

$paged = max(
    1,
    get_query_var('paged'),
    get_query_var('page')
);

$profile_posts = new WP_Query([
    'post_type'      => 'post',
    'author'         => get_current_user_id(),
    'post_status'    => 'publish',
    'posts_per_page' => 6,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

$temp_query = $wp_query;
$wp_query   = $profile_posts;
?>

<section class="dashboard-profile space-y-8">

    <div class="grid grid-cols-1 gap-6">

        <?php if ($profile_posts->have_posts()) : ?>

            <?php while ($profile_posts->have_posts()) : $profile_posts->the_post(); ?>

                <?php
                $categories  = get_the_category(get_the_ID());
                $category_id = !empty($categories) ? $categories[0]->term_id : null;

                if (!$category_id) {
                    continue;
                }

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
                ?>

            <?php endwhile; ?>

        <?php else : ?>

            <div class="rounded-2xl border border-slate-200 dark:border-zinc-800 p-8 text-center">
                <p class="text-slate-500 dark:text-slate-400">
                    You haven't published any posts yet.
                </p>
            </div>

        <?php endif; ?>

    </div>

    <?php if ($profile_posts->max_num_pages > 1) : ?>
        <div class="mt-8 pt-6 border-t border-slate-200/60 dark:border-zinc-800">
            <?php require PATH . '/components/pagination/component.php'; ?>
        </div>
    <?php endif; ?>

</section>

<?php
wp_reset_postdata();
$wp_query = $temp_query;
?>