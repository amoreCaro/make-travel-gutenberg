<?php
if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;

$user_id = get_current_user_id();

$table       = $wpdb->prefix . 'post_reactions';
$bookmarked_post = [];
$total_posts = 0;
$per_page    = 10;
$query       = null;

if ($user_id) {

    $bookmarked_post = $wpdb->get_col(
        $wpdb->prepare(
            "
            SELECT post_id
            FROM {$table}
            WHERE user_id = %d
            AND type = %s
            ORDER BY id DESC
            ",
            $user_id,
            'like'
        )
    );

    $total_posts = count($bookmarked_post);

    $query = new WP_Query([
        'post_type'      => 'post',
        'post__in'       => !empty($bookmarked_post) ? $bookmarked_post : [0],
        'orderby'        => 'post__in',
        'posts_per_page' => $per_page,
    ]);
}
?>

<section class="dashboard-profile space-y-8">

    <div id="reading-list__grid" class="space-y-8" >

        <?php if ($query && $query->have_posts()) : ?>

            <?php while ($query->have_posts()) : $query->the_post(); ?>

                <?php
                $categories  = get_the_category();
                $category_id = $categories[0]->term_id ?? 0;

                $icon_url            = carbon_get_term_meta($category_id, 'category_svg');
                $category_svg        = cf_get_inline_svg($icon_url);

                $category_bg_color   = carbon_get_term_meta($category_id, 'category_bg');
                $category_text_color = carbon_get_term_meta($category_id, 'category_text_color');
                $category_decor_type = carbon_get_term_meta($category_id, 'category_decor_type');

                include PATH . '/components/bento/elements/horizontal-item.php';
                ?>

            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>

        <?php else : ?>

            <div class="col-span-full rounded-2xl border border-slate-200 dark:border-zinc-800 p-8 text-center">
                <p class="text-slate-500 dark:text-slate-400">
                    <?php _e("You haven’t added any favourites yet.", THEME); ?>
                </p>
            </div>

        <?php endif; ?>

    </div>

    <?php if ($total_posts > $per_page) : ?>

        <div class="flex justify-center">

            <button
                id="reading-list__btn--show-more"
                data-offset="<?php echo esc_attr($per_page); ?>"
                data-total="<?php echo esc_attr($total_posts); ?>"
                type="button"
                class="rounded-xl bg-black px-6 py-3 text-white dark:bg-white dark:text-black"
            >
                <?php _e('Show more', THEME); ?>
            </button>

        </div>

    <?php endif; ?>

</section>