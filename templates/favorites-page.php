<?php
/**
 * Template Name: Favorites Page Template
 */

if (!defined('ABSPATH')) exit;

get_header();

global $wpdb;

$user_id = get_current_user_id();

$username    = get_the_author_meta('display_name', $user_id);
$avatar_url  = get_avatar_url($user_id, ['size' => 150]);
$description = get_user_meta($user_id, 'description', true);

// Якщо у користувача немає біографії, виведемо дефолтний текст (або залиште пустим)
if (empty($description)) {
    $description = __('Immerse yourself in the world of literature with our curated collection of books.', 'textdomain');
}

// Замість статичного банера можна підставити динамічний, якщо у вас є такий мета-поле.
// Поки що залишаємо дефолтне посилання з вашого прикладу.
$cover_image_url = 'https://ncmaz-faust.booliitheme.com/wp-content/uploads/2024/08/pexels-ds-stories-6005407-scaled-1.jpg';

$table = $wpdb->prefix . 'post_reactions';

/**
 * GET liked posts
 */
$liked_posts = $wpdb->get_col(
    $wpdb->prepare("
        SELECT post_id
        FROM $table
        WHERE user_id = %d
        AND type = %s
        ORDER BY id DESC
    ", $user_id, 'like')
);

/**
 * Pagination logic
 */
$per_page = (!empty($_GET['show']) && $_GET['show'] === 'all')
    ? -1
    : 2;

$total_posts = !empty($liked_posts) ? count($liked_posts) : 0;
?>

<main class="favourites-page w-full mx-auto pb-24">

    <!-- PROFILE HEADER BLOCK -->
    <div class="w-full mb-10 lg:mb-16">
        <!-- Cover Image -->
        <div class="relative h-40 w-full md:h-[288px] 2xl:h-72">
            <div class="absolute inset-0">
                <img 
                    src="<?php echo esc_url($cover_image_url); ?>" 
                    alt="Cover Image" 
                    class="h-full w-full object-cover"
                    style="color: transparent;"
                >
            </div>
        </div>
        
        <!-- Profile Info Card -->
        <div class="container -mt-10 lg:-mt-16 mx-auto">
<div class="relative flex flex-col gap-2 rounded-3xl bg-white p-5 shadow-xl sm:gap-5 md:flex-row md:gap-8 md:rounded-[40px] lg:gap-10 lg:p-8 xl:gap-12 dark:border dark:border-neutral-700 dark:bg-neutral-900">

    <!-- Avatar -->
    <div class="wil-avatar relative inline-flex shrink-0 items-center justify-center overflow-hidden font-semibold uppercase text-neutral-100 shadow-inner rounded-full w-20 h-20 text-xl sm:text-3xl lg:text-4xl lg:w-36 lg:h-36 ring-4 ring-white dark:ring-0 shadow-2xl z-0 ring-1 ring-white dark:ring-neutral-900">
        <img 
            src="https://secure.gravatar.com/avatar/33e54dec0cd79fc4b5e911c15f836c46ec8d0e452ecd3ca5f707bce0a3540a3b?s=150&d=mm&r=g" 
            alt="dev" 
            class="absolute inset-0 h-full w-full object-cover"
        >
        <span class="wil-avatar__name hidden"></span>
    </div>

    <!-- Text Content -->
    <div class="grow">
        <div class="max-w-(--breakpoint-sm) space-y-3.5">

            <h1 class="inline-flex items-center text-xl font-semibold sm:text-2xl md:text-3xl lg:text-4xl dark:text-white">
                <span>dev</span>
            </h1>

            <span class="author_description block text-sm text-neutral-500 dark:text-neutral-400">
                Immerse yourself in the world of literature with our curated collection of books.
            </span>

            <!-- Socials -->
            <div class="nc-SocialsList flex flex-wrap gap-4 text-neutral-600 dark:text-neutral-300">
                <a class="block hover:text-blue-600 transition" href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer">
                    <svg fill="currentColor" class="h-5 w-5" viewBox="0 0 512 512"><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/></svg>
                </a>

                <a class="block hover:text-red-600 transition" href="https://www.youtube.com/" target="_blank" rel="noopener noreferrer">
                    <svg fill="currentColor" class="h-5 w-5" viewBox="0 0 576 512"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zM224 336V176l142.739 81.205L224 336z"/></svg>
                </a>

                <a class="block hover:text-black dark:hover:text-white transition" href="https://www.tiktok.com/" target="_blank" rel="noopener noreferrer">
                    <svg fill="currentColor" class="h-5 w-5" viewBox="0 0 448 512"><path d="M448 209.91a210.06 210.06 0 01-122.77-39.25V349.38A162.55 162.55 0 11185 188.31V278.2a74.62 74.62 0 1052.23 71.18V0l88 0a121.18 121.18 0 001.86 22.17A122.18 122.18 0 00381 102.39a121.43 121.43 0 0067 20.14z"/></svg>
                </a>
            </div>

        </div>
    </div>

    <!-- Action Buttons (TOP RIGHT) -->
    <div class="absolute top-5 right-5 flex items-center gap-2">

        <!-- Share -->
        <button class="flex items-center justify-center w-10 h-10 rounded-full bg-neutral-50 hover:bg-neutral-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 text-neutral-700 dark:text-neutral-200 transition" title="Share">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="none">
                <path d="M18 7C18.7745 7.16058 19.3588 7.42859 19.8284 7.87589C21 8.99181 21 10.7879 21 14.38C21 17.9721 21 19.7681 19.8284 20.8841C18.6569 22 16.7712 22 13 22H11C7.22876 22 5.34315 22 4.17157 20.8841C3 19.7681 3 17.9721 3 14.38C3 10.7879 3 8.99181 4.17157 7.87589C4.64118 7.42859 5.2255 7.16058 6 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M12 14V2M12 2L9 5M12 2L15 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <!-- More -->
        <button class="flex items-center justify-center w-10 h-10 rounded-full bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-800 dark:hover:bg-neutral-700 text-neutral-500 dark:text-neutral-400 transition" title="More">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                <path fill-rule="evenodd" d="M4.5 12a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm6 0a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm6 0a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" clip-rule="evenodd"/>
            </svg>
        </button>

    </div>

</div>
        </div>
    </div>

    <!-- GRID -->
    <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        <?php if (!empty($liked_posts)) : ?>

            <?php
            $query = new WP_Query([
                'post_type'      => 'post',
                'post__in'       => $liked_posts,
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

                <p class="text-gray-500 dark:text-neutral-400 col-span-full text-center py-10">
                    No posts found.
                </p>

            <?php endif; ?>

        <?php else : ?>

            <p class="text-gray-500 dark:text-neutral-400 col-span-full text-center py-10">
                You haven’t added any favourites yet.
            </p>

        <?php endif; ?>

    </div>

    <!-- SHOW MORE BUTTON -->
    <?php if ($total_posts > $per_page && empty($_GET['show'])) : ?>
        <div class="text-center mt-10">
            <a href="<?php echo esc_url(add_query_arg('show', 'all')); ?>"
               class="inline-block px-6 py-3 rounded-xl bg-black text-white dark:bg-neutral-800 dark:hover:bg-neutral-700 hover:bg-gray-800 transition">
                Show more
            </a>
        </div>
    <?php endif; ?>

</main>

<?php get_footer(); ?>