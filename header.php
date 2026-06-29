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


$login_text  = carbon_get_theme_option('header_login_text') ?: 'Login';
$logout_text = carbon_get_theme_option('header_logout_text') ?: 'Logout';

$current_user = wp_get_current_user();
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
                                    dark:border dark:border-white/40
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
                                <span class="menu-icon flex items-center justify-center w-4 h-4">
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
        <label for="theme-toggle" class="inline-flex relative items-center cursor-pointer select-none">
            <input type="checkbox" id="theme-toggle" class="sr-only peer" checked>
            <div class="w-9 h-5 bg-neutral-200 dark:bg-neutral-800 rounded-full transition-colors peer-checked:bg-sky-500"></div>
            <div class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow-sm transition-transform peer-checked:translate-x-4"></div>
        </label> 

    <?php if (is_user_logged_in()) : ?>

        <!-- PROFILE -->
        <button
            type="button"
            id="profile-popup-trigger"
            class="w-8 h-8 overflow-hidden rounded-full border border-white/10 shadow-sm"
        >
            <?php echo get_avatar($current_user->ID, 32); ?>
        </button>

        <!-- PROFILE POPUP -->
        <div
            id="profile-popup"
            class="absolute right-0 top-16 hidden w-72 rounded-2xl border p-4 transition-all duration-200 backdrop-blur-md
                bg-white/95 text-neutral-800 border-neutral-100 shadow-[0_20px_50px_rgba(0,0,0,0.05)]
                dark:bg-neutral-950/95 dark:text-neutral-200 dark:border-neutral-800/60 dark:shadow-[0_20px_50px_rgba(0,0,0,0.3)]"
        >
            <a href="<?php echo esc_url( home_url('/author/' . $current_user->user_nicename) ); ?>"
            class="flex items-center gap-3 pb-3 mb-2 border-b border-neutral-100 dark:border-neutral-800/60">

                <div class="w-10 h-10 rounded-xl overflow-hidden bg-neutral-100 dark:bg-neutral-900 border border-neutral-100 dark:border-neutral-800 shrink-0">
                    <?php echo get_avatar($current_user->ID, 40, '', '', [
                        'class' => 'w-full h-full object-cover'
                    ]); ?>
                </div>

                <div class="overflow-hidden">
                    <h4 class="font-semibold text-[14px] text-neutral-900 dark:text-white tracking-tight truncate">
                        <?php echo esc_html($current_user->display_name); ?>
                    </h4>

                    <p class="text-xs text-neutral-400 dark:text-neutral-500 truncate mt-0.5">
                        <?php echo esc_html($current_user->user_email); ?>
                    </p>
                </div>

            </a>

            <div class="space-y-0.5">
                <a href="#" class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group
                                hover:bg-neutral-50 text-neutral-600 hover:text-neutral-900
                                dark:hover:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white">
                    <svg class="w-4 h-4 text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Create</span>
                </a>

                <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" 
                class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group
                                hover:bg-neutral-50 text-neutral-600 hover:text-neutral-900
                                dark:hover:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white">
                    <svg class="w-4 h-4 text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span>Edit profile</span>
                </a>

                <a href="#" class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group
                                hover:bg-neutral-50 text-neutral-600 hover:text-neutral-900
                                dark:hover:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white">
                    <svg class="w-4 h-4 text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span>My Posts</span>
                </a>

                <a href="/reading-list" class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group hover:bg-neutral-50 text-neutral-600 hover:text-neutral-900 dark:hover:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white">
                    <svg class="w-4 h-4 text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                    </svg>
                    <span>Reading list</span>
                </a>
            </div>

            <div class="mt-2 pt-2 border-t border-neutral-100 dark:border-neutral-800/60 space-y-0.5">
                
                <div class="flex items-center justify-between py-2 px-2.5 text-[14px] font-medium text-neutral-600 dark:text-neutral-300">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                        <span>Dark theme</span>
                    </div>
                    <label for="theme-toggle" class="inline-flex relative items-center cursor-pointer select-none">
                        <input type="checkbox" id="theme-toggle" class="sr-only peer" checked>
                        <div class="w-9 h-5 bg-neutral-200 dark:bg-neutral-800 rounded-full transition-colors peer-checked:bg-sky-500"></div>
                        <div class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow-sm transition-transform peer-checked:translate-x-4"></div>
                    </label> 
                </div>

                <a href="#" class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group
                                hover:bg-neutral-50 text-neutral-600 hover:text-neutral-900
                                dark:hover:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white">
                    <svg class="w-4 h-4 text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                    <span>Help & Support</span>
                </a>

                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" 
                class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group
                                hover:bg-red-50 text-neutral-600 hover:text-red-600
                                dark:hover:bg-red-950/30 dark:text-neutral-300 dark:hover:text-red-400">
                    <svg class="w-4 h-4 text-neutral-400 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    <span>Log out</span>
                </a>
            </div>
        </div>
    <?php else : ?>

