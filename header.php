<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php

$logo_type   = carbon_get_theme_option('header_logo_type');
$logo_text   = carbon_get_theme_option('header_logo_text');
$logo_img_id = carbon_get_theme_option('header_logo_image');
/**
 * MENU (Carbon Fields version)
 */

$nav_menu = get_nav_menu_locations();

$menu_items = [];
$pages_menu_items = [];

$header_menu_id = $nav_menu['header_menu'] ?? 0;
$pages_menu_id  = $nav_menu['pages_menu'] ?? 0;

if ($header_menu_id) {
    $menu_items = wp_get_nav_menu_items($header_menu_id) ?: [];
}

if ($pages_menu_id) {
    $pages_menu_items = wp_get_nav_menu_items($pages_menu_id) ?: [];
}
$login_text = carbon_get_theme_option('header_login_text') ?: 'Login';
$logout_text = carbon_get_theme_option('header_logout_text');

$current_user = wp_get_current_user();
$username = $current_user->display_name;
$user_email = $current_user->user_email;
$user_avatar_small = get_avatar($current_user->ID, 32);

?>

<div class="l-wrapper bg-white dark:bg-black">

<header class="header-default fixed top-0 left-0 z-[100] w-full px-5 xl:px-10 h-[80px] flex items-center bg-white text-black dark:bg-black dark:text-white">
    <div class="container flex items-center justify-between">

        <!-- ================= LOGO ================= -->
        <?php if ($logo_text || $logo_img_id) : ?>
            <a href="<?php echo esc_url(home_url('/')); ?>"
               class="flex items-center flex-shrink-0 no-underline text-black dark:text-white">

                <?php if ($logo_type === 'image' && $logo_img_id) : ?>

                    <?php echo wp_get_attachment_image(
                        $logo_img_id,
                        'full',
                        false,
                        [
                            'alt'   => esc_attr($logo_text),
                            'class' => 'w-full max-w-[130px] h-10 object-contain'
                        ]
                    ); ?>

                <?php elseif ($logo_type === 'text') : ?>

                    <span class="text-xl font-medium tracking-tight">
                        <?php echo esc_html($logo_text); ?>
                    </span>
                <?php endif; ?>
            </a>
        <?php endif; ?>

        <?php if (!empty($menu_items)) : ?>
        <nav class="navigation hidden flex-1 justify-center lg:flex">
            <ul class="flex space-x-3">

                <?php if (!empty($menu_items)) : ?>
                    <?php foreach ($menu_items as $item) :

                        $bg_light = carbon_get_nav_menu_item_meta($item->ID, 'menu_bg_color');
                        $bg_hover = carbon_get_nav_menu_item_meta($item->ID, 'menu_bg_hover_color');
                        $icon_id  = carbon_get_nav_menu_item_meta($item->ID, 'menu_item_image');
                        $icon_url = $icon_id ? wp_get_attachment_url((int) $icon_id) : '';
                        $icon_svg = cf_get_inline_svg($icon_url, 16, 16);
                        $is_active = !empty($item->classes) && in_array('current-menu-item', $item->classes, true);

                        $bg_light = $bg_light ?: '#ffffff';
                        $bg_hover = $bg_hover ?: '#f3f3f3';

                    ?>

                        <li class="list-none">

                            <a
                                href="<?php echo esc_url($item->url); ?>"
                                class="group flex items-center gap-2 rounded-full px-4 py-1.5
                                    bg-[var(--bg-color)] hover:bg-[var(--bg-hover)]
                                    text-black transition-all

                                    dark:bg-transparent
                                    dark:border dark:border-[#7A747466]
                                    dark:text-white
                                    dark:hover:bg-white
                                    dark:hover:text-black

                                    <?php echo $is_active ? 'bg-white text-black dark:bg-white dark:text-black' : ''; ?>"
                                style="
                                    --bg-color: <?php echo esc_attr($bg_light); ?>;
                                    --bg-hover: <?php echo esc_attr($bg_hover); ?>;
                                "
                            >

                            <?php if (!empty($icon_svg)) : ?>
                                <span class="menu-icon flex shrink-0 items-center justify-center w-5 h-5">
                                    <?php echo $icon_svg; ?>
                                </span>
                            <?php endif; ?>

                                <span class="menu-text text-sm font-medium">
                                    <?php echo esc_html($item->title); ?>
                                </span>

                            </a>

                        </li>

                    <?php endforeach; ?>
                <?php endif; ?>

            </ul>
        </nav>
        <?php endif; ?>
        <!-- RIGHT SIDE -->
        <div class="flex items-center gap-4 md:gap-6 text-sm flex-shrink-0">


            <!-- PAGES (Carbon Fields) -->
            <?php if (!empty($pages_menu_items)) : ?>
                <div class="hidden lg:flex items-center gap-6">

                    <?php foreach ($pages_menu_items as $item) : 
                        $is_item_active = !empty($item->classes) && in_array('current-menu-item', $item->classes, true);
                    ?>

                        <a href="<?php echo esc_url($item->url); ?>"
                        class="transition-colors hover:text-blue-400 <?php echo $is_item_active ? 'text-blue-400 font-semibold' : ''; ?>">
                            <?php echo esc_html($item->title); ?>
                        </a>

                    <?php endforeach; ?>

                </div>
            <?php endif; ?>


            <!-- AUTH (Login / Logout) -->
    <div class="flex items-center gap-4 relative">

    <?php if (is_user_logged_in()) : ?>

        <!-- PROFILE -->
        <button
            type="button"
            id="profile-popup-trigger"
            class="flex items-center gap-2 rounded-full transition-colors duration-150 focus:outline-none focus:ring-0 focus:border-transparent select-none group
                /* Світла тема */
                text-neutral-700 hover:text-neutral-900 sm:hover:bg-neutral-100 sm:py-1 sm:pl-1 sm:pr-3
                /* Темна тема */
                dark:text-neutral-300 dark:hover:text-white sm:dark:hover:bg-neutral-900"
        >
            <!-- Контейнер для аватарки (статичний, без контурів) -->
            <div class="w-8 h-8 min-w-[32px] min-h-[32px] overflow-hidden rounded-full shadow-sm">
                <?php echo $user_avatar_small; ?>
            </div>
            
            <!-- Ім'я користувача (fixed: повернуто sm:inline замість sm:block, щоб текст не стрибав вниз) -->
            <span class="hidden sm:block text-[14px] font-medium">
                <?php echo esc_html($username); ?>
            </span>
        </button>

        <!-- PROFILE POPUP -->
        <div
            id="profile-popup"
            class="absolute right-0 top-16 hidden w-72 rounded-2xl border p-4 transition-all duration-200 backdrop-blur-md
                bg-white/95 text-neutral-800 border-neutral-100 shadow-[0_20px_50px_rgba(0,0,0,0.05)]
                dark:bg-neutral-950/95 dark:text-neutral-200 dark:border-neutral-800/60 dark:shadow-[0_20px_50px_rgba(0,0,0,0.3)]"
        >
            <a href="<?php echo esc_url(home_url('/author/' . $username)); ?>"
            class="flex items-center gap-3 pb-3 mb-2 border-b border-neutral-100 dark:border-neutral-800/60">

                <div class="w-10 h-10 rounded-xl overflow-hidden bg-neutral-100 dark:bg-neutral-900 border border-neutral-100 dark:border-neutral-800 shrink-0">
                    <?php echo get_avatar($current_user->ID, 40, '', '', [
                        'class' => 'w-full h-full object-cover'
                    ]); ?>
                </div>

                <div class="overflow-hidden">
                    <h4 class="font-semibold text-[14px] text-neutral-900 dark:text-white tracking-tight truncate">
                        <?php echo esc_html($username); ?>
                    </h4>

                    <p class="text-xs text-neutral-400 dark:text-neutral-500 truncate mt-0.5">
                        <?php echo esc_html($user_email); ?>
                    </p>
                </div>

            </a>

            <div class="space-y-0.5">
                <a href="/create-post" class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group
                                hover:bg-neutral-50 text-neutral-600 hover:text-neutral-900
                                dark:hover:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white">
                    <svg class="w-5 h-5 text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span><?php _e('Create post', THEME); ?></span>
                </a>

                <a href="/edit-profile" 
                class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group
                                hover:bg-neutral-50 text-neutral-600 hover:text-neutral-900
                                dark:hover:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white">
                    <svg class="w-5 h-5 text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 20 20">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span><?php _e('Edit profile', THEME); ?></span>
                </a>

                <a href="/my-posts" class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group
                                hover:bg-neutral-50 text-neutral-600 hover:text-neutral-900
                                dark:hover:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white">
                    <svg class="w-5 h-5 text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span><?php _e('My posts', THEME); ?></span>
                </a>

                <a href="/likes" class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group hover:bg-neutral-50 text-neutral-600 hover:text-neutral-900 dark:hover:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <span><?php _e('Liked shots', THEME); ?></span>
                </a>

                <a href="/reading-list" class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group hover:bg-neutral-50 text-neutral-600 hover:text-neutral-900 dark:hover:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white">
                    <svg class="w-5 h-5 text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                    </svg>
                    <span><?php _e('Reading list', THEME); ?></span>
                </a>
            </div>

            <div class="mt-2 pt-2 border-t border-neutral-100 dark:border-neutral-800/60 space-y-0.5">
                
                <div class="flex items-center justify-between py-2 px-2.5 text-[14px] font-medium text-neutral-600 dark:text-neutral-300">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                        <span><?php _e('Dark theme', THEME); ?></span>
                    </div>
<label for="theme-toggle" class="inline-flex relative items-center cursor-pointer select-none">
    <input type="checkbox" id="theme-toggle" class="sr-only peer" checked>
    
    <div class="w-11 h-6 rounded-full transition-all duration-200 border bg-neutral-200 border-transparent peer-checked:bg-neutral-900 dark:bg-neutral-900 dark:border-neutral-700 dark:peer-checked:bg-neutral-800 after:content-[''] after:absolute after:top-[2px] after:left-[2px]  after:w-5 after:h-5 after:rounded-full after:transition-all after:shadow-sm after:bg-white dark:after:bg-neutral-400 dark:peer-checked:after:bg-white peer-checked:after:translate-x-[20px]">
    </div>
</label>
                </div>

                <a href="/help-support" class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group
                                hover:bg-neutral-50 text-neutral-600 hover:text-neutral-900
                                dark:hover:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white">
                    <svg class="w-5 h-5 text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                    <span><?php _e('Help & Support', THEME); ?></span>
                </a>

                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" 
                class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group
                                hover:bg-red-50 text-neutral-600 hover:text-red-600
                                dark:hover:bg-red-950/30 dark:text-neutral-300 dark:hover:text-red-400">
                    <svg class="w-5 h-5 text-neutral-400 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    <span><?php _e('Log out', THEME); ?></span>
                </a>
            </div>
        </div>
    <?php else : ?>
<label for="theme-toggle" class="inline-flex relative items-center cursor-pointer select-none">
    <input type="checkbox" id="theme-toggle" class="sr-only peer" checked>
    
    <div class="w-11 h-6 rounded-full transition-all duration-200 border
        bg-neutral-200 border-transparent peer-checked:bg-neutral-900

        dark:bg-neutral-900 dark:border-neutral-700 dark:peer-checked:bg-neutral-800
        
        after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
        after:w-5 after:h-5 after:rounded-full after:transition-all after:shadow-sm
        after:bg-white dark:after:bg-neutral-400 dark:peer-checked:after:bg-white
        
        /* Зміщення кульки при кліку */
        peer-checked:after:translate-x-[20px]">
    </div>
</label>
<button class="openLoginBtn flex items-center justify-center rounded-full font-medium border transition-all duration-200 py-1.5 px-4 text-[13px] sm:py-2 sm:px-6 sm:text-[14px] bg-transparent border-black text-black hover:bg-black hover:text-white dark:border-white dark:text-white dark:hover:bg-white dark:hover:text-black">
    
    <span><?php echo esc_html( $login_text ); ?></span>
</button>
    <?php endif; ?>

</div>

            <!-- BURGER -->
            <button id="openBurgerBtn"
                    class="w-[24px] h-[24px] lg:hidden hover:text-blue-400 transition-colors">

                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="w-full h-full">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />

                </svg>

            </button>

        </div>

    </div>

</header> 