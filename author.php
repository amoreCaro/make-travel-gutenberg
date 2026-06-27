<?php
if (!defined('ABSPATH')) {
    exit;
}

$curauth = get_queried_object();
$author_id = $curauth->ID;

get_header();
?>

<main class="main">

    <div class="author max-w-5xl mx-auto px-6 py-[100px]">

        <!-- AUTHOR HEADER -->
        <header class="flex items-center gap-6 pb-10 border-b border-neutral-200 dark:border-neutral-800">

            <div class="w-24 h-24 rounded-2xl overflow-hidden border border-neutral-200 dark:border-neutral-800">
                <?php echo get_avatar($author_id, 96); ?>
            </div>

            <div>

                <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">
                    <?php echo esc_html($curauth->display_name); ?>
                </h1>

                <p class="text-sm text-neutral-500 mt-1">
                    @<?php echo esc_html($curauth->user_nicename); ?>
                </p>

                <?php if (!empty($curauth->user_description)) : ?>
                    <p class="text-neutral-600 dark:text-neutral-400 mt-3 max-w-xl">
                        <?php echo esc_html($curauth->user_description); ?>
                    </p>
                <?php endif; ?>

            </div>

        </header>

        <!-- POSTS -->
        <section class="mt-12">

            <h2 class="text-xl font-semibold mb-6 text-neutral-900 dark:text-white">
                Latest posts
            </h2>

            <div class="grid gap-5">

                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <a href="<?php the_permalink(); ?>"
                       class="group block p-5 rounded-2xl border border-neutral-200 dark:border-neutral-800
                              hover:bg-neutral-50 dark:hover:bg-neutral-900 transition">

                        <h3 class="text-lg font-medium text-neutral-900 dark:text-white group-hover:underline">
                            <?php the_title(); ?>
                        </h3>

                        <p class="text-sm text-neutral-500 mt-2">
                            <?php echo wp_trim_words(get_the_excerpt(), 22); ?>
                        </p>

                    </a>

                <?php endwhile; else: ?>

                    <p class="text-neutral-500">No posts yet.</p>

                <?php endif; ?>

            </div>

        </section>

    </div>

</main>

<?php get_footer(); ?>