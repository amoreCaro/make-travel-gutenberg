<?php
/**
 * Template Name: Likes Page Template
 */

if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;

$user_id      = get_current_user_id();
$current_user = wp_get_current_user();

$username   = $current_user->display_name ?? '';
$user_email = $current_user->user_email ?? '';
$author_id  = $current_user->ID ?? 0;

$table        = $wpdb->prefix . 'post_reactions';
$liked_posts  = [];
$total_posts  = 0;
$per_page     = 4;
$query        = null;
$profile_args = [];

if ($user_id) {

    $liked_posts = $wpdb->get_col(
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

    $total_posts = count($liked_posts);

    $query = new WP_Query([
        'post_type'      => 'post',
        'post__in'       => !empty($liked_posts) ? $liked_posts : [0],
        'orderby'        => 'post__in',
        'posts_per_page' => $per_page,
    ]);

    $profile_args = [
        'username'   => $username,
        'user_email' => $user_email,
        'author_id'  => $author_id,
    ];
}

get_header();
?>

<main class="favourites-page mx-auto py-24">

    <?php if (!$user_id) : ?>

        <div class="container mx-auto py-20">
            <p class="text-center text-gray-500">
                <?php _e('You must be logged in.', THEME); ?>
            </p>
        </div>

    <?php else : ?>

        <div class="max-w-[800px] w-full mx-auto px-5 xl:px-10 2xl:px-0">

            <?php
            $args = $profile_args;
            require PATH . '/components/profile/component.php';
            ?>

        </div>

        <?php require PATH . '/components/profileSubnav/component.php'; ?>

        <div
            id="favorites__grid"
            class="container mx-auto px-5 xl:px-10 2xl:px-0 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
        >

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

    include PATH . '/components/bento/elements/default-item.php';
    ?>

<?php endwhile; ?>

                <?php wp_reset_postdata(); ?>

            <?php else : ?>

                <p class="col-span-full py-10 text-center text-gray-500">
                    <?php _e("You haven’t added any favourites yet.", THEME); ?>
                </p>

            <?php endif; ?>

        </div>

        <?php if ($total_posts > $per_page) : ?>

            <div class="mt-10 text-center">

                <button
                    id="favorites__btn--show-more"
                    data-offset="<?php echo esc_attr($per_page); ?>"
                    data-total="<?php echo esc_attr($total_posts); ?>"
                    type="button"
                    class="rounded-xl bg-black px-6 py-3 text-white"
                >
                    <?php _e('Show more', THEME); ?>
                </button>

            </div>

        <?php endif; ?>

    <?php endif; ?>

    <?php
    require PATH . '/components/burger-menu/component.php';
    require PATH . '/components/modal/component.php';
    ?>

</main>

<?php get_footer(); ?>