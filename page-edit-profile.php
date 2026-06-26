<div class="max-w-2xl mx-auto py-10">

    <h1 class="text-2xl font-semibold mb-6 text-neutral-900 dark:text-white">
        Edit Profile
    </h1>

    <form method="POST" class="space-y-5">

        <!-- Avatar -->
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl overflow-hidden border">
                <?php echo get_avatar($current_user->ID, 64); ?>
            </div>

            <p class="text-sm text-neutral-500">
                Avatar managed via Gravatar
            </p>
        </div>

        <!-- Display Name -->
        <div>
            <label class="text-sm text-neutral-600 dark:text-neutral-300">Display name</label>
            <input type="text" name="display_name"
                   value="<?php echo esc_attr($current_user->display_name); ?>"
                   class="w-full mt-1 px-4 py-2 rounded-xl border bg-white dark:bg-neutral-900" />
        </div>

        <!-- Email -->
        <div>
            <label class="text-sm text-neutral-600 dark:text-neutral-300">Email</label>
            <input type="email" name="user_email"
                   value="<?php echo esc_attr($current_user->user_email); ?>"
                   class="w-full mt-1 px-4 py-2 rounded-xl border bg-white dark:bg-neutral-900" />
        </div>

        <!-- Bio -->
        <div>
            <label class="text-sm text-neutral-600 dark:text-neutral-300">Bio</label>
            <textarea name="bio" rows="4"
                      class="w-full mt-1 px-4 py-2 rounded-xl border bg-white dark:bg-neutral-900"><?php
                echo esc_textarea(get_user_meta($current_user->ID, 'description', true));
            ?></textarea>
        </div>

        <!-- Submit -->
        <button type="submit" name="update_profile"
                class="px-5 py-2 rounded-xl bg-black text-white dark:bg-white dark:text-black">
            Save changes
        </button>

    </form>
</div>

<?php get_footer(); ?>