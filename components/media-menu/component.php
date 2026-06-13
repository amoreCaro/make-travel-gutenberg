<?php

if (!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Media Menu'))
    ->set_category('media')
    ->set_icon('grid-view')

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
    ])

    ->set_render_callback(function ($fields) {

        /**
         * Selected data from Carbon Fields block
         */
        $selected_categories = $fields['media_categories'] ?? [];

        $selected_tags       = $fields['media_tags'] ?? [];

        /**
         * Convert categories
         */
        $categories = !empty($selected_categories)
            ? get_terms([
                'taxonomy'   => 'category',
                'include'    => $selected_categories,
                'hide_empty' => true,
            ])
            : [];

        /**
         * Convert tags
         */
        $tags = !empty($selected_tags)
            ? get_terms([
                'taxonomy'   => 'post_tag',
                'include'    => $selected_tags,
                'hide_empty' => true,
            ])
            : [];

        /**
         * Current object
         */
        $current = get_queried_object();

        $current_category_id = ($current instanceof WP_Term && $current->taxonomy === 'category')
            ? $current->term_id
            : null;

        $current_tag_id = ($current instanceof WP_Term && $current->taxonomy === 'post_tag')
            ? $current->term_id
            : null;

        /**
         * "All news" is active when no specific category or tag is selected
         */
        $all_active = ($current_category_id === null && $current_tag_id === null);

        ?>

        <div class="media-menu absolute w-full top-[80px] z-50 bg-[#F6F5F8] dark:bg-[#0B0B0D] flex flex-col py-2">

            <div class="container w-full mx-auto px-5 xl:px-0">

                <!-- HEADER -->
                <div class="media-menu__head flex items-center justify-between">

                    <!-- MOBILE BUTTON -->
                    <?php if (!empty($categories)) : ?>
                        <button class="media-menu__categories-btn flex items-center gap-2 md:hidden py-3 text-slate-400 hover:text-blue-600">
                            <span class="font-bold uppercase text-[15px]">
                                <?php _e("Category", THEME); ?>
                            </span>
                        </button>
                    <?php endif; ?>

                    <!-- DESKTOP CATEGORIES -->
                    <div class="media-menu__categories-content hidden md:block overflow-x-auto no-scrollbar">
                        <ul class="flex items-center gap-8 whitespace-nowrap">

                            <!-- ALL -->
                            <li>
                                <a href="<?php echo esc_url(home_url('/blog/')); ?>"
                                   class="media-menu__tab <?php echo esc_attr($all_active ? 'active' : ''); ?> uppercase block py-3 text-[15px] font-bold hover:text-black dark:hover:text-white">
                                    <?php _e("All news", THEME); ?>
                                </a>
                            </li>

                            <!-- CATEGORIES -->
                            <?php if (!empty($categories)) : ?>
                                <?php foreach ($categories as $category) : ?>
                                    <?php $active = ($current_category_id === $category->term_id) ? 'active' : ''; ?>

                                    <li>
                                        <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                                           class="media-menu__tab <?php echo esc_attr($active); ?> uppercase block py-3 text-[15px] font-bold hover:text-black dark:hover:text-white">
                                            <?php echo esc_html($category->name); ?>
                                        </a>
                                    </li>

                                <?php endforeach; ?>
                            <?php endif; ?>

                        </ul>
                    </div>

                    <!-- TAGS BUTTON -->
                    <?php if (!empty($tags)) : ?>
                        <button class="media-menu__tags-btn uppercase font-bold text-[15px] text-slate-400 hover:text-blue-600">
                            <?php _e("All tags", THEME); ?>
                        </button>
                    <?php endif; ?>

                </div>

                <!-- TAGS -->
                <?php if (!empty($tags)) : ?>
                    <div class="media-menu__tags overflow-hidden transition-all duration-500 max-h-0 opacity-0">
                        <ul class="grid grid-cols-1 md:grid-cols-3 gap-y-4 py-8">

                            <?php foreach ($tags as $tag) : ?>
                                <li>
                                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                                       class="uppercase text-[15px] font-bold text-[#9395ab] hover:text-black dark:hover:text-white">
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
    });