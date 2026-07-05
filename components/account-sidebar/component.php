<?php

if (!defined('ABSPATH')) {
    exit;
}

$default_classes = 'text-slate-500 hover:text-slate-900 dark:text-neutral-400 dark:hover:text-neutral-100 hover:bg-black/[0.03] dark:hover:bg-white/[0.04] transition-all duration-200';

$active_classes = 'bg-black/5 text-slate-900 font-semibold dark:bg-white/10 dark:text-neutral-50';

$current_user = wp_get_current_user();

?>

<div class="account-sidebar hidden lg:block">
    <nav id="profileTabsNav" class="sticky top-28">

        <ul class="space-y-1">

            <li>
                <a
                    href="<?php echo esc_url(home_url('/edit-profile/#general')); ?>"
                    data-tab="general"
                    class="profile-tab-link flex items-center gap-3 rounded-xl px-4 py-3 text-sm <?php echo $default_classes; ?> [&.is-active]:bg-black/5 [&.is-active]:text-slate-900 [&.is-active]:font-semibold dark:[&.is-active]:bg-white/10 dark:[&.is-active]:text-neutral-50"
                >
                    <?php _e('General', THEME); ?>
                </a>
            </li>

            <li>
                <a
                    href="<?php echo esc_url(home_url('/edit-profile/#profile')); ?>"
                    data-tab="profile"
                    class="profile-tab-link flex items-center gap-3 rounded-xl px-4 py-3 text-sm <?php echo $default_classes; ?> [&.is-active]:bg-black/5 [&.is-active]:text-slate-900 [&.is-active]:font-semibold dark:[&.is-active]:bg-white/10 dark:[&.is-active]:text-neutral-50"
                >
                    <?php _e('Edit Profile', THEME); ?>
                </a>
            </li>

            <li>
                <a
                    href="<?php echo esc_url(home_url('/edit-profile/#password')); ?>"
                    data-tab="password"
                    class="profile-tab-link flex items-center gap-3 rounded-xl px-4 py-3 text-sm <?php echo $default_classes; ?> [&.is-active]:bg-black/5 [&.is-active]:text-slate-900 [&.is-active]:font-semibold dark:[&.is-active]:bg-white/10 dark:[&.is-active]:text-neutral-50"
                >
                    <?php _e('Password', THEME); ?>
                </a>
            </li>

            <li>
                <a
                    href="<?php echo esc_url(home_url('/create-post/')); ?>"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm <?php echo is_page('create-post') ? $active_classes : $default_classes; ?>"
                >
                    <?php _e('Create Post', THEME); ?>
                </a>
            </li>

            <li>
                <a
                    href="<?php echo esc_url(home_url('/author/' . $current_user->user_nicename)); ?>"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm <?php echo is_author($current_user->user_nicename) ? $active_classes : $default_classes; ?>"
                >
                    <?php _e('My Posts', THEME); ?>
                </a>
            </li>

            <li>
                <a
                    href="<?php echo esc_url(home_url('/likes/')); ?>"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm <?php echo is_page('likes') ? $active_classes : $default_classes; ?>"
                >
                    <?php _e('Liked Shots', THEME); ?>
                </a>
            </li>

            <li>
                <a
                    href="<?php echo esc_url(home_url('/reading-list/')); ?>"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm <?php echo is_page('reading-list') ? $active_classes : $default_classes; ?>"
                >
                    <?php _e('Reading List', THEME); ?>
                </a>
            </li>

        </ul>

    </nav>
</div>