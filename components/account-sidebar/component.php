<?php

if (!defined('ABSPATH')) {
    exit;
}

$current_user = wp_get_current_user();
$is_author_page = is_author($current_user->ID);

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
    [
        'title'  => __('Edit Profile', THEME),
        'url'    => home_url('/edit-profile/'),
        'active' => is_page('edit-profile'),
        'icon'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
    ],
];

?>

<aside class="bg-white dark:bg-[#18181B] rounded-3xl p-6 flex flex-col justify-between border border-[#E5E5E7] dark:border-[#2D2D3A] hidden md:block">
    
    <div>
        <nav aria-label="<?php esc_attr_e('Profile navigation', THEME); ?>">
            <ul class="space-y-1">
                <?php foreach ($menu_items as $item) : ?>
                    <li>
                        <a
                            href="<?php echo esc_url($item['url']); ?>"
                            <?php if ($item['active']) : ?>
                                aria-current="page"
                            <?php endif; ?>
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
    </div>

    <div class="mt-8 pt-4 border-t border-[#E5E5E7] dark:border-[#2D2D3A]">
        <a 
            href="<?php echo esc_url(wp_logout_url(home_url())); ?>" 
            class="flex items-center gap-4 px-4 py-3 rounded-2xl text-red-500 hover:text-red-600 hover:bg-red-50/50 dark:hover:bg-red-500/10 transition-colors duration-200 font-medium"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span><?php _e('Logout', THEME); ?></span>
        </a>
    </div>

</aside>