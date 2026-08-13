<?php

if (!defined('ABSPATH')) {
    exit;
}

/*
Template Name: Edit Profile (Travel Blog UI)
*/

if (!is_user_logged_in()) {
    wp_redirect(wp_login_url());
    exit;
}

$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$user_nicename = $current_user->user_nicename;

get_header();
?>

<main class="main bg-white dark:bg-[#0E0E10] text-gray-900 min-h-screen font-sans antialiased">
    <div class="edit-profile py-[100px] mx-auto px-5 xl:px-10 2xl:px-0">

        <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-4 container">

                <div class="flex items-center gap-4">

                    <a
                        href="<?php echo esc_url( home_url('/author/' . $user_nicename ) ); ?>"
                        class="w-12 h-12 rounded-full bg-[#0F172A] dark:bg-zinc-800 flex items-center justify-center text-white font-semibold text-lg transition-colors"
                    >
                        <?php echo strtoupper(substr(esc_html($user_nicename), 0, 1)); ?>
                    </a>

                    <div>
                        <h1 class="flex items-center gap-2 text-xl font-bold text-gray-900 dark:text-white">
                            <span><?php echo esc_html($user_nicename); ?></span>

                            <span class="font-light text-gray-300 dark:text-zinc-600">
                                <?php _e("/", THEME); ?>
                            </span>

                            <span><?php _e("Edit Profile", THEME); ?></span>
                        </h1>

                        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                            <?php _e("Set up your travel blog profile, destinations, and storytelling identity", THEME); ?>
                        </p>
                    </div>

                </div>

            </div>
            <?php require PATH . '/components/profileSubnav/component.php'; ?>

        <div class="container grid items-start gap-8  md:grid-cols-[280px_2fr]">

            <?php require PATH . "/components/account-sidebar/component.php"; ?>

            <!-- Form -->
            <div class="bg-white dark:bg-zinc-900/40 border border-gray-100 dark:border-zinc-800/80 rounded-3xl p-10 shadow-sm w-full">

                <form method="post">
                    <?php wp_nonce_field('update_user_profile', 'update_profile_nonce'); ?>

                    <div data-tab-panel="profile">

                        <!-- PROFILE -->
                        <div class="mb-10">
                            <h2 class="text-[13px] font-bold tracking-wider uppercase text-gray-900 dark:text-zinc-400 border-b border-gray-100 dark:border-zinc-800/80 pb-4 mb-8">
                                Profile Basics
                            </h2>

                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-24 h-24 rounded-full bg-[#0F172A] dark:bg-zinc-800 flex items-center justify-center text-white font-semibold text-3xl shadow-sm">
                                    <?php echo strtoupper(substr(esc_html($user_nicename), 0, 1)); ?>
                                </div>

                                <div class="flex gap-3">
                                    <button
                                        type="button"
                                        class="px-5 py-2.5 border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 rounded-full text-xs font-bold text-gray-900 dark:text-zinc-200 hover:bg-gray-50 dark:hover:bg-zinc-700 hover:border-gray-300 dark:hover:border-zinc-600 transition"
                                    >
                                        Upload new picture
                                    </button>

                                    <button
                                        type="button"
                                        class="px-5 py-2.5 bg-gray-50 dark:bg-zinc-800 rounded-full text-xs font-bold text-gray-900 dark:text-zinc-200 hover:bg-gray-100 dark:hover:bg-zinc-700 transition"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-6">

                                <!-- Name -->
                                <div>
                                    <label class="block text-sm font-bold dark:text-white text-gray-900 mb-2">
                                        Name <span class="text-red-500">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="nickname"
                                        value="<?php echo esc_attr($current_user->user_nicename); ?>"
                                        class="w-full px-4 py-3 border border-gray-200 dark:border-zinc-800 bg-white dark:bg-[#0E0E10] text-gray-900 dark:text-zinc-100 placeholder:text-gray-400 dark:placeholder:text-zinc-500 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-zinc-500 dark:focus:ring-zinc-700"
                                        required
                                    >
                                </div>

                                <!-- Location -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 dark:text-zinc-200 mb-2">
                                        Location
                                    </label>

                                    <input
                                        type="text"
                                        name="location"
                                        value="Lviv, Ukraine"
                                        class="w-full px-4 py-3 border border-gray-200 dark:border-zinc-800 bg-white dark:bg-[#0E0E10] text-gray-900 dark:text-zinc-100 placeholder:text-gray-400 dark:placeholder:text-zinc-500 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-zinc-500 dark:focus:ring-zinc-700"
                                    >
                                </div>

                                <!-- Bio -->
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <label class="text-sm font-bold text-gray-900 dark:text-zinc-200">
                                            Bio
                                        </label>

                                        <span class="text-[11px] text-gray-400 dark:text-zinc-500">
                                            0/1024
                                        </span>
                                    </div>

                                    <textarea
                                        name="bio"
                                        rows="5"
                                        placeholder="Tell your travel story..."
                                        class="w-full px-4 py-3 border border-gray-200 dark:border-zinc-800 bg-white dark:bg-[#0E0E10] text-gray-900 dark:text-zinc-100 placeholder:text-gray-400 dark:placeholder:text-zinc-500 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-zinc-500 dark:focus:ring-zinc-700 resize-y"
                                    ></textarea>
                                </div>

                            </div>
                        </div>

                    </div>



                    <!-- SAVE -->
                    <div class="flex justify-end pt-4">
                        <button
                            type="submit"
                            class="px-6 py-3 bg-black dark:bg-white text-white dark:text-black hover:bg-[#2D2E3A] dark:hover:bg-zinc-200 text-sm font-bold rounded-full transition-colors shadow-sm"
                        >
                            Change
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</main>

<?php get_footer(); ?>