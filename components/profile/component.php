<?php
if (!defined('ABSPATH')) {
    exit;
}

$username   = $args['username'] ?? '';
$user_email = $args['user_email'] ?? '';
$author_id  = $args['author_id'] ?? 0;
?>

<div class="flex justify-between items-start mb-10 py-5">
    
    <!-- Left Side -->
    <div class="flex items-center gap-6">
        <div class="w-24 h-24 rounded-full overflow-hidden border border-neutral-200 dark:border-neutral-800 shrink-0">
            <?php echo get_avatar($author_id, 96); ?>
        </div>

        <div>
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">
                <?php echo esc_html($username); ?>
            </h1>

            <p class="text-sm text-neutral-500 mt-1">
                <?php echo esc_html($user_email); ?>
            </p>
        </div>
    </div>

    <a
        href="<?php echo esc_url(home_url('/edit-profile')); ?>"
        class="inline-flex items-center justify-center gap-1.5 px-4 py-2 text-[14px] leading-[14px] font-medium rounded-full text-neutral-900 border-2 border-neutral-900 hover:bg-neutral-900 hover:text-white transition-all dark:border-neutral-100 dark:text-white dark:hover:bg-white dark:hover:text-neutral-900 shrink-0"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2.5"
            stroke="currentColor"
            class="w-3.5 h-3.5"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"
            />
        </svg>

        <span><?php _e("Edit Profile", THEME); ?></span>
    </a>

</div>