<?php
if (!defined('ABSPATH')) {
    exit;
}

$curauth = get_queried_object(); 
$author_id = $curauth->ID;

get_header(); ?>
?>

<div class="max-w-5xl mx-auto px-6 py-[100px]">

    <!-- AUTHOR HEADER -->
    <div class="flex items-center gap-5 pb-8 border-b border-neutral-200 dark:border-neutral-800">

        <div class="w-20 h-20 rounded-2xl overflow-hidden border border-neutral-200 dark:border-neutral-800">
            <?php echo get_avatar($author_id, 80, '', '', [
                'class' => 'w-full h-full object-cover'
            ]); ?>
        </div>

        <div>
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">
                <?php echo esc_html($curauth->display_name); ?>
            </h1>

            <p class="text-sm text-neutral-500 mt-1">
                @<?php echo esc_html($curauth->user_nicename); ?>
            </p>

            <?php if (!empty($curauth->user_description)) : ?>
                <p class="text-neutral-600 dark:text-neutral-400 mt-2 max-w-xl">
                    <?php echo esc_html($curauth->user_description); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <!-- POSTS -->
    <div class="mt-10">
        <h2 class="text-lg font-medium mb-6 text-neutral-900 dark:text-white">
            Posts
        </h2>

        <div class="grid gap-6">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <a href="<?php the_permalink(); ?>"
                   class="block p-4 rounded-xl border border-neutral-200 dark:border-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-900 transition">

                    <h3 class="text-base font-medium text-neutral-900 dark:text-white">
                        <?php the_title(); ?>
                    </h3>

                    <p class="text-sm text-neutral-500 mt-1">
                        <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                    </p>

                </a>

            <?php endwhile; else: ?>

                <p class="text-neutral-500">No posts yet.</p>

            <?php endif; ?>
        </div>
    </div>

</div>

<?php get_footer(); ?>