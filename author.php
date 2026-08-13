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

$args = [
    'current_slug' => 'reading-list',
];
$user_id = get_queried_object_id();
$display_name     = $current_user->display_name ?: __('User', THEME);
$total_posts     = count_user_posts($user_id, 'post');
$total_followers = get_user_meta($user_id, 'followers_count', true) ?: 0;
$total_following = get_user_meta($user_id, 'following_count', true) ?: 0;

$author_posts = new WP_Query([
    'post_type'      => 'post',
    'author'         => $author_id,
    'post_status'    => 'publish',
    'posts_per_page' => 6,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

$pagination = [
    'current' => $paged,
    'total'   => $author_posts->max_num_pages,
];

get_header();
?>

<main class="main">
    <div class="author py-[100px] dark:bg-[#0E0E10] text-[#1D1D1F] dark:text-[#F5F5F7] min-h-screen transition-colors duration-200 mx-auto px-5 xl:px-10 2xl:px-0">

        <div class="container mb-12">
            <?php require PATH . '/components/breadcrumbs/component.php'; ?>

            <?php require PATH . '/components/profileSubnav/component.php'; ?>
        </div>

        <div class="container grid md:grid-cols-1 lg:grid-cols-[280px_2fr] gap-6 items-start">
        <!-- Author Profile Card Component -->
            <aside class="bg-white dark:bg-[#18181B] rounded-3xl border border-[#E5E5E7] dark:border-[#2D2D3A] hidden md:block overflow-hidden w-full max-w-sm">

                <!-- Profile Area -->
                <div class="p-6 border-b border-[#E5E5E7] dark:border-[#2D2D3A]">

                    <!-- User Identity Block -->
                    <div class="flex items-center gap-4">
                        <?php if (get_avatar($user_id)) : ?>
                            <div class="h-14 w-14 shrink-0 rounded-full overflow-hidden border border-[#E5E5E7] dark:border-white/10 shadow-sm">
                                <?php echo get_avatar($user_id, 56, '', $display_name, ['class' => 'object-cover w-full h-full']); ?>
                            </div>
                        <?php endif; ?>

                        <div class="min-w-0 flex-1">
                            <h3 class="truncate font-semibold text-base text-[#1D1D1F] dark:text-white tracking-tight">
                                <?php echo esc_html($display_name); ?>
                            </h3>
                            <?php if ($user_email) : ?>
                                <p class="truncate text-xs text-[#86868B] dark:text-zinc-400 font-normal mt-0.5">
                                    <?php echo esc_html($user_email); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Social Media Row (Directly after identity block) -->
                    <div class="flex items-center gap-1.5 mt-4 text-[#86868B] dark:text-zinc-400">
                            <a href="<?php echo esc_url($youtube); ?>" target="_blank" rel="noopener" class="flex h-8 w-8 items-center justify-center rounded-xl hover:bg-[#F5F5F7] dark:hover:bg-white/10 hover:text-[#1D1D1F] dark:hover:text-white transition" title="YouTube">
                                <svg fill="currentColor" class="w-4 h-4" viewBox="0 0 576 512"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"/></svg>
                            </a>


                            <a href="<?php echo esc_url($tiktok); ?>" target="_blank" rel="noopener" class="flex h-8 w-8 items-center justify-center rounded-xl hover:bg-[#F5F5F7] dark:hover:bg-white/10 hover:text-[#1D1D1F] dark:hover:text-white transition" title="TikTok">
                                <svg fill="currentColor" class="w-3.5 h-3.5" viewBox="0 0 448 512"><path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25V349.38A162.55 162.55 0 1 1 185 188.31V278.2a74.62 74.62 0 1 0 52.23 71.18V0h88a121.18 121.18 0 0 0 1.86 22.17A122.18 122.18 0 0 0 381 102.39a121.43 121.43 0 0 0 67 20.14z"/></svg>
                            </a>

                            <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener" class="flex h-8 w-8 items-center justify-center rounded-xl hover:bg-[#F5F5F7] dark:hover:bg-white/10 hover:text-[#1D1D1F] dark:hover:text-white transition" title="Instagram">
                                <svg fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37zM17.5 6.5h.01"></path></svg>
                            </a>

                            <a href="<?php echo esc_url($github); ?>" target="_blank" rel="noopener" class="flex h-8 w-8 items-center justify-center rounded-xl hover:bg-[#F5F5F7] dark:hover:bg-white/10 hover:text-[#1D1D1F] dark:hover:text-white transition" title="GitHub">
                                <svg fill="currentColor" class="w-4 h-4" viewBox="0 0 496 512"><path d="M244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8z"/></svg>
                            </a>
                    </div>


                        <div class="mt-4 pt-1">
                            <p class="text-[13px] leading-relaxed text-[#515154] dark:text-zinc-400 font-normal line-clamp-3">

                                vfdfvfvdv
                            </p>
                        </div>


                    <!-- Statistics Dashboard Grid -->
                    <div class="grid grid-cols-3 gap-2 border-t border-[#E5E5E7] dark:border-[#2D2D3A] mt-5 pt-4 text-center">
                        <div>
                            <span class="block text-sm font-bold text-[#1D1D1F] dark:text-white"><?php echo esc_html($total_posts); ?></span>
                            <span class="block text-[10px] font-medium tracking-wide uppercase text-[#86868B] dark:text-zinc-500 mt-0.5"><?php _e('Posts', THEME); ?></span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-[#1D1D1F] dark:text-white"><?php echo esc_html($total_followers); ?></span>
                            <span class="block text-[10px] font-medium tracking-wide uppercase text-[#86868B] dark:text-zinc-500 mt-0.5"><?php _e('Followers', THEME); ?></span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-[#1D1D1F] dark:text-white"><?php echo esc_html($total_following); ?></span>
                            <span class="block text-[10px] font-medium tracking-wide uppercase text-[#86868B] dark:text-zinc-500 mt-0.5"><?php _e('Following', THEME); ?></span>
                        </div>
                    </div>

                    <div class="mt-5">
                        <button class="w-full py-2.5 px-4 rounded-xl bg-zinc-900 text-white dark:bg-white dark:text-black hover:bg-zinc-800 dark:hover:bg-zinc-200 font-medium text-xs tracking-wide transition-all duration-200 active:scale-[0.98] shadow-sm">
                            <?php _e('Follow Author', THEME); ?>
                        </button>
                    </div>

                </div>

            </aside>
            <div class="space-y-6">

                <div class="bg-white dark:bg-[#18181B] rounded-3xl p-6 border border-[#E5E5E7] dark:border-[#2D2D3A]">

                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold tracking-wide text-[#1D1D1F] dark:text-white">
                            <?php esc_html_e('My Posts', THEME); ?>
                        </h2>

                        <span class="text-sm text-[#86868B]">
                            <?php echo esc_html($author_posts->found_posts); ?>
                        </span>
                    </div>

                    <div class="grid grid-cols-1 gap-4">

                        <?php if ($author_posts->have_posts()) : ?>

                            <?php while ($author_posts->have_posts()) : $author_posts->the_post(); ?>

                                <?php
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
                                ?>

                            <?php endwhile; ?>

                            <?php wp_reset_postdata(); ?>

                        <?php else : ?>

                            <p class="text-[#86868B] text-sm text-center py-4">
                                <?php esc_html_e('This author has no posts yet.', THEME); ?>
                            </p>

                        <?php endif; ?>

                    </div>

                    <?php require PATH . '/components/pagination/component.php'; ?>

                </div>

            </div>

        </div>

    </div>
</main>

<?php get_footer(); ?>