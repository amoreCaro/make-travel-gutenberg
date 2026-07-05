<?php
if (!defined('ABSPATH')) {
    exit;
}

$current_user = wp_get_current_user();

$subnav_items = [
    'work' => [
        'label' => 'My Posts',
        'url'   => home_url('/author/' . $current_user->display_name),
    ],
    'reviews' => [
        'label' => 'Liked Shots',
        'url'   => home_url('/likes'),
    ],
    'reading-list' => [
        'label' => 'Reading list',
        'url'   => home_url('/reading-list'),
    ],

];
?>

<div class="container px-5 xl:px-10 2xl:px-0 py-5 border-t border-neutral-200 dark:border-neutral-800">

    <nav class="relative -mx-5 xl:-mx-10 2xl:mx-0">

        <!-- LEFT FADE + BUTTON -->
        <div
            id="profileSubnavLeftFade"
            class="absolute left-0 top-0 bottom-0 z-10 w-16 pointer-events-none
            bg-gradient-to-r from-neutral-50 dark:from-neutral-950
            via-neutral-50/90 dark:via-neutral-950/90 to-transparent
            opacity-0 transition-opacity duration-300">
        </div>

        <button
            id="profileSubnavPrev"
            class="absolute left-1.5 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full
            bg-white dark:bg-neutral-900
            border border-neutral-200 dark:border-neutral-800
            shadow-[0_2px_8px_rgba(0,0,0,0.08)]
            flex items-center justify-center opacity-0 pointer-events-none scale-90
            transition-all duration-200 hover:scale-105 hover:shadow-[0_4px_12px_rgba(0,0,0,0.12)] active:scale-95">

            <svg class="w-4 h-4 text-neutral-600 dark:text-neutral-300"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6"/>
            </svg>
        </button>

        <!-- NAV LIST -->
        <ul
            id="profileSubnavList"
            class="flex items-center gap-1.5 overflow-x-auto scroll-smooth
            px-5 xl:px-10 2xl:px-0
            [&::-webkit-scrollbar]:hidden
            [-ms-overflow-style:none]
            [scrollbar-width:none]">

            <?php foreach ($subnav_items as $slug => $item) : ?>
                <li class="flex-none">
                    <a
                        href="<?php echo esc_url($item['url']); ?>"
                        data-profile-tab="<?php echo esc_attr($slug); ?>"
                        class="profile-subnav-link block whitespace-nowrap rounded-full px-4 py-2
                        font-semibold transition-all duration-200 text-[16px] leading-[18px]
                        text-black dark:text-neutral-400 
                        border-gray-400 bg-white border-2 dark:hover:text-neutral-200">

                        <?php echo esc_html($item['label']); ?>
                    </a>
                </li>
            <?php endforeach; ?>

        </ul>

        <!-- RIGHT FADE + BUTTON -->
        <div
            id="profileSubnavRightFade"
            class="absolute right-0 top-0 bottom-0 z-10 w-16 pointer-events-none
            bg-gradient-to-l from-neutral-50 dark:from-neutral-950
            via-neutral-50/90 dark:via-neutral-950/90 to-transparent
            opacity-0 transition-opacity duration-300">
        </div>

        <button
            id="profileSubnavNext"
            class="absolute right-1.5 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full
            bg-white dark:bg-neutral-900
            border border-neutral-200 dark:border-neutral-800
            shadow-[0_2px_8px_rgba(0,0,0,0.08)]
            flex items-center justify-center opacity-0 pointer-events-none scale-90
            transition-all duration-200 hover:scale-105 hover:shadow-[0_4px_12px_rgba(0,0,0,0.12)] active:scale-95">

            <svg class="w-4 h-4 text-neutral-600 dark:text-neutral-300"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/>
            </svg>
        </button>

    </nav>

</div>