<button
    type="button"
    id="profile-popup-trigger-guest"
    class="w-8 h-8 flex items-center justify-center shrink-0 rounded-full active:scale-95
           bg-white text-neutral-900 dark:bg-neutral-950 dark:text-white
           transition-[background-color,color,transform] duration-300 ease-in-out
           hover:bg-neutral-950 hover:text-white hover:scale-105
           dark:hover:bg-white dark:hover:text-neutral-950"
>
    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M20.5899 22C20.5899 18.13 16.7399 15 11.9999 15C7.25991 15 3.40991 18.13 3.40991 22" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>  
</button>
<div id="profile-popup-guest"
     class="absolute right-0 top-16 hidden w-72 rounded-2xl border p-4 transition-all duration-200 backdrop-blur-md
            bg-white/95 text-neutral-800 border-neutral-100 shadow-[0_20px_50px_rgba(0,0,0,0.05)]
            dark:bg-neutral-950/95 dark:text-neutral-200 dark:border-neutral-800/60 dark:shadow-[0_20px_50px_rgba(0,0,0,0.3)] z-50">

    <div class="space-y-0.5">
        <a href="#" class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group
        hover:bg-neutral-50 text-neutral-600 hover:text-neutral-900
        dark:hover:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z"></path></svg>
            <span>Sign Up</span>
        </a>

        <button id="openSignInBtn" class="w-full flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group
        hover:bg-neutral-50 text-neutral-600 hover:text-neutral-900
        dark:hover:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0 1 19.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 0 0 4.5 10.5a7.464 7.464 0 0 1-1.15 3.993m1.989 3.559A11.209 11.209 0 0 0 8.25 10.5a3.75 3.75 0 1 1 7.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 0 1-3.6 9.75m6.633-4.596a18.666 18.666 0 0 1-2.485 5.33"></path></svg>
            <span>Log In</span>
    </button>

        <a href="#" class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group
                        hover:bg-neutral-50 text-neutral-600 hover:text-neutral-900
                        dark:hover:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path></svg>
            <span>Create</span>
        </a>

        <a href="#" class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group
                        hover:bg-neutral-50 text-neutral-600 hover:text-neutral-900
                        dark:hover:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z"></path></svg>
            <span>Reading list</span>
        </a>
    </div>

    <div class="mt-2 pt-2 border-t border-neutral-100 dark:border-neutral-800/60 space-y-0.5">
        <div class="flex items-center justify-between py-2 px-2.5 text-[14px] font-medium text-neutral-600 dark:text-neutral-300">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"></path></svg>
                <span>Dark theme</span>
            </div>
            <label for="theme-toggle" class="inline-flex relative items-center cursor-pointer select-none">
                <input type="checkbox" id="theme-toggle" class="sr-only peer" checked>
                <div class="w-9 h-5 bg-neutral-200 dark:bg-neutral-800 rounded-full transition-colors peer-checked:bg-sky-500"></div>
                <div class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow-sm transition-transform peer-checked:translate-x-4"></div>
            </label> 
        </div>

        <a href="#" class="flex items-center gap-3 py-2 px-2.5 rounded-xl text-[14px] font-medium transition-colors duration-150 group
                        hover:bg-neutral-50 text-neutral-600 hover:text-neutral-900
                        dark:hover:bg-neutral-900 dark:text-neutral-300 dark:hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.975 5.975 0 0 1-2.133-1.001A3.75 3.75 0 0 0 12 18Z"></path></svg>
            <span>Help & Support</span>
        </a>
    </div>
</div>
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