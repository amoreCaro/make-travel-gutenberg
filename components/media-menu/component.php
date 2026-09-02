<?php

if (!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('post_meta', __('Media Menu'))
    ->where('post_id', '=', get_option('page_for_posts') ?: (function () {
        $blog_page = get_page_by_path('blog');
        return $blog_page ? $blog_page->ID : 0;
    })())

    ->add_fields([

        Field::make('multiselect', 'media_categories', __('Categories'))
            ->set_options(function () {

                $terms = get_terms([
                    'taxonomy'   => 'category',
                    'hide_empty' => true,
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                ]);

                $options = [];

                if (!is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        $options[$term->term_id] = $term->name;
                    }
                }

                return $options;
            }),

        Field::make('multiselect', 'media_tags', __('Tags'))
            ->set_options(function () {

                $terms = get_terms([
                    'taxonomy'   => 'post_tag',
                    'hide_empty' => true,
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                ]);

                $options = [];

                if (!is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        $options[$term->term_id] = $term->name;
                    }
                }

                return $options;
            }),

    ]);
    function render_media_menu()
{

    $blog_page_id = get_option('page_for_posts') ?: (function () {
        $blog_page = get_page_by_path('blog');
        return $blog_page ? $blog_page->ID : 0;
    })();

    /* META */
    $selected_categories = carbon_get_post_meta($blog_page_id, 'media_categories') ?: [];
    $selected_tags       = carbon_get_post_meta($blog_page_id, 'media_tags') ?: [];

    $categories = !empty($selected_categories)
        ? get_terms([
            'taxonomy'   => 'category',
            'include'    => $selected_categories,
            'hide_empty' => true,
            'orderby'    => 'include',
        ])
        : [];

    $tags = !empty($selected_tags)
        ? get_terms([
            'taxonomy'   => 'post_tag',
            'include'    => $selected_tags,
            'hide_empty' => true,
            'orderby'    => 'include',
        ])
        : [];

    $current = get_queried_object();

    $current_category_id =
        ($current instanceof WP_Term && $current->taxonomy === 'category')
            ? $current->term_id
            : null;

    $current_tag_id =
        ($current instanceof WP_Term && $current->taxonomy === 'post_tag')
            ? $current->term_id
            : null;

    $blog_url = $blog_page_id
        ? get_permalink($blog_page_id)
        : home_url('/blog/');

    $is_blog = is_home() || is_page($blog_page_id);
    ?>

    <div class="media-menu absolute w-full top-[80px] z-50 bg-[#F6F5F8] px-5 dark:bg-[#0B0B0D] flex flex-col py-2">

        <div class="container w-full mx-auto">

            <!-- HEAD -->
            <div class="media-menu__head flex items-center justify-between">

                <?php if (!empty($categories)) : ?>
                    <button class="media-menu__categories-btn flex items-center gap-2 md:hidden py-3 text-slate-400 hover:text-blue-600">
                        <svg width="18" height="18" viewBox="0 0 18 18" class="fill-current">
                            <rect width="7" height="7" rx="1"></rect>
                            <rect x="11" width="7" height="7" rx="1"></rect>
                            <rect y="11" width="7" height="7" rx="1"></rect>
                            <rect x="11" y="11" width="7" height="7" rx="1"></rect>
                        </svg>

                        <span class="font-bold capitalize text-[15px] leading-[15px]">
                            <?php _e("Category", THEME); ?>
                        </span>
                    </button>
                <?php endif; ?>

                <!-- DESKTOP -->
                <div class="media-menu__categories-content hidden md:block overflow-x-auto no-scrollbar">
                    <ul class="flex items-center gap-8 whitespace-nowrap">

                        <li>
                            <a href="<?php echo esc_url($blog_url); ?>"
                               class="media-menu__tab <?php echo $is_blog ? 'active' : ''; ?> capitalize block py-3 text-[15px] leading-[18px] font-bold hover:text-black dark:hover:text-white">
                                <?php _e("All News", THEME); ?>
                            </a>
                        </li>

                        <?php foreach ($categories as $category): ?>
                            <li>
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                                   class="media-menu__tab <?php echo $current_category_id === $category->term_id ? 'active' : ''; ?> capitalize block py-3 text-[15px] leading-[18px] font-bold hover:text-black dark:hover:text-white">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                </div>

                <!-- TAG BUTTON -->
                <?php if (!empty($tags)) : ?>
                    <button class="media-menu__tags-btn cursor-pointer flex items-center gap-2 capitalize font-bold text-[15px] leading-[15px] transition-all duration-300 text-slate-400 hover:text-blue-600">
                        <?php _e("All Tags", THEME); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <path d="M6 9l6 6 6-6"></path>
                        </svg>
                    </button>
                <?php endif; ?>

            </div>

            <!-- MOBILE -->
            <div class="media-menu__navigation transition-all duration-500 max-h-0 opacity-0 mobile">
                <ul class="flex flex-col sm:flex-row items-start sm:items-center justify-start sm:justify-between w-full whitespace-nowrap">

                    <li class="flex-1 text-left">
                        <a href="<?php echo esc_url($blog_url); ?>"
                           class="media-menu__tab <?php echo $is_blog ? 'active' : ''; ?> capitalize py-3 text-[15px] leading-[18px] font-bold inline-block">
                            <?php _e("All News", THEME); ?>
                        </a>
                    </li>

                    <?php foreach ($categories as $category): ?>
                        <li class="flex-1 text-left">
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                               class="media-menu__tab <?php echo $current_category_id === $category->term_id ? 'active' : ''; ?> capitalize py-3 text-[15px] leading-[18px] font-bold inline-block">
                                <?php echo esc_html($category->name); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>

                </ul>
            </div>

            <!-- TAGS -->
            <?php if (!empty($tags)) : ?>
                <div class="media-menu__tags overflow-hidden transition-all duration-500 max-h-0 opacity-0">
                    <ul class="media-menu__tags-list grid grid-cols-1 md:grid-cols-3 gap-y-4 py-8">

                        <?php foreach ($tags as $tag): ?>
                            <li>
                                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                                   class="media-menu__tag <?php echo $current_tag_id === $tag->term_id ? 'active' : ''; ?> capitalize text-[15px] leading-[18px] font-bold text-[#9395ab] hover:text-[#252735] dark:hover:text-white transition-all duration-300">
                                    #<?php echo esc_html($tag->name); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <?php
}