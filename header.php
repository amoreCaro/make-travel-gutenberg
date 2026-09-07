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
                <div class="pages hidden lg:flex items-center gap-6">

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

            <div id="searchWrapper" class="flex items-center relative">

                <!-- OPEN SEARCH -->

                <button
                    type="button"
                    id="openSearchBtn"
                    class="flex items-center text-zinc-500 hover:text-blue-600 dark:text-zinc-400 dark:hover:text-blue-400 transition-colors duration-200"
                    aria-label="<?php esc_attr_e('Open search', THEME); ?>"
                    aria-expanded="false"
                    aria-controls="searchContainer"
                >
                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                    >
                        <circle
                            cx="11"
                            cy="11"
                            r="7"
                            stroke="currentColor"
                            stroke-width="1.5"
                        />
                        <path
                            d="M16.5 16.5L21 21"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                        />
                    </svg>
                </button>

                <!-- SEARCH CONTAINER -->

                <div
                    id="searchContainer"
                    class="hidden items-center gap-2"
                    aria-hidden="true"
                >
                    <div class="relative flex items-center">

                        <input
                            type="search"
                            id="searchInput"
                            name="search"
                            placeholder="<?php esc_attr_e('Search...', THEME); ?>"
                            class="w-56 lg:w-[510px] rounded-full border border-blue-500 bg-white px-4 py-2 pr-9 text-sm text-zinc-900 placeholder:text-zinc-400 outline-none transition-all focus:border-blue-600 focus:ring-1 focus:ring-blue-600 dark:border-zinc-700 dark:bg-[#18181b] dark:text-zinc-100 dark:placeholder:text-zinc-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 [&::-webkit-search-cancel-button]:appearance-none [&::-webkit-search-decoration]:appearance-none"
                            autocomplete="off"
                        />

                        <!-- CLOSE BUTTON INSIDE / NEXT TO INPUT AREA -->
                        <button
                            type="button"
                            id="closeSearchBtn"
                            class="absolute right-2.5 flex h-5 w-5 items-center justify-center rounded-full text-zinc-400 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-100 transition-colors focus:outline-none"
                            aria-label="<?php esc_attr_e('Close search', THEME); ?>"
                        >
                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true"
                            >
                                <path
                                    d="M18 6L6 18M6 6L18 18"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                />
                            </svg>
                        </button>

                    </div>

                </div>
                <?php require PATH . '/components/search-popup/component.php'; ?>
            </div>

                <label for="theme-toggle" class="inline-flex relative items-center cursor-pointer select-none">
                <input type="checkbox" id="theme-toggle" class="sr-only peer" checked>
                <div class="w-11 h-6 rounded-full transition-all duration-200 border
                    bg-neutral-200 border-transparent peer-checked:bg-neutral-900
                    dark:bg-neutral-900 dark:border-neutral-700 dark:peer-checked:bg-neutral-800
                    after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                    after:w-5 after:h-5 after:rounded-full after:transition-all after:shadow-sm
                    after:bg-white dark:after:bg-neutral-400 dark:peer-checked:after:bg-white
                    peer-checked:after:translate-x-[20px]">
                </div>
            </label>
        </div>

        <!-- BURGER -->
        <button id="openBurgerBtn" class="w-[24px] h-[24px] lg:hidden hover:text-blue-400 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="h-7 w-7 lg:h-8 lg:w-8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path></svg>
        </button>

        </div>

    </div>

</header>


