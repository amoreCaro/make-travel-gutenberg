
<?php

if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="account-sidebar hidden md:block">
    <nav id="profileTabsNav" class="sticky top-28">

        <ul class="space-y-1">
            <li>
                <a
                    href="#general"
                    data-tab="general"
                    class="profile-tab-link flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-500 transition-colors hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-zinc-800 dark:hover:text-white"
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-gray-300 dark:bg-zinc-600"></span>
                    <?php _e("General", THEME); ?>
                </a>
            </li>

            <li>
                <a
                    href="#profile"
                    data-tab="profile"
                    class="profile-tab-link is-active flex items-center gap-3 rounded-xl bg-gray-100 px-4 py-3 text-sm font-semibold text-gray-900 dark:bg-zinc-800 dark:text-white"
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-black dark:bg-white"></span>
                    <?php _e("Edit Profile", THEME); ?>
                </a>
            </li>

            <li>
                <a
                    href="#password"
                    data-tab="password"
                    class="profile-tab-link flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-500 transition-colors hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-zinc-800 dark:hover:text-white"
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-gray-300 dark:bg-zinc-600"></span>
                    <?php _e("Password", THEME); ?>
                </a>
            </li>
            <li>
                <a
                    href="<?php echo esc_url( home_url('/create-post/' ) ); ?>"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-500 transition-colors hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-zinc-800 dark:hover:text-white"
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-gray-300 dark:bg-zinc-600"></span>
                    <?php _e("Create Post", THEME); ?>
                </a>
            </li>
            <li>
                <a
                    href="<?php echo esc_url( home_url('/author/' . $current_user->user_nicename) ); ?>"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-500 transition-colors hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-zinc-800 dark:hover:text-white"
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-gray-300 dark:bg-zinc-600"></span>
                    <?php _e("My Posts", THEME); ?>
                </a>
            </li>
            <li>
                <a
                    href="<?php echo esc_url(home_url('/likes')); ?>"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-500 transition-colors hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-zinc-800 dark:hover:text-white"
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-gray-300 dark:bg-zinc-600"></span>
                    <?php _e("Liked Shots", THEME); ?>
                </a>
            </li>
            <li>
                <a
                    href="<?php echo esc_url(home_url('/reading-list')); ?>"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-gray-500 transition-colors hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-zinc-800 dark:hover:text-white"
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-gray-300 dark:bg-zinc-600"></span>
                    <?php _e("Reading List", THEME); ?>
                </a>
            </li>
        </ul>

    </nav>
</div>