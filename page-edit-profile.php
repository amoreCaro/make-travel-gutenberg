<?php
if (!defined('ABSPATH')) {
    exit;
}

/*
Template Name: Edit Profile (Modern Dark/Light UI)
*/

// Redirect if user is not logged in
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url());
    exit;
}

$current_user = wp_get_current_user();
$user_id = $current_user->ID;

$success_message = '';
$error_message = '';

get_header();
?>

<!-- Added dark:bg-gray-950 and dark:text-gray-100 -->
<main class="main bg-white dark:bg-[#0A0A0B] text-gray-900 dark:text-white min-h-screen antialiased selection:bg-gray-200 dark:selection:bg-white/10">

    <div class="author-edit max-w-3xl mx-auto px-4 py-12 sm:px-6 lg:py-16">

        <!-- HEADER -->
        <div class="mb-8 pb-6 border-b border-gray-200 dark:border-white/10">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Profile Settings
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Update your username and manage your account.
            </p>
        </div>

        <!-- SUCCESS -->
        <?php if (!empty($success_message)): ?>
            <div class="mb-6 p-4 rounded-xl border bg-green-50 dark:bg-green-500/10 border-green-200 dark:border-green-500/20 text-green-700 dark:text-green-300 text-sm font-medium">
                <?php echo esc_html($success_message); ?>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="space-y-8">
            <?php wp_nonce_field('update_user_profile', 'update_profile_nonce'); ?>

            <!-- AVATAR -->
            <div>
                <label class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-3">
                    Profile picture
                </label>

                <div class="relative inline-block group">
                    <div class="w-32 h-32 rounded-2xl overflow-hidden bg-gray-100 dark:bg-white/5 border border-gray-200 dark:border-white/10 shadow-sm">
                        <?php $avatar_url = get_avatar_url($user_id, ['size' => 128]); ?>
                        <img src="<?php echo esc_url($avatar_url); ?>" class="w-full h-full object-cover">
                    </div>

                    <!-- CLOSE BTN -->
                    <button type="button"
                        class="absolute top-3 right-3 w-6 h-6 flex items-center justify-center
                        rounded-full bg-black/70 dark:bg-white/10 backdrop-blur-md
                        border border-white/10 text-white
                        hover:scale-110 transition-all">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>

                    </button>
                </div>
            </div>

            <!-- COVER -->
            <div>
                <label class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-3">
                    Cover photo
                </label>

                <div class="relative w-full h-48 rounded-2xl overflow-hidden border border-gray-200 dark:border-white/10 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-white/5 dark:to-transparent shadow-sm">
                    <button type="button"
                        class="absolute top-3 right-3 w-9 h-9 flex items-center justify-center
                        rounded-full bg-black/70 dark:bg-white/10 backdrop-blur-md
                        border border-white/10 text-white
                        hover:scale-110 transition-all">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>

                    </button>
                </div>
            </div>

            <!-- INPUTS -->
            <div class="space-y-6">

                <?php
                $fields = [
                    'first_name' => 'First Name',
                    'last_name'  => 'Last Name',
                    'nickname'   => 'Nickname (required)'
                ];

                foreach ($fields as $id => $label) {
                    echo "
                    <div>
                        <label for='$id' class='block text-sm font-medium text-gray-800 dark:text-gray-200 mb-2'>
                            $label
                        </label>

                        <input
                            type='text'
                            name='$id'
                            id='$id'
                            value='" . esc_attr($current_user->$id) . "'
                            class='w-full rounded-xl px-4 py-3 text-sm
                            bg-white dark:bg-white/5
                            border border-gray-200 dark:border-white/10
                            text-gray-900 dark:text-white
                            placeholder-gray-400 dark:placeholder-gray-500
                            focus:outline-none focus:ring-2 focus:ring-white/10
                            transition'
                        >
                    </div>";
                }
                ?>

                <!-- BIO -->
                <div>
                    <label class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-2">
                        Biographical Info
                    </label>

                    <textarea
                        name="biography"
                        rows="4"
                        class="w-full rounded-xl px-4 py-3 text-sm
                        bg-white dark:bg-white/5
                        border border-gray-200 dark:border-white/10
                        text-gray-900 dark:text-white
                        placeholder-gray-400 dark:placeholder-gray-500
                        focus:outline-none focus:ring-2 focus:ring-white/10
                        transition"
                    ><?php echo esc_textarea($current_user->description); ?></textarea>
                </div>

                <!-- WEBSITE -->
                <div>
                    <label class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-2">
                        Website
                    </label>

                    <div class="flex rounded-xl overflow-hidden border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5">

                        <div class="px-4 flex items-center bg-gray-100 dark:bg-white/10 text-gray-500">
                            🌐
                        </div>

                        <input
                            type="url"
                            name="website"
                            value="<?php echo esc_url($current_user->user_url); ?>"
                            class="w-full px-4 py-3 text-sm bg-transparent text-gray-900 dark:text-white focus:outline-none"
                        >
                    </div>
                </div>

            </div>

            <!-- SUBMIT -->
            <div class="pt-6">
                <button type="submit"
                    class="px-8 py-3 rounded-xl font-medium text-[16px] leading-[24px] bg-black text-white dark:bg-white dark:text-black hover:opacity-90 hover:scale-[1.02] transition-all duration-200 shadow-md">
                    Update profile
                </button>
            </div>

        </form>
    </div>
</main>

<?php get_footer(); ?>