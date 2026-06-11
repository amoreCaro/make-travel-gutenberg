<?php
if (!defined('ABSPATH')) {
    exit;
}

$nav_menu = get_nav_menu_locations();
$menu_items = [];

if (isset($nav_menu['header_menu'])) {
    $menu_id = $nav_menu['header_menu'];
    $menu_items = wp_get_nav_menu_items($menu_id);
}
// $socials = get_field("acf_social_icons", "option");
?>

<div id="burgerMenu" class="fixed inset-0 z-[1000] flex items-center justify-center opacity-0 pointer-events-none -translate-x-full transition-all duration-300 ease-out">

    <!-- Overlay -->
    <div id="burgerOverlay" class="absolute inset-0 bg-white/90 dark:bg-zinc-950/90 backdrop-blur-2xl"></div>

    <!-- Close button -->
    <button id="closeBurger" class="absolute top-4 right-4 sm:top-4 sm:right-5 z-50 p-2 sm:p-3 text-zinc-500 hover:text-black hover:bg-black/10 dark:text-zinc-400 dark:hover:text-white dark:hover:bg-white/10 rounded-full transition">
        <svg class="h-6 w-6 sm:h-8 sm:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <div class="relative z-10 w-full h-full flex flex-col justify-between items-center px-4 sm:px-5 py-8">

        <div class="flex flex-col items-center flex-1 justify-center w-full">
            
            <!-- Search -->
            <div class="relative w-full group mb-10 max-w-md md:max-w-xl lg:max-w-2xl">
                
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-zinc-400 group-focus-within:text-black dark:group-focus-within:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <input 
                    type="text" 
                    placeholder="Search for adventures..." 
                    class="w-full bg-black/5 border border-black/20 dark:bg-white/5 dark:border-white/20 rounded-full py-4 pl-14 pr-6 text-black dark:text-white text-lg placeholder:text-zinc-400 dark:placeholder:text-zinc-500 focus:outline-none focus:ring-2 focus:ring-black/20 dark:focus:ring-white/30 focus:bg-black/10 dark:focus:bg-white/10 transition-all duration-300"
                >
            </div>

            <!-- Menu -->
            <nav class="w-full max-w-md md:max-w-xl lg:max-w-2xl flex flex-col gap-6 sm:gap-8">
                <ul class="flex flex-col gap-3 sm:gap-4 w-full">
                    <?php if (!empty($menu_items)) : ?>
                        <?php foreach ($menu_items as $item) :
                            // $icon_svg = get_inline_svg_from_acf($item->ID);
                            $is_active = in_array('current-menu-item', $item->classes, true);
                        ?>
                            <li class="list-none">
                                <a
                                    href="<?php echo esc_url($item->url); ?>"
                                    class="group w-full flex items-center justify-between p-4 sm:p-5 rounded-full border border-black/20 dark:border-white/20 text-black dark:text-white hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-all duration-300 <?= $is_active ? 'bg-black text-white dark:bg-white dark:text-black' : ''; ?>"
                                >
                                    <div class="flex items-center gap-3 sm:gap-4">
                                        <?php if ($icon_svg) : ?>
                                            <span class="menu-icon">
                                                <?php echo $icon_svg; ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="text-lg sm:text-xl font-medium">
                                            <?php echo esc_html($item->title); ?>
                                        </span>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        

    </div>
</div>