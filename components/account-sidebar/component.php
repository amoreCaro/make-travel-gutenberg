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
        'title'  => __('Liked shots', THEME),
        'url'    => home_url('/likes/'),
        'active' => is_page('likes'),
        'icon'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>',
    ],
    [
        'title'  => __('Create post', THEME),
        'url'    => home_url('/create-post/'),
        'active' => is_page('create-post'),
        'icon'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>',
    ],
    [
        'title'  => __('Profile', THEME),
        'url'    => home_url('/author/' . $current_user->user_nicename),
        'active' => $is_author_page,
        'icon'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>',
    ],
    [
        'title'  => __('My Posts', THEME),
        'url'    => home_url('/my-posts'),
        'active' => false,
        'icon'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>',
    ],
    [
        'title'  => __('Reading list', THEME),
        'url'    => home_url('/reading-list/'),
        'active' => is_page('reading-list'),
        'icon'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>',
    ],
];

?>

<aside class="bg-white dark:bg-[#18181B] rounded-3xl border border-[#E5E5E7] dark:border-[#2D2D3A] hidden md:block overflow-hidden">

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

        <div class="flex items-center gap-2 mt-5">

                <a href="<?php echo esc_url($youtube); ?>" target="_blank" rel="noopener"
                   class="flex h-9 w-9 items-center justify-center rounded-xl hover:bg-zinc-100 dark:hover:bg-white/10 transition">
                    <svg fill="currentColor" class="w-4 h-4" viewBox="0 0 576 512">
                        <path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"/>
                    </svg>
                </a>

                <a href="<?php echo esc_url($tiktok); ?>" target="_blank" rel="noopener"
                   class="flex h-9 w-9 items-center justify-center rounded-xl hover:bg-zinc-100 dark:hover:bg-white/10 transition">
                    <svg fill="currentColor" class="w-4 h-4" viewBox="0 0 448 512">
                        <path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25V349.38A162.55 162.55 0 1 1 185 188.31V278.2a74.62 74.62 0 1 0 52.23 71.18V0h88a121.18 121.18 0 0 0 1.86 22.17A122.18 122.18 0 0 0 381 102.39a121.43 121.43 0 0 0 67 20.14z"/>
                    </svg>
                </a>


                <a href="<?php echo esc_url($github); ?>" target="_blank" rel="noopener"
                   class="flex h-9 w-9 items-center justify-center rounded-xl hover:bg-zinc-100 dark:hover:bg-white/10 transition">
                    <svg fill="currentColor" class="w-4 h-4" viewBox="0 0 496 512">
                        <path d="M244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8z"/>
                    </svg>
                </a>

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