<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Placeholder
 */
$placeholder = get_template_directory_uri() . '/assets/dist/images/placeholder.png';

/**
 * Current post categories
 */
$categories = wp_get_post_categories(get_the_ID());

if (empty($categories)) {
    return;
}

/**
 * Беремо першу категорію
 */
$category_id = (int) $categories[0];

/**
 * Category styles
 */
$icon_url = carbon_get_term_meta($category_id, 'category_svg');

$category_svg = !empty($icon_url)
    ? cf_get_inline_svg($icon_url)
    : '';

$category_bg_color = carbon_get_term_meta(
    $category_id,
    'category_bg'
);

$category_text_color = carbon_get_term_meta(
    $category_id,
    'category_text_color'
);

/**
 * Related posts
 */
$related_posts = get_posts([
    'category__in' => [$category_id],
    'numberposts'  => 4,
    'post__not_in' => [get_the_ID()],
]);

if (empty($related_posts)) {
    return;
}
?>

<section class="related-posts py-12 lg:py-[100px]">

    <div class="container mx-auto">

        <h2 class="text-black dark:text-white text-3xl md:text-5xl font-medium mb-12">
            <?php _e('Related Posts', THEME); ?>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            <?php foreach ($related_posts as $post) : ?>

                <?php setup_postdata($post); ?>

                <?php
                $thumbnail_url = get_the_post_thumbnail_url(
                    $post->ID,
                    'medium'
                );

                if (!$thumbnail_url) {
                    $thumbnail_url = $placeholder;
                }
                ?>

                <?php require PATH . '/components/bento/elements/default-item.php'; ?>

            <?php endforeach; ?>

            <?php wp_reset_postdata(); ?>

        </div>

    </div>

</section>
