<?php
if (!defined('ABSPATH')) {
    exit;
}

// Fetch categories with counts included
$categories = get_categories([
    'hide_empty' => false,
]);

$tags = get_tags(['hide_empty' => false]);

$maxCategories = 3;
$maxTags = 5;
?>

<section class="mx-auto max-w-4xl px-4 py-10 text-slate-800 dark:text-slate-200">
    <form
        id="createPostForm"
        method="POST"
        enctype="multipart/form-data"
        novalidate
        class="space-y-8"
    >
        <input type="hidden" name="action" value="theme_create_post">
        <?php wp_nonce_field('theme_create_post', 'theme_create_post_nonce'); ?>

        <!-- Featured Image Upload Dropzone -->
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-600 dark:text-slate-400">
                <?php _e('Featured image', THEME); ?>
            </label>
            <label
                id="thumbnailUpload"
                data-state="empty"
                class="group relative flex min-h-[180px] cursor-pointer flex-col items-center justify-center overflow-hidden rounded-xl border border-dashed border-gray-300 bg-white text-center transition hover:border-violet-500 dark:border-zinc-700 dark:bg-zinc-900"
            >
                <input
                    id="thumbnail"
                    type="file"
                    name="thumbnail"
                    accept="image/*"
                    class="hidden"
                >

                <img
                    id="thumbnailImage"
                    alt=""
                    class="hidden h-full w-full object-cover group-data-[state=selected]:block"
                >

                <button
                    id="thumbnailRemove"
                    type="button"
                    class="absolute right-4 top-4 hidden h-8 w-8 items-center justify-center rounded-full bg-slate-900/10 text-slate-700 backdrop-blur hover:bg-red-500 hover:text-white group-data-[state=selected]:flex dark:bg-white/10 dark:text-zinc-300"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6L18 18M6 18L18 6" />
                    </svg>
                </button>

                <div class="flex flex-col items-center gap-2 p-6 group-data-[state=selected]:hidden">
                    <div class="text-slate-400 group-hover:text-violet-500">
                        <svg class="h-10 w-10 mx-auto stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-violet-600 dark:text-violet-400">
                        <?php _e('Upload a file', THEME); ?>
                    </span>
                    <span class="text-xs text-slate-400 dark:text-slate-500">
                        PNG, JPG, GIF, WEBP, SVG ...
                    </span>
                </div>
            </label>
        </div>

        <!-- Video Upload Dropzone -->
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-600 dark:text-slate-400">
                <?php _e('Video', THEME); ?>
                <span class="text-xs font-normal text-slate-400 dark:text-slate-500">(<?php _e('optional', THEME); ?>)</span>
            </label>
            <label
                id="videoUpload"
                data-state="empty"
                class="group relative flex min-h-[180px] cursor-pointer flex-col items-center justify-center overflow-hidden rounded-xl border border-dashed border-gray-300 bg-white text-center transition hover:border-violet-500 dark:border-zinc-700 dark:bg-zinc-900"
            >
                <input
                    id="video"
                    type="file"
                    name="video"
                    accept="video/mp4,video/webm,video/quicktime"
                    class="hidden"
                >

                <video
                    id="videoPreview"
                    class="hidden h-full w-full object-cover group-data-[state=selected]:block"
                    muted
                    playsinline
                    loop
                ></video>

                <button
                    id="videoRemove"
                    type="button"
                    class="absolute right-4 top-4 hidden h-8 w-8 items-center justify-center rounded-full bg-slate-900/10 text-slate-700 backdrop-blur hover:bg-red-500 hover:text-white group-data-[state=selected]:flex dark:bg-white/10 dark:text-zinc-300"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6L18 18M6 18L18 6" />
                    </svg>
                </button>

                <div class="flex flex-col items-center gap-2 p-6 group-data-[state=selected]:hidden">
                    <div class="text-slate-400 group-hover:text-violet-500">
                        <svg class="h-10 w-10 mx-auto stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-violet-600 dark:text-violet-400">
                        <?php _e('Upload a file', THEME); ?>
                    </span>
                    <span class="text-xs text-slate-400 dark:text-slate-500">
                        MP4, WEBM, MOV — <?php _e('up to 50 MB', THEME); ?>
                    </span>
                </div>
            </label>
        </div>

        <!-- Gallery Upload Dropzone -->
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-600 dark:text-slate-400">
                <?php _e('Gallery', THEME); ?>
                <span class="text-xs font-normal text-slate-400 dark:text-slate-500">(<?php _e('up to 4 images', THEME); ?>)</span>
            </label>
            <label
                id="galleryUpload"
                data-state="empty"
                class="group relative flex min-h-[140px] cursor-pointer flex-col items-center justify-center overflow-hidden rounded-xl border border-dashed border-gray-300 bg-white text-center transition hover:border-violet-500 dark:border-zinc-700 dark:bg-zinc-900"
            >
                <input
                    id="gallery"
                    type="file"
                    name="gallery[]"
                    accept="image/*"
                    multiple
                    class="hidden"
                >

                <div
                    id="galleryPreview"
                    class="hidden w-full flex-wrap gap-2 p-4 group-data-[state=selected]:flex"
                ></div>

                <div class="flex flex-col items-center gap-2 p-6 group-data-[state=selected]:hidden">
                    <div class="text-slate-400 group-hover:text-violet-500">
                        <svg class="h-10 w-10 mx-auto stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h3l2-2h4l2 2h3a2 2 0 012 2v11a2 2 0 01-2 2H5a2 2 0 01-2-2V7zM12 17a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-violet-600 dark:text-violet-400">
                        <?php _e('Upload files', THEME); ?>
                    </span>
                    <span class="text-xs text-slate-400 dark:text-slate-500">
                        PNG, JPG, WEBP ...
                    </span>
                </div>
            </label>
        </div>

        <!-- Categories Picker Area -->
        <div class="relative" id="categoriesField">
            <label class="mb-2 block text-sm font-medium text-slate-600 dark:text-slate-400">
                <?php _e('Categories', THEME); ?>
            </label>

            <div
                id="categoriesInputWrap"
                class="flex flex-wrap items-center gap-2 rounded-lg py-1"
            >
                <div id="categoriesChips" class="flex flex-wrap items-center gap-2"></div>

                <button
                    id="categoriesInput"
                    type="button"
                    data-max="<?php echo (int) $maxCategories; ?>"
                    class="flex-1 text-left text-sm text-slate-400 outline-none"
                >
                    <?php echo esc_html(sprintf(__('Add categories (0/%d)', THEME), $maxCategories)); ?>
                </button>
            </div>

            <p
                id="categoriesError"
                class="mt-1 hidden text-xs text-red-500"
            >
                <?php echo esc_html(sprintf(__('Maximum %d categories allowed.', THEME), $maxCategories)); ?>
            </p>

            <div
                id="categoriesPanel"
                data-state="closed"
                class="absolute z-20 mt-2 hidden w-full rounded-2xl border border-gray-100 bg-white p-6 shadow-xl shadow-slate-200/50 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-none"
            >
                <h3 class="mb-4 text-base font-bold text-slate-900 dark:text-white">
                    <?php _e('Categories', THEME); ?>
                </h3>

                <div id="categoriesList" class="flex flex-wrap gap-2">
                    <?php foreach ($categories as $category) : ?>
                        <button
                            type="button"
                            class="category-panel-item inline-flex items-center rounded-lg border border-transparent bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-100 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700"
                            data-id="<?php echo esc_attr($category->term_id); ?>"
                            data-name="<?php echo esc_attr($category->name); ?>"
                        >
                            <?php echo esc_html($category->name); ?>
                            (<?php echo $category->count; ?>)
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div id="categoryChipPrototype" class="hidden">
                <span class="inline-flex items-center gap-1 rounded-lg border border-transparent bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-700 dark:bg-zinc-800 dark:text-zinc-300">
                    <span class="category-chip-text"></span>

                    <button
                        type="button"
                        class="category-chip-remove ml-1 text-slate-400 transition hover:text-red-500"
                    >
                        ×
                    </button>

                    <input
                        class="category-chip-input"
                        type="hidden"
                        name="categories[]"
                    >
                </span>
            </div>
        </div>

        <!-- Inline Content Fields (Title, Tags, Content) -->
        <div class="space-y-4">
            <!-- Article Title -->
            <input
                id="post_title"
                name="post_title"
                type="text"
                required
                maxlength="120"
                placeholder="<?php _e('Enter post title...', THEME); ?>"
                class="w-full bg-transparent py-2 text-4xl font-bold tracking-tight text-slate-900 outline-none placeholder:text-slate-300 dark:text-white dark:placeholder:text-zinc-700"
            >

            <!-- Tags Field -->
            <div class="relative" id="tagsField">
                <label class="mb-2 block text-sm font-medium text-slate-600 dark:text-slate-400">
                    <?php _e('Tags', THEME); ?>
                </label>

                <div
                    id="tagsInputWrap"
                    class="flex flex-wrap items-center gap-2 rounded-lg py-1"
                >
                    <div id="tagsChips" class="flex flex-wrap items-center gap-2"></div>

                    <input
                        id="post_tags_input"
                        type="text"
                        autocomplete="off"
                        data-max="<?php echo (int) $maxTags; ?>"
                        placeholder="<?php echo esc_attr(sprintf(__('Add tag (0/%d)', THEME), $maxTags)); ?>"
                        class="min-w-[100px] flex-1 bg-transparent py-1 text-sm text-slate-600 outline-none placeholder:text-slate-400 dark:text-zinc-400 dark:placeholder:text-zinc-600"
                    >
                </div>

                <input
                    type="hidden"
                    id="post_tags"
                    name="post_tags"
                    value=""
                >

                <p
                    id="tagsError"
                    class="mt-1 hidden text-xs text-red-500"
                >
                    <?php echo esc_html(sprintf(__('Maximum %d tags allowed.', THEME), $maxTags)); ?>
                </p>

                <div
                    id="tagsPanel"
                    data-state="closed"
                    class="absolute z-20 mt-2 hidden w-full rounded-2xl border border-gray-100 bg-white p-6 shadow-xl shadow-slate-200/50 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-none"
                >
                    <h3 class="mb-4 text-base font-bold text-slate-900 dark:text-white">
                        <?php _e('Tags', THEME); ?>
                    </h3>

                    <div id="tagsList" class="flex flex-wrap gap-2">
                        <?php foreach ($tags as $tag) : ?>
                            <button
                                type="button"
                                class="tags-panel-item inline-flex items-center rounded-lg border border-transparent bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-100 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700"
                                data-tag="<?php echo esc_attr($tag->name); ?>"
                            >
                                #<?php echo esc_html($tag->name); ?>
                                (<?php echo $tag->count; ?>)
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Prototype -->
                <div id="tagChipPrototype" class="hidden">
                    <span class="inline-flex items-center gap-1 rounded-lg border border-transparent bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-700 dark:bg-zinc-800 dark:text-zinc-300">
                        <span class="tag-chip-text"></span>

                        <button
                            type="button"
                            class="tag-chip-remove ml-1 text-slate-400 transition hover:text-red-500"
                        >
                            ×
                        </button>
                    </span>
                </div>
            </div>

            <!-- Excerpt (Optional short description) -->
            <div>
                <textarea
                    id="post_excerpt"
                    name="post_excerpt"
                    rows="2"
                    maxlength="240"
                    placeholder="<?php _e('Write a short description...', THEME); ?>"
                    class="w-full resize-none bg-transparent py-2 text-base text-slate-600 outline-none placeholder:text-slate-400 dark:text-zinc-400 dark:placeholder:text-zinc-600"
                ></textarea>
            </div>

            <!-- Main Editor Content Body -->
            <div class="pt-4 border-t border-gray-100 dark:border-zinc-800">
                <textarea
                    id="post_content"
                    name="post_content"
                    rows="12"
                    placeholder="<?php _e('Start writing...', THEME); ?>"
                    class="w-full resize-y bg-transparent py-2 text-lg leading-relaxed text-slate-800 outline-none placeholder:text-slate-300 dark:text-zinc-200 dark:placeholder:text-zinc-700"
                ></textarea>
            </div>
        </div>

        <!-- Action Floating / Sticky Bar -->
        <div class="sticky bottom-4 z-10 flex items-center justify-between rounded-xl border border-gray-200 bg-white/80 p-3 shadow-lg backdrop-blur dark:border-zinc-800 dark:bg-zinc-900/80">
            <div class="text-xs text-slate-400 dark:text-zinc-500 px-2">
                <?php _e('Draft auto-saved', THEME); ?>
            </div>
            <button
                type="submit"
                class="rounded-lg bg-slate-900 px-5 py-2 text-sm font-semibold text-white shadow transition hover:bg-slate-800 active:scale-[0.98] dark:bg-white dark:text-slate-900 dark:hover:bg-zinc-100"
            >
                <?php _e('Publish', THEME); ?>
            </button>
        </div>

    </form>
</section>