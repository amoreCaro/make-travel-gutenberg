<?php
if (!defined('ABSPATH')) {
    exit;
}

// Placeholder image
$placeholder = get_template_directory_uri() . '/assets/dist/images/placeholder.png';

// Отримуємо пов'язані пости
$related_posts = get_posts(array(
    'category__in' => wp_get_post_categories(get_the_ID()),
    'numberposts'  => 5,
    'post__not_in' => array(get_the_ID())
));

if (empty($related_posts)) return;
?>

<section class="related-posts py-12 lg:py-[100px]">
    <div class="container mx-auto px-5 xl:px-[40px] 2xl:px-0">

        <h2 class="text-black dark:text-white text-3xl md:text-5xl font-medium mb-12">
            <?php _e("Related Posts", THEME); ?>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            <?php foreach ($related_posts as $post) : setup_postdata($post); ?>
                
                <?php
                    // Отримуємо thumbnail посту, або placeholder, якщо немає
                    $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'medium');
                    if (!$thumbnail_url) {
                        $thumbnail_url = $placeholder;
                    }
                ?>

                <?php require PATH . "/components/bento/elements/default-item.php"; ?>

            <?php endforeach; wp_reset_postdata(); ?>

        </div>
    </div>
</section>