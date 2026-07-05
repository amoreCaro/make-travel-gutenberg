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
    'likes' => [
        'label' => 'Liked Shots',
        'url'   => home_url('/likes'),
    ],
    'reading-list' => [
        'label' => 'Reading list',
        'url'   => home_url('/reading-list'),
    ],
    'create-post' => [
        'label' => 'Create Post',
        'url'   => home_url('/create-post'),
    ],
    'edit-profile' => [
        'label' => 'Edit Profile',
        'url'   => home_url('/edit-profile'),
    ],
];

$current_path = untrailingslashit(
    parse_url(home_url(add_query_arg(null, null)), PHP_URL_PATH)
);

$active_tab = 'work';

foreach ($subnav_items as $slug => $item) {
    $item_path = untrailingslashit(
        parse_url($item['url'], PHP_URL_PATH)
    );

    if ($item_path === $current_path) {
        $active_tab = $slug;
        break;
    }
}
?>

<div class="container px-5 py-5 xl:px-10 2xl:px-0 border-t border-neutral-200 dark:border-neutral-800">

    <nav class="relative -mx-5 xl:-mx-10 2xl:mx-0">

        <div
            id="profileSubnavLeftFade"
            class="absolute left-0 top-0 bottom-0 z-10 w-16 pointer-events-none
            bg-gradient-to-r from-white dark:from-neutral-950
            via-white/90 dark:via-neutral-950/90 to-transparent
            opacity-0 transition-opacity duration-300">
        </div>

        <button
            id="profileSubnavPrev"
            type="button"
            aria-label="<?php esc_attr_e('Прокрутити вліво', 'make-travel'); ?>"
            class="absolute left-1.5 top-1/2 z-20 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-full
            border border-neutral-200 bg-white opacity-0 shadow-[0_2px_8px_rgba(0,0,0,0.08)]
            pointer-events-none scale-90 transition-all duration-200
            hover:scale-105 hover:shadow-[0_4px_12px_rgba(0,0,0,0.12)]
            active:scale-95
            dark:border-neutral-800 dark:bg-neutral-900 dark:shadow-[0_2px_8px_rgba(0,0,0,0.5)]">

            <svg
                class="h-4 w-4 text-neutral-600 dark:text-neutral-300"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 6l-6 6 6 6" />
            </svg>
        </button>

        <ul
            id="profileSubnavList"
            class="flex items-center gap-1.5 overflow-x-auto scroll-smooth
            px-5 xl:px-10 2xl:px-0
            [&::-webkit-scrollbar]:hidden
            [-ms-overflow-style:none]
            [scrollbar-width:none]">

            <?php foreach ($subnav_items as $slug => $item) : ?>
                <?php $is_active = $slug === $active_tab; ?>

                <li class="flex-none">
                    <a
                        href="<?php echo esc_url($item['url']); ?>"
                        data-profile-tab="<?php echo esc_attr($slug); ?>"
                        <?php if ($is_active) : ?>
                            aria-current="page"
                        <?php endif; ?>
                        class="profile-subnav-link block whitespace-nowrap rounded-full border px-4 py-2
                        text-[16px] font-semibold leading-[18px] transition-all duration-200

                        <?php if ($is_active) : ?>
                            border-black bg-black text-white
                            dark:border-white dark:bg-white dark:text-black
                        <?php else : ?>
                            border-neutral-200 bg-transparent text-neutral-500
                            hover:border-neutral-100 hover:bg-neutral-100 hover:text-black
                            dark:border-neutral-800 dark:text-neutral-400
                            dark:hover:border-neutral-900 dark:hover:bg-neutral-900 dark:hover:text-white
                        <?php endif; ?>">

                        <?php echo esc_html($item['label']); ?>
                    </a>
                </li>

            <?php endforeach; ?>

        </ul>

        <div
            id="profileSubnavRightFade"
            class="absolute right-0 top-0 bottom-0 z-10 w-16 pointer-events-none
            bg-gradient-to-l from-white dark:from-neutral-950
            via-white/90 dark:via-neutral-950/90 to-transparent
            opacity-0 transition-opacity duration-300">
        </div>

        <button
            id="profileSubnavNext"
            type="button"
            aria-label="<?php esc_attr_e('Прокрутити вправо', 'make-travel'); ?>"
            class="absolute right-1.5 top-1/2 z-20 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-full
            border border-neutral-200 bg-white opacity-0 shadow-[0_2px_8px_rgba(0,0,0,0.08)]
            pointer-events-none scale-90 transition-all duration-200
            hover:scale-105 hover:shadow-[0_4px_12px_rgba(0,0,0,0.12)]
            active:scale-95
            dark:border-neutral-800 dark:bg-neutral-900 dark:shadow-[0_2px_8px_rgba(0,0,0,0.5)]">

            <svg
                class="h-4 w-4 text-neutral-600 dark:text-neutral-300"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 6l6 6-6 6" />
            </svg>
        </button>

    </nav>

</div>