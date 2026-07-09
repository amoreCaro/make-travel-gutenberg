<?php

if (!defined('ABSPATH')) {
    exit;
}

$current_user = wp_get_current_user();
$is_author_page = is_author($current_user->ID);

$display_name     = $current_user->display_name ?: __('User', THEME);
$user_email       = $current_user->user_email;
$user_description = get_user_meta($current_user->ID, 'description', true);

$youtube = get_user_meta($current_user->ID, 'youtube', true);
$tiktok  = get_user_meta($current_user->ID, 'tiktok', true);
$github  = get_user_meta($current_user->ID, 'github', true);

$initial = strtoupper(mb_substr($display_name, 0, 1));

$menu_items = [
    [
        'title'  => __('Dashboard', THEME),
        'url'    => home_url('/profile/'),
        'active' => is_page('profile'),
        'icon'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
    ],
    [
        'title'  => __('Create post', THEME),
        'url'    => home_url('/create-post/'),
        'active' => is_page('create-post'),
        'icon'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>',
    ],
    [
        'title'  => __('Profile', THEME),
        'url'    => home_url('/edit-profile/'),
        'active' => is_page('edit-profile'),
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"></path></svg>'   
    ],
       [
        'title'  => __('My Posts', THEME),
        'url'    => home_url('/my-posts/'),
        'active' => is_page('my-posts'),
        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>',
    ],
    [
        'title'  => __('Liked shots', THEME),
        'url'    => home_url('/likes/'),
        'active' => is_page('likes'),
        'icon'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>',
    ],
    [
        'title'  => __('Reading list', THEME),
        'url'    => home_url('/reading-list/'),
        'active' => is_page('reading-list'),
        'icon'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>',
    ],
];

?>

<!-- Added '' to the classes below -->
<aside id="aside" class="sticky top-[200px] self-start bg-white dark:bg-[#18181B] rounded-3xl border border-[#E5E5E7] dark:border-[#2D2D3A] hidden md:block ">

    <!-- Profile -->
    <div class="p-6 border-b border-[#E5E5E7] dark:border-[#2D2D3A]">

        <div class="flex items-center gap-4">

            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-zinc-900 text-white dark:bg-white dark:text-black text-lg font-semibold">
                <?php echo esc_html($initial); ?>
            </div>

            <div class="min-w-0 flex-1">
                <h3 class="truncate font-semibold text-[#1D1D1F] dark:text-white">
                    <?php echo esc_html($display_name); ?>
                </h3>

                <?php if ($user_email) : ?>
                    <p class="truncate text-sm text-[#86868B] dark:text-zinc-400">
                        <?php echo esc_html($user_email); ?>
                    </p>
                <?php endif; ?>
            </div>

        </div>

    </div>

    <!-- Navigation -->
    <div class="p-6">

        <nav aria-label="<?php esc_attr_e('Profile navigation', THEME); ?>">
            <ul class="space-y-1">
                <?php foreach ($menu_items as $item) : ?>
                    <li>
                        <a
                            href="<?php echo esc_url($item['url']); ?>"
                            <?php if ($item['active']) : ?>aria-current="page"<?php endif; ?>
                            class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-colors duration-200 <?php echo $item['active']
                                ? 'bg-[#F5F5F7] dark:bg-white/10 text-[#1D1D1F] dark:text-white font-medium'
                                : 'text-[#86868B] hover:text-[#1D1D1F] dark:hover:text-white hover:bg-[#F5F5F7] dark:hover:bg-white/5'; ?>"
                        >
                            <?php echo $item['icon']; ?>
                            <span><?php echo esc_html($item['title']); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="mt-8 pt-6 border-t border-[#E5E5E7] dark:border-[#2D2D3A]">
            <a
                href="<?php echo esc_url(wp_logout_url(home_url())); ?>"
                class="flex items-center gap-4 px-4 py-3 rounded-2xl text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>

                <span><?php _e('Logout', THEME); ?></span>
            </a>
        </div>

    </div>

</aside>