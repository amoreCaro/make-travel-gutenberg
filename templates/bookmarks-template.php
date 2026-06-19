<?php
/**
 * Template Name: Bookmarks Page Template
 */

if (!defined('ABSPATH')) exit;

get_header();

global $wpdb;

$user_id = get_current_user_id();

if (!$user_id) {
    echo '<p class="text-center py-10">You must be logged in.</p>';
    get_footer();
    exit;
}

$username    = get_the_author_meta('display_name', $user_id);
$avatar_url  = get_avatar_url($user_id, ['size' => 150]);
$description = get_user_meta($user_id, 'description', true);

if (empty($description)) {
    $description = __('Immerse yourself in the world of saved posts.', 'textdomain');
}

$cover_image_url = 'https://ncmaz-faust.booliitheme.com/wp-content/uploads/2024/08/pexels-ds-stories-6005407-scaled-1.jpg';

$table = $wpdb->prefix . 'post_reactions';

/**
 * GET SAVED POSTS
 */
$saved_posts = $wpdb->get_col(
    $wpdb->prepare("
        SELECT post_id
        FROM {$table}
        WHERE user_id = %d
        AND type = %s
        ORDER BY id DESC
    ", $user_id, 'save')
);

/**
 * Pagination logic
 */
$per_page = (!empty($_GET['show']) && $_GET['show'] === 'all')
    ? -1
    : 2;

$total_posts = !empty($saved_posts) ? count($saved_posts) : 0;

?>

<main class="favourites-page w-full mx-auto pb-24">

    <!-- PROFILE HEADER -->
    <div class="w-full mb-10 lg:mb-16">

        <div class="relative h-40 w-full md:h-[288px] 2xl:h-72">
            <img 
                src="<?php echo esc_url($cover_image_url); ?>" 
                class="h-full w-full object-cover"
                alt="Cover"
            >
        </div>

        <div class="container -mt-10 lg:-mt-16 mx-auto">

            <div class="relative flex flex-col gap-5 rounded-3xl bg-white p-5 shadow-xl md:flex-row lg:p-8 dark:bg-neutral-900">

                <!-- Avatar -->
                <div class="w-20 h-20 lg:w-36 lg:h-36 rounded-full overflow-hidden">
                    <img src="<?php echo esc_url($avatar_url); ?>" class="w-full h-full object-cover">
                </div>

                <!-- Info -->
                <div class="grow">
                    <h1 class="text-2xl font-semibold dark:text-white">
                        <?php echo esc_html($username); ?>
                    </h1>

                    <p class="text-sm text-neutral-500 dark:text-neutral-400">
                        <?php echo esc_html($description); ?>
                    </p>
                </div>

            </div>

        </div>
    </div>

    <!-- GRID -->
    <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        <?php if (!empty($saved_posts)) : ?>

            <?php
            $query = new WP_Query([
                'post_type'      => 'post',
                'post__in'       => $saved_posts,
                'orderby'        => 'post__in',
                'posts_per_page' => $per_page,
            ]);
            ?>

            <?php if ($query->have_posts()) : ?>

                <?php while ($query->have_posts()) : $query->the_post(); ?>

                    <?php include PATH . '/components/bento/elements/default-item.php'; ?>

                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>

            <?php else : ?>

                <p class="col-span-full text-center py-10 text-gray-500 dark:text-neutral-400">
                    No saved posts found.
                </p>

            <?php endif; ?>

        <?php else : ?>

            <p class="col-span-full text-center py-10 text-gray-500 dark:text-neutral-400">
                You haven’t saved any posts yet.
            </p>

        <?php endif; ?>

    </div>

    <!-- SHOW MORE -->
    <?php if ($total_posts > $per_page && empty($_GET['show'])) : ?>
        <div class="text-center mt-10">
            <a href="<?php echo esc_url(add_query_arg('show', 'all')); ?>"
               class="inline-block px-6 py-3 rounded-xl bg-black text-white dark:bg-neutral-800">
                Show more
            </a>
        </div>
    <?php endif; ?>

</main>

<?php get_footer(); ?>