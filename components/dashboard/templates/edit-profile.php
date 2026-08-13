<?php
if (!defined('ABSPATH')) {
    exit;
}

$categories = get_categories([
    'hide_empty' => false,
]);

$current_user = wp_get_current_user();
$user_nicename = $current_user->user_nicename;
?>

<section class="dashboard-profile">
    <form method="post">
        <?php wp_nonce_field('update_user_profile', 'update_profile_nonce'); ?>

        <div data-tab-panel="profile">

            <!-- PROFILE -->
            <div class="mb-10">

                <div class="flex items-center gap-4 mb-8">
                    <div class="w-24 h-24 rounded-full bg-[#0F172A] dark:bg-gray-700 flex items-center justify-center text-white font-semibold text-3xl shadow-sm overflow-hidden relative">
                        <!-- Initials Fallback -->
                        <span id="avatar-initials">
                            <?php echo strtoupper(substr(esc_html($current_user->user_nicename ?? 'U'), 0, 1)); ?>
                        </span>
                        
                        <img id="avatar-preview" src="" alt="Profile Preview" class="w-full h-full object-cover hidden absolute inset-0">
                    </div>

                    <div class="flex gap-3">
                        
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/jpeg, image/png, image/webp" class="hidden" onchange="previewAvatar(event)">
                        
                        <label
                            for="profile_picture"
                            class="cursor-pointer inline-block px-5 py-2.5 rounded-full text-xs font-bold border transition-all duration-200 bg-white text-neutral-800 border-neutral-300 hover:bg-neutral-50 hover:border-neutral-400 active:scale-98 dark:bg-neutral-900 dark:text-neutral-200 dark:border-neutral-700 dark:hover:bg-neutral-800 dark:hover:border-neutral-600"
                        >
                            Upload new picture
                        </label>

                        <button
                            type="button"
                            onclick="removeAvatar()"
                            class="px-5 py-2.5 rounded-full text-xs font-bold transition-colors duration-200 bg-[#FF4C62] text-white hover:bg-[#E03A4F] dark:bg-[#FF4C62] dark:text-white dark:hover:bg-[#FF6275]"
                        >
                            Delete
                        </button>
                    </div>
                </div>

                <div class="space-y-6">

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                            Name <span class="text-red-500">*</span>
                        </label>

                    <input
                        type="text"
                        name="nickname"
                        value="<?php echo esc_attr($current_user->user_nicename); ?>"
                        class="w-full px-4 py-3 border rounded-xl text-sm transition-all duration-200 focus:outline-none bg-white text-neutral-900 border-neutral-200 placeholder:text-neutral-400 focus:border-neutral-400 focus:ring-1 focus:ring-neutral-400  dark:bg-[#18181B] dark:text-neutral-100 dark:border-neutral-800 dark:placeholder:text-neutral-600 dark:focus:border-neutral-600 dark:focus:ring-1 dark:focus:ring-neutral-600"
                        required
                    >
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                            Location
                        </label>

                            <input
                                type="text"
                                name="location"
                                value="Lviv, Ukraine"
                                class="w-full px-4 py-3 border rounded-xl text-sm transition-all duration-200 focus:outline-none bg-white text-neutral-900 border-neutral-200 placeholder:text-neutral-400 focus:border-neutral-400 focus:ring-1 focus:ring-neutral-400 dark:bg-[#18181B] dark:text-neutral-100 dark:border-neutral-800 dark:placeholder:text-neutral-600 dark:focus:border-neutral-600 dark:focus:ring-1 dark:focus:ring-neutral-600"
                            >
                    </div>

                    <!-- Bio -->
                    <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="text-sm font-bold text-gray-900 dark:text-white">
                        Bio
                    </label>

                    <span id="bio-counter" class="text-[11px] text-gray-400 dark:text-gray-500">
                        0/1024
                    </span> 
                </div>

                    <textarea
                        id="bio"
                        name="bio"
                        rows="5"
                        maxlength="1024"
                        placeholder="Tell your travel story..."
                        class="w-full px-4 py-3 border rounded-xl text-sm resize-y transition-all duration-200 focus:outline-none bg-white text-neutral-900 border-neutral-200 placeholder:text-neutral-400 focus:border-neutral-400 focus:ring-1 focus:ring-neutral-400 dark:bg-[#18181B] dark:text-neutral-100 dark:border-neutral-800 dark:placeholder:text-neutral-600 dark:focus:border-neutral-600 dark:focus:ring-1 dark:focus:ring-neutral-600"
                    ></textarea>

                    </div>

                </div>
            </div>

        </div>


        <!-- SAVE -->
        <div class="flex justify-end pt-4">
        <button
            type="submit"
            class="px-6 py-3 text-sm font-bold rounded-full transition-all duration-200 shadow-sm active:scale-98 bg-black text-white hover:bg-neutral-800 hover:shadow-md dark:bg-white dark:hover:bg-[#DFE2DF] dark:text-black dark:hover:bg-neutral-100 dark:hover:shadow-none"
        >
            Change
        </button>
        </div>

    </form>
</section>