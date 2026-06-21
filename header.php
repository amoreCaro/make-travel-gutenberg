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

$nav_menu   = get_nav_menu_locations();

$menu_items = [];


$current_user = wp_get_current_user();

if (isset($nav_menu['header_menu'])) {
    $menu_id    = $nav_menu['header_menu'];
    $menu_items = wp_get_nav_menu_items($menu_id);
}

$pages = carbon_get_theme_option('header_pages') ?: [];

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


<nav class="navigation hidden flex-1 justify-center lg:flex">
    <ul class="flex space-x-3">

        <?php if (!empty($menu_items)) : ?>
            <?php foreach ($menu_items as $item) :

                $bg_light = carbon_get_nav_menu_item_meta($item->ID, 'menu_bg_color');
                $bg_hover = carbon_get_nav_menu_item_meta($item->ID, 'menu_bg_hover_color');
                $icon_url = carbon_get_nav_menu_item_meta($item->ID, 'menu_item_image');

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

                        <?php if (!empty($icon_url)) : ?>
                            <span class="menu-icon flex items-center justify-center w-4 h-4">

                                <img
                                    src="<?php echo esc_url($icon_url); ?>"
                                    alt="<?php echo esc_attr($item->title); ?>"
                                    class="
                                        w-4 h-4 object-contain transition

                                        /* DARK MODE DEFAULT */
                                        dark:invert

                                        /* HOVER FIX (IMPORTANT) */
                                        group-hover:invert-0
                                        group-hover:brightness-0
                                    "
                                >

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
        <!-- RIGHT SIDE -->
        <div class="flex items-center gap-4 md:gap-6 text-sm flex-shrink-0">


            <!-- PAGES (Carbon Fields) -->
            <?php if (!empty($pages)) : ?>
                <div class="hidden lg:flex items-center gap-6">

                    <?php foreach ($pages as $page) :

                        $label = $page['label'] ?? '';
                        $url   = $page['url'] ?? '#';

                    ?>

                        <a href="<?php echo esc_url($url); ?>"
                        class="transition-colors hover:text-blue-400">

                            <?php echo esc_html($label); ?>

                        </a>

                    <?php endforeach; ?>

                </div>
            <?php endif; ?>


            <!-- AUTH (Login / Logout) -->
            <div class="flex items-center gap-4">

                <?php if (is_user_logged_in()) : ?>

                    <!-- PROFILE -->
                    <a href="/profile"
                    class="w-8 h-8 overflow-hidden rounded-full border border-white/10 shadow-sm">

                        <?php echo get_avatar($current_user->ID, 32); ?>

                    </a>

                    <!-- LOGOUT -->
                    <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>"
                    class="transition-colors hover:text-blue-400">

                        <?php echo esc_html($logout_text); ?>

                    </a>

                <?php else : ?>

                    <!-- LOGIN -->
                    <button type="button"
                            id="openSignInBtn"
                            class="transition-colors hover:text-blue-400">

                        <?php echo esc_html($login_text); ?>

                    </button>

                <?php endif; ?>

            </div>


            <!-- THEME TOGGLE -->
            <label for="theme-toggle" class="inline-flex items-center group relative cursor-pointer">

                <input type="checkbox" id="theme-toggle" class="sr-only peer">

                <div class="w-16 h-9 bg-slate-200 rounded-full transition-all peer-checked:bg-slate-800"></div>

                <div class="absolute left-1 top-1 w-7 h-7 bg-white rounded-full shadow-md flex items-center justify-center transition-all peer-checked:translate-x-7">

                    <svg class="w-4 h-4 text-amber-500 peer-checked:opacity-0"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1z"/>
                    </svg>

                    <svg class="absolute w-4 h-4 text-indigo-600 opacity-0 peer-checked:opacity-100"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8 8 0 1010.586 10.586z"/>
                    </svg>

                </div>

            </label>


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