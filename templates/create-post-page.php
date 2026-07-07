<?php
/**
 * Template Name: Create Post Page
 */

if (!defined('ABSPATH')) {
    exit;
}

$page_title = get_the_title();
$categories = get_categories([
    'hide_empty' => false,
]);

get_header();
?>

<main class="main">
    <div class="create-post py-[100px] min-h-screen bg-[#FAFAFA] dark:bg-[#0E0E10] transition-colors duration-200 text-[#1D1D1F] dark:text-[#F5F5F7] mx-auto px-5 xl:px-10 2xl:px-0">

        <div class="container">
            <?php require PATH . '/components/breadcrumbs/component.php'; ?>
            <?php require PATH . '/components/profile/component.php'; ?>
        </div>

        <!-- Hero -->
        <div class="container relative mb-8 overflow-hidden rounded-[28px] border border-gray-200/70 bg-white p-10 lg:p-14 dark:border-[#232125] dark:bg-[#18181B]">

            <div
                class="pointer-events-none absolute -top-24 -right-24 h-72 w-72
                       rounded-full bg-violet-500/10 blur-3xl
                       dark:bg-violet-500/20" 
            ></div>

            <div
                class="pointer-events-none absolute -bottom-20 -left-20 h-64 w-64
                       rounded-full bg-fuchsia-500/10 blur-3xl
                       dark:bg-fuchsia-500/15"
            ></div>

            <div class="relative z-10">

                <h1 class="mt-6 text-4xl font-bold tracking-tight text-slate-900 dark:text-white lg:text-5xl">
                    <?php echo esc_html($page_title); ?>
                </h1>

                <p class="mt-4 max-w-2xl text-lg leading-8 text-slate-600 dark:text-slate-400">
                    <?php _e('Write your thoughts, upload media, organize categories, and publish beautiful content.', THEME); ?>                   
                </p>

            </div>
        </div>
        <?php require PATH . "/components/profileSubnav/component.php"; ?>
        <div class="container grid items-start gap-8 xl:grid-cols-[280px_minmax(0,1fr)] mt-12">

            <?php require PATH . "/components/account-sidebar/component.php"; ?>

            <form
                id="createPostForm"
                method="POST"
                enctype="multipart/form-data"
                class=""
                novalidate
            >
                <?php wp_nonce_field('theme_create_post', 'theme_create_post_nonce'); ?>
                <input type="hidden" name="action" value="theme_create_post">

                <!-- Basic Information -->
                <section class="rounded-[28px] border border-gray-200/70 bg-white shadow-sm shadow-slate-900/[0.02] dark:border-[#232125] dark:bg-[#18181B] lg:p-10" >

                    <div class="mb-8 flex items-center gap-4">

                        <div
                            class="flex h-14 w-14 shrink-0 items-center justify-center
                                rounded-2xl bg-violet-100
                                dark:bg-violet-500/10"
                        >
                            <svg class="h-7 w-7 text-violet-600 dark:text-violet-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.586-9.414a2 2 0 112.828 2.828L11 15l-4 1 1-4 9.414-9.414z" />
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                                <?php _e('Basic information', THEME); ?>
                            </h2>
                            <p class="mt-1 text-slate-500 dark:text-slate-400">
                                <?php _e('Title, excerpt and article content.', THEME); ?>
                            </p>
                        </div>

                    </div>

                    <div class="space-y-6">

                        <div>
                            <label for="post_title" class="mb-3 block text-sm font-semibold uppercase tracking-wide text-slate-700 dark:text-slate-300">
                                <?php _e('Title', THEME); ?>
                            </label>
                            <input
                                id="post_title"
                                name="post_title"
                                type="text"
                                required
                                maxlength="120"
                                placeholder="Enter post title..."
                                class="w-full rounded-2xl
                                    border border-gray-200
                                    bg-[#FAFAFA]
                                    px-5 py-4 text-lg text-slate-900
                                    outline-none transition
                                    placeholder:text-slate-400
                                    focus:border-violet-500 focus:bg-white focus:ring-4 focus:ring-violet-500/10
                                    dark:border-[#2A2A2E] dark:bg-[#111114] dark:text-white
                                    dark:placeholder:text-slate-500
                                    dark:focus:border-violet-500 dark:focus:bg-[#0F0F11] dark:focus:ring-violet-500/15"
                            >
                        </div>

                        <div>
                            <div class="mb-3 flex items-end justify-between">
                                <label for="post_excerpt" class="block text-sm font-semibold uppercase tracking-wide text-slate-700 dark:text-slate-300">
                                    <?php _e('Excerpt', THEME); ?>
                                </label>
                                <span class="text-xs text-slate-400 dark:text-slate-500"><?php _e('Optional', THEME); ?></span>
                            </div>
                            <textarea
                                id="post_excerpt"
                                name="post_excerpt"
                                rows="3"
                                maxlength="240"
                                placeholder="Write a short description..."
                                class="w-full resize-none rounded-2xl
                                    border border-gray-200
                                    bg-[#FAFAFA]
                                    px-5 py-4 text-slate-900
                                    outline-none transition
                                    placeholder:text-slate-400
                                    focus:border-violet-500 focus:bg-white focus:ring-4 focus:ring-violet-500/10
                                    dark:border-[#2A2A2E] dark:bg-[#111114] dark:text-white
                                    dark:placeholder:text-slate-500
                                    dark:focus:border-violet-500 dark:focus:bg-[#0F0F11] dark:focus:ring-violet-500/15"
                            ></textarea>
                        </div>

                        <div>
                            <label for="post_content" class="mb-3 block text-sm font-semibold uppercase tracking-wide text-slate-700 dark:text-slate-300">
                                <?php _e('Content', THEME); ?>
                            </label>
                            <textarea
                                id="post_content"
                                name="post_content"
                                rows="14"
                                required
                                placeholder="Start writing..."
                                class="w-full resize-y rounded-2xl
                                    border border-gray-200
                                    bg-[#FAFAFA]
                                    px-5 py-4 text-slate-900
                                    outline-none transition
                                    placeholder:text-slate-400
                                    focus:border-violet-500 focus:bg-white focus:ring-4 focus:ring-violet-500/10
                                    dark:border-[#2A2A2E] dark:bg-[#111114] dark:text-white
                                    dark:placeholder:text-slate-500
                                    dark:focus:border-violet-500 dark:focus:bg-[#0F0F11] dark:focus:ring-violet-500/15"
                            ></textarea>
                        </div>

                    </div>

                </section>

                <!-- Media -->
                <section
                    class="rounded-[28px]
                        border border-gray-200/70
                        bg-white p-8
                        shadow-sm shadow-slate-900/[0.02]
                        dark:border-[#232125]
                        dark:bg-[#18181B]
                        lg:p-10"
                >

                    <div class="mb-8 flex items-center gap-4">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-fuchsia-100 dark:bg-fuchsia-500/10">
                            <svg class="h-7 w-7 text-fuchsia-600 dark:text-fuchsia-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 dark:text-white"><?php _e('Media', THEME); ?></h2>
                            <p class="mt-1 text-slate-500 dark:text-slate-400"><?php _e('Upload images, gallery and video.', THEME); ?></p>
                        </div>
                    </div>

                    <div class="grid gap-5 lg:grid-cols-2">

                        <label
                            data-upload-target="thumbnailPreview"
                            class="group relative flex min-h-[220px] cursor-pointer flex-col items-center justify-center gap-3
                                overflow-hidden rounded-2xl border-2 border-dashed border-gray-200
                                bg-[#FAFAFA] text-center transition
                                hover:border-violet-400 hover:bg-violet-50/40
                                dark:border-[#2A2A2E] dark:bg-[#111114]
                                dark:hover:border-violet-500 dark:hover:bg-violet-500/[0.04]"
                        >
                            <input id="thumbnail" type="file" name="thumbnail" accept="image/*" class="hidden">
                            <div id="thumbnailPreview" class="flex flex-col items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm ring-1 ring-gray-200 transition group-hover:text-violet-500 dark:bg-[#18181B] dark:ring-[#2A2A2E]">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="text-base font-semibold text-slate-900 dark:text-white"><?php _e('Featured image', THEME); ?></span>
                                <span class="text-sm text-slate-500 dark:text-slate-500"><?php _e('PNG or JPG, up to 5&nbsp;MB', THEME); ?></span>
                            </div>
                        </label>

                        <label
                            data-upload-target="videoPreview"
                            class="group relative flex min-h-[220px] cursor-pointer flex-col items-center justify-center gap-3
                                overflow-hidden rounded-2xl border-2 border-dashed border-gray-200
                                bg-[#FAFAFA] text-center transition
                                hover:border-violet-400 hover:bg-violet-50/40
                                dark:border-[#2A2A2E] dark:bg-[#111114]
                                dark:hover:border-violet-500 dark:hover:bg-violet-500/[0.04]"
                        >
                            <input id="video" type="file" name="video" accept="video/*" class="hidden">
                            <div id="videoPreview" class="flex flex-col items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm ring-1 ring-gray-200 transition group-hover:text-violet-500 dark:bg-[#18181B] dark:ring-[#2A2A2E]">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="text-base font-semibold text-slate-900 dark:text-white"><?php _e('Video', THEME); ?></span>
                                <span class="text-sm text-slate-500 dark:text-slate-500"><?php _e('MP4 or MOV, up to 50&nbsp;MB', THEME); ?></span>
                            </div>
                        </label>

                    </div>

                    <div class="mt-5">
                        <label
                            data-upload-target="galleryPreview"
                            class="group relative flex min-h-[220px] cursor-pointer flex-col items-center justify-center gap-3
                                overflow-hidden rounded-2xl border-2 border-dashed border-gray-200
                                bg-[#FAFAFA] text-center transition
                                hover:border-violet-400 hover:bg-violet-50/40
                                dark:border-[#2A2A2E] dark:bg-[#111114]
                                dark:hover:border-violet-500 dark:hover:bg-violet-500/[0.04]"
                        >
                            <input id="gallery" type="file" name="gallery[]" accept="image/*" multiple class="hidden">
                            <div id="galleryPreview" class="flex flex-col items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm ring-1 ring-gray-200 transition group-hover:text-violet-500 dark:bg-[#18181B] dark:ring-[#2A2A2E]">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7a2 2 0 012-2h3l2-2h4l2 2h3a2 2 0 012 2v11a2 2 0 01-2 2H5a2 2 0 01-2-2V7zM12 17a4 4 0 100-8 4 4 0 000 8z" />
                                    </svg>
                                </div>
                                <span class="text-lg font-semibold text-slate-900 dark:text-white"><?php _e('Gallery', THEME); ?></span>
                                <span class="text-sm text-slate-500 dark:text-slate-500"><?php _e('Up to 4 images', THEME); ?></span>
                            </div>
                        </label>
                    </div>

                </section>

                <!-- Categories & Tags -->
                <section
                    class="rounded-[28px]
                        border border-gray-200/70
                        bg-white p-8
                        shadow-sm shadow-slate-900/[0.02]
                        dark:border-[#232125]
                        dark:bg-[#18181B]
                        lg:p-10"
                >

                    <div class="grid gap-10 lg:grid-cols-2">

                        <div>
                            <h2 class="mb-1 text-2xl font-bold text-slate-900 dark:text-white"><?php _e('Categories', THEME); ?></h2>
                            <p class="mb-6 text-sm text-slate-500 dark:text-slate-400"><?php _e('Pick one or more.', THEME); ?></p>

                            <div class="flex flex-wrap gap-2.5">
                                <?php foreach ($categories as $category) : ?>
                                    <label class="cursor-pointer">
                                        <input
                                            type="checkbox"
                                            name="categories[]"
                                            value="<?php echo esc_attr($category->term_id); ?>"
                                            class="peer hidden"
                                        >
                                        <span
                                            class="inline-flex items-center rounded-full
                                                border border-gray-200
                                                px-4 py-2.5 text-sm font-medium
                                                text-slate-700 transition
                                                hover:border-violet-300 hover:text-violet-700
                                                peer-checked:border-violet-600 peer-checked:bg-violet-600 peer-checked:text-white
                                                peer-focus-visible:ring-4 peer-focus-visible:ring-violet-500/20
                                                dark:border-[#2A2A2E] dark:text-slate-300
                                                dark:hover:border-violet-500/60 dark:hover:text-violet-300
                                                dark:peer-checked:border-violet-500 dark:peer-checked:bg-violet-500 dark:peer-checked:text-white"
                                        >
                                            <?php echo esc_html($category->name); ?>
                                        </span>
                                    </label>
                                <?php endforeach; ?>

                                <?php if (empty($categories)) : ?>
                                    <p class="text-sm text-slate-400 dark:text-slate-500"><?php _e('No categories yet.', THEME); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div>
                            <h2 class="mb-1 text-2xl font-bold text-slate-900 dark:text-white"><?php _e('Tags', THEME); ?></h2>
                            <p class="mb-6 text-sm text-slate-500 dark:text-slate-400"><?php _e('Separate tags with commas.', THEME); ?></p>

                            <input
                                id="post_tags"
                                type="text"
                                name="post_tags"
                                placeholder="technology, design, wordpress..."
                                class="w-full rounded-2xl
                                    border border-gray-200
                                    bg-[#FAFAFA]
                                    px-5 py-4 text-slate-900
                                    outline-none transition
                                    placeholder:text-slate-400
                                    focus:border-violet-500 focus:bg-white focus:ring-4 focus:ring-violet-500/10
                                    dark:border-[#2A2A2E] dark:bg-[#111114] dark:text-white
                                    dark:placeholder:text-slate-500
                                    dark:focus:border-violet-500 dark:focus:bg-[#0F0F11] dark:focus:ring-violet-500/15"
                            >
                        </div>

                    </div>

                </section>

                <!-- Actions -->
                <div
                    class="sticky bottom-4 z-10 flex flex-col-reverse gap-3
                        rounded-[24px] border border-gray-200/70 bg-white/90 p-4
                        shadow-lg shadow-slate-900/5 backdrop-blur
                        dark:border-[#232125] dark:bg-[#18181B]/90
                        sm:flex-row sm:justify-end"
                >
                    <button
                        type="button"
                        name="save_draft"
                        class="rounded-2xl
                            border border-gray-200
                            bg-white px-8 py-4
                            font-medium text-slate-700
                            transition
                            hover:border-slate-300 hover:bg-slate-50
                            focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-slate-500/10
                            dark:border-[#2A2A2E] dark:bg-[#111114] dark:text-slate-200
                            dark:hover:border-[#3A3A3E] dark:hover:bg-[#18181B]"
                    >
                        <?php _e('Save draft', THEME); ?>
                    </button>

                    <button
                        type="submit"
                        class="rounded-2xl
                            bg-gradient-to-r from-violet-600 to-fuchsia-600
                            px-8 py-4 font-semibold text-white
                            shadow-lg shadow-violet-500/25
                            transition
                            hover:scale-[1.02] hover:shadow-violet-500/35
                            focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-violet-500/30
                            active:scale-[0.99]"
                    >
                        <?php _e('Publish post', THEME); ?>
                    </button>
                </div>

            </form>

        </div>
    </div>
</main>

<?php get_footer(); ?>